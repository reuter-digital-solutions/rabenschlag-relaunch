#!/usr/bin/env bash
# Baut eine statische Demo-Version nach docs/ (für GitHub Pages).
# Formulare simulieren dort den Versand; das echte PHP-Backend läuft nur auf dem Webserver.
set -euo pipefail
cd "$(dirname "$0")/.."
OUT=docs
rm -rf "$OUT" && mkdir -p "$OUT"
cp -R assets favicon.ico "$OUT"/
touch "$OUT/.nojekyll"

render() { php tools/render.php "$1" "${3:-}" > "$OUT/$2"; }
render index.php index.html
for p in schaltschrankbau automatisierung msr-technik karriere impressum datenschutz; do render "$p.php" "$p.html"; done
render danke.php danke.html "t=anfrage"
render fehler.php 404.html
for v in anfrage anfrage-bestaetigung bewerbung bewerbung-bestaetigung; do render mail-vorschau.php "mail-$v.html" "v=$v"; done

# Saubere Links -> .html
python3 - "$OUT" <<'PY'
import re, sys, pathlib
pages = {'schaltschrankbau','automatisierung','msr-technik','karriere','impressum','datenschutz','danke','fehler'}
def fix(m):
    href = m.group(1)
    if href in ('./', '.'): return 'href="index.html"'
    if href.startswith('./#'): return 'href="index.html' + href[2:] + '"'
    mm = re.match(r'^([a-z-]+)([?#].*)?$', href)
    if mm and mm.group(1) in pages: return 'href="' + mm.group(1) + '.html' + (mm.group(2) or '') + '"'
    return m.group(0)
for f in pathlib.Path(sys.argv[1]).glob('*.html'):
    s = f.read_text(encoding='utf-8')
    s = re.sub(r'href="([^"]*)"', fix, s)
    f.write_text(s, encoding='utf-8')
PY
echo "Demo gebaut: $OUT/ ($(ls $OUT/*.html | wc -l | tr -d ' ') Seiten)"
