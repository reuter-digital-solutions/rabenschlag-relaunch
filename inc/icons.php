<?php
/**
 * Eigenes Icon-Set „Rabenschlag Line“
 * 24er-Raster, Strich 1.6, runde Enden. Kennzeichen: ein gefüllter Schaltpunkt (class="n"),
 * der per CSS in Teal/Amber leuchtet. Alle Formen bekommen pathLength="1" für die Zeichen-Animation.
 * Bewegliche Teile tragen eigene Klassen (needle, spin, hand, blink) für Mikro-Animationen.
 */
declare(strict_types=1);

const ICONS = [
    'cabinet'  => '<rect x="4" y="2.5" width="16" height="17" rx="2.2"/><path d="M7.5 19.5v2M16.5 19.5v2"/><path d="M7.5 7h9M7.5 11h9M7.5 15h4.5"/><circle class="n blink" cx="15.8" cy="15" r="1.15"/>',
    'plc'      => '<rect x="3" y="5" width="18" height="14" rx="2.4"/><path d="M8 5v14"/><path d="M3 9h2.5M3 12h2.5M3 15h2.5"/><path d="M11 15.5h6.5"/><circle cx="11.6" cy="9.6" r="1"/><circle class="n blink" cx="15" cy="9.6" r="1.1"/>',
    'gauge'    => '<path d="M4.3 17.5a8.6 8.6 0 1 1 15.4 0"/><path d="M6.6 11.3l1.3.7M12 6.6v1.5M17.4 11.3l-1.3.7"/><path class="needle" d="M12 15.2l3.8-4.6"/><circle class="n" cx="12" cy="15.2" r="1.6"/>',
    'chat'     => '<path d="M4.2 4.5h9.6a2.2 2.2 0 0 1 2.2 2.2v5.6a2.2 2.2 0 0 1-2.2 2.2H8.6L5 17.4v-2.9h-.8A2.2 2.2 0 0 1 2 12.3V6.7a2.2 2.2 0 0 1 2.2-2.2z"/><path d="M18.5 8.5h1.3A2.2 2.2 0 0 1 22 10.7v5.1a2.2 2.2 0 0 1-2.2 2.2H19v2.6l-3.3-2.6H11"/><circle class="n" cx="9" cy="9.5" r="1"/>',
    'plan'     => '<path d="M3.5 20.5V4.5l16 16z"/><path d="M7.5 16.5v-3.4l3.4 3.4z"/><path d="M3.5 8.5h2M3.5 12.5h2"/><circle class="n" cx="19.5" cy="4.5" r="1.3"/>',
    'code'     => '<rect x="2.5" y="3.5" width="19" height="13" rx="2.2"/><path d="M9 20.5h6M12 16.5v4"/><path d="M8.2 8l-2 2 2 2M15.8 8l2 2-2 2"/><path d="M13 7.2l-2 5.6"/>',
    'wrench'   => '<path d="M14.8 3.5a4.6 4.6 0 0 0-4.3 6.2l-6.4 6.4a2.2 2.2 0 1 0 3.1 3.1l6.4-6.4a4.6 4.6 0 0 0 6.2-4.3l-2.7 2.7-2.6-.5-.5-2.6 2.7-2.7a4.6 4.6 0 0 0-1.9-.4z"/><circle class="n" cx="5.6" cy="18.4" r=".9"/>',
    'power'    => '<path d="M12 3v8"/><path d="M7 6.2a7.6 7.6 0 1 0 10 0"/><circle class="n" cx="12" cy="3" r="1.1"/>',
    'bolt'     => '<path d="M13.2 2.5 5 13.5h6.3l-1 8 8.2-11h-6.3z"/>',
    'arrow-ur' => '<path d="M7 17 17 7M9 7h8v8"/>',
    'arrow-r'  => '<path d="M5 12h14M13 6l6 6-6 6"/>',
    'phone'    => '<path d="M5.2 3.5h2.9l1.5 4.4-2 1.4a11.2 11.2 0 0 0 5.1 5.1l1.4-2 4.4 1.5v2.9a2.1 2.1 0 0 1-2.3 2.1A16.6 16.6 0 0 1 3.1 5.8a2.1 2.1 0 0 1 2.1-2.3z"/>',
    'mail'     => '<rect x="2.5" y="5" width="19" height="14" rx="2.6"/><path d="m3.5 6.8 8.5 6.4 8.5-6.4"/>',
    'pin'      => '<path d="M12 21.5s-7-6.1-7-11.6a7 7 0 0 1 14 0c0 5.5-7 11.6-7 11.6z"/><circle class="n" cx="12" cy="9.9" r="2.3"/>',
    'clock'    => '<circle cx="12" cy="12" r="9"/><path class="hand" d="M12 7v5l3.4 2"/>',
    'globe'    => '<circle cx="12" cy="12" r="9"/><path d="M3 12h18"/><path d="M12 3c2.5 2.7 3.8 5.7 3.8 9s-1.3 6.3-3.8 9c-2.5-2.7-3.8-5.7-3.8-9S9.5 5.7 12 3z"/>',
    'box'      => '<path d="M12 2.8 20.5 7.5v9L12 21.2 3.5 16.5v-9z"/><path d="M3.5 7.5 12 12.2l8.5-4.7M12 12.2v9"/>',
    'award'    => '<circle cx="12" cy="9" r="6"/><path d="M8.6 13.9 7.2 21.5l4.8-2.6 4.8 2.6-1.4-7.6"/><path d="m9.6 9 1.6 1.6 3.2-3.2"/>',
    'users'    => '<circle cx="9" cy="8" r="3.5"/><path d="M2.5 20c.6-3.6 3.2-5.5 6.5-5.5s5.9 1.9 6.5 5.5"/><path d="M15.6 4.8a3.5 3.5 0 0 1 0 6.4M18 14.8c2 .8 3.2 2.5 3.5 5.2"/>',
    'pen'      => '<path d="M4 20l1-4.6L16 4.4a2.1 2.1 0 0 1 3 3L8 18.4z"/><path d="M14 6.4l3 3"/><path d="M13 20.2h7"/>',
    'racks'    => '<rect x="2.5" y="6" width="5.5" height="15" rx="1.3"/><rect x="9.25" y="3" width="5.5" height="18" rx="1.3"/><rect x="16" y="8.5" width="5.5" height="12.5" rx="1.3"/><circle class="n blink" cx="12" cy="6.5" r=".9"/>',
    'gear'     => '<g class="spin"><circle cx="12" cy="12" r="5.6"/><path d="M12 2.5v3M12 18.5v3M2.5 12h3M18.5 12h3M5.3 5.3l2.1 2.1M16.6 16.6l2.1 2.1M5.3 18.7l2.1-2.1M16.6 7.4l2.1-2.1"/></g><circle class="n" cx="12" cy="12" r="2"/>',
    'conveyor' => '<rect x="2.5" y="14.5" width="19" height="5" rx="2.5"/><circle cx="6" cy="17" r=".9"/><circle cx="12" cy="17" r=".9"/><circle cx="18" cy="17" r=".9"/><rect x="5" y="8" width="5" height="4.5" rx="1"/><rect x="13" y="5.5" width="6" height="7" rx="1"/>',
    'sprout'   => '<path d="M12 21v-8.5"/><path d="M12 12.5c0-4 2.5-6.5 7.5-6.5 0 4-2.5 6.5-7.5 6.5z"/><path d="M12 15c0-3.3-2-5.5-6.5-5.5 0 3.3 2 5.5 6.5 5.5z"/><path d="M7.5 21h9"/>',
    'flame'    => '<path d="M12 21.5c-3.9 0-6.5-2.7-6.5-6.3 0-3.3 2.4-5.2 3.6-8 .7 1.6 1.7 2.6 3 3.1-.4-3 .6-5.6 3-7.8.4 3.1 3.4 5.4 3.4 9.6 0 5-2.6 9.4-6.5 9.4z"/><path class="n-stroke" d="M12 21.5c-1.6 0-2.8-1.2-2.8-2.8 0-1.6 1.4-2.6 2.8-4.2 1.4 1.6 2.8 2.6 2.8 4.2 0 1.6-1.2 2.8-2.8 2.8z"/>',
    'wind'     => '<path d="M3 8.5h10.5A2.5 2.5 0 1 0 11 6"/><path d="M3 12.5h15.5a2.5 2.5 0 1 1-2.5 2.5"/><path d="M3 16.5h6.5a2 2 0 1 1-2 2"/>',
    'snow'     => '<path d="M12 2.5v19M3.8 7.2l16.4 9.6M3.8 16.8l16.4-9.6"/><path d="M9.6 4.2 12 6.3l2.4-2.1M9.6 19.8l2.4-2.1 2.4 2.1"/>',
    'fan'      => '<circle cx="12" cy="12" r="9.5"/><g class="spin"><path d="M12 10.4c-.6-3 .4-5.1 2.8-5.6 1.4 2.1-.2 4.5-2.8 5.6z"/><path d="M13.4 12.8c2.9.9 4.3 2.7 3.6 5-2.5.4-3.9-2.2-3.6-5z"/><path d="M10.6 12.8c-2.2 2-4.5 2.2-6 .4 1-2.4 3.8-2.4 6-.4z"/></g><circle class="n" cx="12" cy="12" r="1.4"/>',
    'upload'   => '<path d="M12 15.5V4M7 8.5l5-5 5 5"/><path d="M4 15v3.5A2.5 2.5 0 0 0 6.5 21h11a2.5 2.5 0 0 0 2.5-2.5V15"/>',
    'file'     => '<path d="M14 2.5H7A2.5 2.5 0 0 0 4.5 5v14A2.5 2.5 0 0 0 7 21.5h10a2.5 2.5 0 0 0 2.5-2.5V8z"/><path d="M14 2.5V8h5.5"/><path d="M12 11.5v6M9 14.5h6"/>',
    'fuel'     => '<path d="M4 21.5V5a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v16.5M2.5 21.5h14"/><path d="M15 9.5h1.5a2 2 0 0 1 2 2v5a1.25 1.25 0 0 0 2.5 0v-8L18 5.5"/><path d="M7 7.5h5"/>',
    'check'    => '<path d="M5 12.5l4.5 4.5L19 7.5"/>',
    'menu'     => '<path d="M4 8h16M4 16h10"/>',
    'close'    => '<path d="M6 6l12 12M18 6 6 18"/>',
    'bus'      => '<circle cx="5" cy="6" r="2"/><circle cx="19" cy="6" r="2"/><circle class="n" cx="12" cy="18.5" r="2"/><path d="M3 12h18M5 8v4M19 8v4M12 12v4.5"/>',
    'energy'   => '<circle cx="12" cy="12" r="9"/><path d="M13 6.5 8.6 13h3.9l-1 4.5 4.4-6.5H12z"/>',
    'building' => '<path d="M3.5 21h17M5.5 21V4.5h9V21M14.5 9h4V21"/><path d="M8.5 8h3M8.5 12h3M8.5 16h3"/><circle class="n blink" cx="16.5" cy="13" r=".9"/>',
    'factory'  => '<path d="M2.5 21V11l5 3v-3l5 3v-3l5 3V4h3.5v17z"/><path d="M2.5 21h19"/><path d="M6 17.5h2M10.5 17.5h2"/>',
    'spark'    => '<path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M5.6 18.4l2.8-2.8M15.6 8.4l2.8-2.8"/>',
    'trash'    => '<path d="M4 7h16M9 7V4.5h6V7M6.5 7l1 13.5h9l1-13.5"/>',
    'alert'    => '<circle cx="12" cy="12" r="9"/><path d="M12 7.5v5.5"/><circle class="n" cx="12" cy="16.3" r="1"/>',
    'home'     => '<path d="M3.5 10.5 12 3.5l8.5 7V20a1 1 0 0 1-1 1H15v-6H9v6H4.5a1 1 0 0 1-1-1z"/>',
];

/** Gibt ein Inline-SVG-Icon zurück. */
function icon(string $name, int $size = 24, string $class = ''): string
{
    $body = ICONS[$name] ?? ICONS['spark'];
    // pathLength für die Zeichen-Animation an alle Formen hängen
    $body = preg_replace('/<(path|circle|rect|line|polyline)\b/', '<$1 pathLength="1"', $body);
    $cls  = trim('ico ico-' . $name . ' ' . $class);
    return '<svg class="' . $cls . '" width="' . $size . '" height="' . $size . '" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">' . $body . '</svg>';
}
