<?php
/**
 * HTML-E-Mail-Vorlage im Look der Website.
 * Tabellenlayout + Inline-Styles für Outlook, Gmail, Apple Mail. Breite 600 px.
 */
declare(strict_types=1);

require_once __DIR__ . '/config.php';

const MC = [
    'ink'   => '#0E1314', 'ink2' => '#1D2628', 'paper' => '#F2F5F3', 'line' => '#DFE5E2',
    'teal'  => '#17BC9C', 'tealDeep' => '#0A7462', 'tint' => '#E1F5EF', 'onDark' => '#A6B1AD',
    'text2' => '#45504D', 'text3' => '#64706C', 'volt' => '#F4B83A',
];
const MFONT = "'Geist',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif";
const MMONO = "'Geist Mono',SFMono-Regular,Menlo,Consolas,monospace";

function me(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/**
 * @param array{
 *   preheader:string, badge:string, title:string, intro:string,
 *   chips?:string[], rows?:array<array{0:string,1:string,2?:bool}>,
 *   message_label?:string, message?:string,
 *   attachments?:array<array{0:string,1:int}>,
 *   actions?:array<array{0:string,1:string,2?:bool}>,
 *   steps?:array<array{0:string,1:string}>,
 *   contact_card?:bool, note?:string, logo_src?:string
 * } $o
 */
function render_mail(array $o): string
{
    $c = MC;
    $logo = $o['logo_src'] ?? 'cid:logo@rabenschlag';
    $h = '';

    // Datenzeilen
    $rows = '';
    foreach ($o['rows'] ?? [] as $i => $r) {
        [$label, $value] = $r;
        $isHtml = $r[2] ?? false;
        $rows .= '<tr><td style="padding:14px 0;border-top:' . ($i ? '1px solid ' . $c['line'] : '0') . ';font-family:' . MMONO . ';font-size:12px;letter-spacing:.02em;color:' . $c['text3'] . ';width:150px;vertical-align:top;text-transform:uppercase">' . me($label) . '</td>'
            . '<td style="padding:14px 0;border-top:' . ($i ? '1px solid ' . $c['line'] : '0') . ';font-family:' . MFONT . ';font-size:15px;line-height:1.5;color:' . $c['ink'] . ';font-weight:500;vertical-align:top">' . ($isHtml ? $value : me($value)) . '</td></tr>';
    }

    $chips = '';
    foreach ($o['chips'] ?? [] as $chip) {
        $chips .= '<span style="display:inline-block;margin:0 6px 6px 0;padding:6px 12px;border-radius:999px;background:rgba(23,188,156,.16);color:#8EEBD5;font-family:' . MFONT . ';font-size:13px;font-weight:600">' . me($chip) . '</span>';
    }

    $h .= '<!doctype html><html lang="de"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="color-scheme" content="light only"><title>' . me($o['title']) . '</title>'
        . '<style>@media (max-width:620px){.px{padding-left:22px!important;padding-right:22px!important}.h1{font-size:28px!important}.stack td{display:block!important;width:100%!important}}a{color:' . $c['tealDeep'] . '}</style></head>'
        . '<body style="margin:0;padding:0;background:' . $c['paper'] . ';-webkit-text-size-adjust:100%">'
        . '<div style="display:none;max-height:0;overflow:hidden;opacity:0">' . me($o['preheader']) . '&#8199;&#65279;&#847;&#8199;&#65279;&#847;&#8199;&#65279;&#847;</div>'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:' . $c['paper'] . '"><tr><td align="center" style="padding:32px 12px">'
        . '<table role="presentation" width="600" cellpadding="0" cellspacing="0" style="width:100%;max-width:600px">';

    // Kopf (dunkel) mit Logo-Plakette, Badge, Titel
    $h .= '<tr><td style="background:' . $c['ink'] . ';border-radius:24px 24px 0 0;padding:28px 36px 0" class="px">'
        . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>'
        . '<td><img src="' . me($logo) . '" width="180" alt="' . me(SITE['name']) . '" style="display:block;width:180px;height:auto;border:0;color:#FFFFFF;font-family:' . MFONT . ';font-size:16px;font-weight:700"></td>'
        . '<td align="right" style="font-family:' . MMONO . ';font-size:12px;color:' . $c['onDark'] . '"><span style="display:inline-block;width:8px;height:8px;border-radius:8px;background:' . $c['teal'] . ';margin-right:6px;vertical-align:middle"></span>' . me(date('d.m.Y · H:i')) . ' Uhr</td>'
        . '</tr></table></td></tr>';

    $h .= '<tr><td style="background:' . $c['ink'] . ';padding:36px 36px 34px" class="px">'
        . '<div style="display:inline-block;padding:6px 12px;border-radius:999px;border:1px solid rgba(23,188,156,.4);background:rgba(23,188,156,.1);font-family:' . MMONO . ';font-size:12px;color:#8EEBD5;letter-spacing:.02em">' . me($o['badge']) . '</div>'
        . '<h1 class="h1" style="margin:18px 0 0;font-family:' . MFONT . ';font-size:34px;line-height:1.08;font-weight:600;letter-spacing:-.03em;color:#FFFFFF">' . me($o['title']) . '</h1>'
        . '<p style="margin:14px 0 0;font-family:' . MFONT . ';font-size:16px;line-height:1.6;color:' . $c['onDark'] . '">' . $o['intro'] . '</p>'
        . ($chips ? '<div style="margin-top:18px">' . $chips . '</div>' : '')
        . '</td></tr>';

    // Teal-Linie mit „Stromimpuls“
    $h .= '<tr><td style="background:' . $c['ink'] . ';padding:0"><table role="presentation" width="100%" cellpadding="0" cellspacing="0"><tr>'
        . '<td style="height:4px;background:' . $c['teal'] . ';font-size:0;line-height:0" width="62%">&nbsp;</td>'
        . '<td style="height:4px;background:' . $c['volt'] . ';font-size:0;line-height:0" width="6%">&nbsp;</td>'
        . '<td style="height:4px;background:' . $c['ink2'] . ';font-size:0;line-height:0">&nbsp;</td></tr></table></td></tr>';

    // Körper
    $h .= '<tr><td style="background:#FFFFFF;padding:30px 36px 8px" class="px">';
    if ($rows) {
        $h .= '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" class="stack">' . $rows . '</table>';
    }

    if (!empty($o['message'])) {
        $h .= '<div style="margin:24px 0 0;font-family:' . MMONO . ';font-size:12px;color:' . $c['text3'] . ';text-transform:uppercase;letter-spacing:.02em">' . me($o['message_label'] ?? 'Nachricht') . '</div>'
            . '<div style="margin:10px 0 0;padding:18px 20px;border-radius:16px;background:' . $c['paper'] . ';border-left:4px solid ' . $c['teal'] . ';font-family:' . MFONT . ';font-size:15px;line-height:1.65;color:' . $c['ink'] . '">' . nl2br(me($o['message'])) . '</div>';
    }

    if (!empty($o['attachments'])) {
        $h .= '<div style="margin:26px 0 0;font-family:' . MMONO . ';font-size:12px;color:' . $c['text3'] . ';text-transform:uppercase;letter-spacing:.02em">Anhänge (' . count($o['attachments']) . ')</div>';
        foreach ($o['attachments'] as [$name, $size]) {
            $h .= '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:8px;border:1px solid ' . $c['line'] . ';border-radius:14px"><tr>'
                . '<td width="44" style="padding:12px 0 12px 14px"><div style="width:34px;height:34px;border-radius:10px;background:' . $c['tint'] . ';color:' . $c['tealDeep'] . ';font-family:' . MMONO . ';font-size:10px;font-weight:600;line-height:34px;text-align:center">' . me(strtoupper(pathinfo($name, PATHINFO_EXTENSION))) . '</div></td>'
                . '<td style="padding:12px 10px;font-family:' . MFONT . ';font-size:14px;font-weight:600;color:' . $c['ink'] . ';word-break:break-all">' . me($name) . '</td>'
                . '<td align="right" style="padding:12px 16px 12px 0;font-family:' . MMONO . ';font-size:12px;color:' . $c['text3'] . ';white-space:nowrap">' . me(number_format($size / 1024 / 1024, 2, ',', '.')) . ' MB</td></tr></table>';
        }
    }

    if (!empty($o['steps'])) {
        $h .= '<div style="margin:26px 0 0;font-family:' . MMONO . ';font-size:12px;color:' . $c['text3'] . ';text-transform:uppercase;letter-spacing:.02em">So geht es weiter</div>';
        foreach ($o['steps'] as $i => [$t, $d]) {
            $h .= '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:10px"><tr>'
                . '<td width="44" valign="top"><div style="width:32px;height:32px;border-radius:10px;background:' . ($i === 0 ? $c['teal'] : $c['paper']) . ';color:' . $c['ink'] . ';font-family:' . MMONO . ';font-size:12px;font-weight:600;line-height:32px;text-align:center">0' . ($i + 1) . '</div></td>'
                . '<td style="font-family:' . MFONT . ';font-size:15px;line-height:1.5;color:' . $c['ink'] . '"><strong style="font-weight:600">' . me($t) . '</strong><br><span style="color:' . $c['text2'] . ';font-size:14px">' . me($d) . '</span></td></tr></table>';
        }
    }

    if (!empty($o['actions'])) {
        $h .= '<table role="presentation" cellpadding="0" cellspacing="0" style="margin:28px 0 6px"><tr>';
        foreach ($o['actions'] as $a) {
            [$label, $href] = $a;
            $primary = $a[2] ?? false;
            $h .= '<td style="padding:0 10px 10px 0"><a href="' . me($href) . '" style="display:inline-block;padding:14px 22px;border-radius:999px;font-family:' . MFONT . ';font-size:15px;font-weight:600;text-decoration:none;'
                . ($primary ? 'background:' . $c['teal'] . ';color:' . $c['ink'] : 'background:' . $c['ink'] . ';color:#FFFFFF') . '">' . me($label) . ' &#8599;</a></td>';
        }
        $h .= '</tr></table>';
    }

    if (!empty($o['note'])) {
        $h .= '<p style="margin:18px 0 0;font-family:' . MFONT . ';font-size:13px;line-height:1.6;color:' . $c['text3'] . '">' . $o['note'] . '</p>';
    }
    $h .= '<div style="height:26px;line-height:26px">&nbsp;</div></td></tr>';

    // Kontaktkarte in Teal
    if (!empty($o['contact_card'])) {
        $h .= '<tr><td style="background:#FFFFFF;padding:0 36px 32px" class="px">'
            . '<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:' . $c['teal'] . ';border-radius:18px"><tr>'
            . '<td width="72" style="padding:18px 0 18px 18px"><div style="width:52px;height:52px;border-radius:52px;background:' . $c['ink'] . ';color:' . $c['teal'] . ';font-family:' . MFONT . ';font-size:17px;font-weight:700;line-height:52px;text-align:center">KR</div></td>'
            . '<td style="padding:18px;font-family:' . MFONT . ';color:' . $c['ink'] . '"><span style="font-size:13px">' . me(SITE['owner']) . ' · Geschäftsführer</span><br>'
            . '<a href="tel:' . me(SITE['mobile_tel']) . '" style="font-size:20px;font-weight:700;color:' . $c['ink'] . ';text-decoration:none">' . me(SITE['mobile']) . '</a><br>'
            . '<span style="font-size:13px">' . me(SITE['hours']) . '</span></td></tr></table></td></tr>';
    }

    // Fuß
    $h .= '<tr><td style="background:' . $c['ink'] . ';border-radius:0 0 24px 24px;padding:26px 36px" class="px">'
        . '<p style="margin:0;font-family:' . MFONT . ';font-size:15px;font-weight:600;color:#FFFFFF">' . me(SITE['name']) . '</p>'
        . '<p style="margin:6px 0 0;font-family:' . MFONT . ';font-size:13px;line-height:1.6;color:' . $c['onDark'] . '">' . me(SITE['street']) . ' · ' . me(SITE['zip'] . ' ' . SITE['city']) . '<br>'
        . '<a href="mailto:' . me(SITE['email']) . '" style="color:' . $c['teal'] . ';text-decoration:none">' . me(SITE['email']) . '</a> · <a href="' . me(SITE['url']) . '" style="color:' . $c['teal'] . ';text-decoration:none">elektrotechnik-rabenschlag.de</a></p>'
        . '<p style="margin:14px 0 0;font-family:' . MMONO . ';font-size:11px;color:#85908C">Schaltschrankbau · Automatisierung · MSR-Technik · Innungsbetrieb seit ' . SITE['founded'] . '</p>'
        . '</td></tr>';

    $h .= '</table></td></tr></table></body></html>';
    return $h;
}

/** Klartext-Alternative aus denselben Daten. */
function render_mail_text(array $o): string
{
    $t = strtoupper($o['badge']) . "\n" . $o['title'] . "\n" . str_repeat('=', 40) . "\n\n" . html_entity_decode(strip_tags($o['intro'])) . "\n\n";
    foreach ($o['rows'] ?? [] as $r) {
        $t .= str_pad($r[0] . ':', 16) . html_entity_decode(strip_tags($r[1])) . "\n";
    }
    if (!empty($o['message'])) {
        $t .= "\n" . ($o['message_label'] ?? 'Nachricht') . ":\n" . $o['message'] . "\n";
    }
    if (!empty($o['attachments'])) {
        $t .= "\nAnhänge:\n";
        foreach ($o['attachments'] as [$n, $s]) {
            $t .= '- ' . $n . ' (' . number_format($s / 1048576, 2, ',', '.') . " MB)\n";
        }
    }
    foreach ($o['steps'] ?? [] as $i => [$s, $d]) {
        $t .= ($i ? '' : "\nSo geht es weiter:\n") . ($i + 1) . '. ' . $s . ' – ' . $d . "\n";
    }
    $t .= "\n--\n" . SITE['name'] . "\n" . SITE['street'] . ', ' . SITE['zip'] . ' ' . SITE['city'] . "\n" . SITE['owner'] . ': ' . SITE['mobile'] . "\n" . SITE['email'] . "\n";
    return $t;
}
