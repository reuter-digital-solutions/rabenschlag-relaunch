<?php
/**
 * Formular-Hilfen: Spam-Schutz (Zeit-Token + Honeypot), Rate-Limit, Validierung, Antworten.
 * Kommt ohne Session/Cookies aus.
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';

/** Verstecktes Token (Zeitstempel + HMAC) und Honeypot-Feld. */
function form_guard(): string
{
    $ts = (string) time();
    $sig = hash_hmac('sha256', $ts, MAIL['secret']);
    return '<input type="hidden" name="_t" value="' . $ts . '.' . $sig . '">'
        . '<div class="hp" aria-hidden="true"><label>Website<input type="text" name="website" tabindex="-1" autocomplete="off"></label></div>';
}

/** Prüft Token und Honeypot. Liefert Fehlertext oder null. */
function check_guard(array $post): ?string
{
    if (!empty($post['website'])) {
        return 'spam';
    }
    $parts = explode('.', (string) ($post['_t'] ?? ''), 2);
    if (count($parts) !== 2 || !hash_equals(hash_hmac('sha256', $parts[0], MAIL['secret']), $parts[1])) {
        return 'Das Formular ist abgelaufen. Bitte laden Sie die Seite neu.';
    }
    $age = time() - (int) $parts[0];
    if ($age < 3) {
        return 'spam';
    }
    if ($age > 6 * 3600) {
        return 'Das Formular ist abgelaufen. Bitte laden Sie die Seite neu.';
    }
    return null;
}

/** Einfaches IP-basiertes Rate-Limit (Hash der IP, keine Klartext-Speicherung). */
function rate_limited(): bool
{
    $ip = $_SERVER['REMOTE_ADDR'] ?? '0';
    $file = sys_get_temp_dir() . '/rbs_rl_' . hash_hmac('sha256', $ip, MAIL['secret']) . '.json';
    $now = time();
    $hits = is_file($file) ? (json_decode((string) file_get_contents($file), true) ?: []) : [];
    $hits = array_values(array_filter($hits, fn($t) => $t > $now - 3600));
    if (count($hits) >= MAIL['rate_limit']) {
        return true;
    }
    $hits[] = $now;
    file_put_contents($file, json_encode($hits), LOCK_EX);
    return false;
}

/** Einzeilige Eingabe bereinigen (auch gegen Header-Injection). */
function clean_line(mixed $v, int $max = 200): string
{
    $v = is_string($v) ? $v : '';
    $v = preg_replace('/[\x00-\x1F\x7F]+/u', ' ', $v) ?? '';
    return mb_substr(trim($v), 0, $max);
}

function clean_text(mixed $v, int $max = 5000): string
{
    $v = is_string($v) ? $v : '';
    $v = str_replace(["\r\n", "\r"], "\n", $v);
    $v = preg_replace('/[\x00-\x08\x0B-\x1F\x7F]+/u', '', $v) ?? '';
    return mb_substr(trim($v), 0, $max);
}

function wants_json(): bool
{
    return str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json');
}

/** Antwort: JSON für fetch(), sonst Weiterleitung (Fallback ohne JavaScript). */
function respond(bool $ok, string $type, array $errors = [], string $message = ''): never
{
    if (wants_json()) {
        http_response_code($ok ? 200 : 422);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => $ok, 'errors' => (object) $errors, 'message' => $message], JSON_UNESCAPED_UNICODE);
        exit;
    }
    header('Location: ../' . ($ok ? 'danke?t=' . $type : 'fehler?t=' . $type), true, 303);
    exit;
}

function require_post(): void
{
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header('Location: ../', true, 303);
        exit;
    }
}
