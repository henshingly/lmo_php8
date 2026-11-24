# LMO-Hilfe (mehrsprachige Vorlage)

Statische Hilfe-Seite: `index.html` lädt die Seiten als Markdown aus `pages/<sprache>/` und rendert sie im Browser.

**Wichtig:** Die Seiten werden per `fetch` geladen. Auf einem Webserver funktioniert das, beim Öffnen per Doppelklick (`file://`) nicht.
Lokal testen: `python3 -m http.server` im Ordner starten und `http://localhost:8000/` öffnen.

## Stand der Sprachen
Deutsch, Englisch, Niederländisch, Spanisch und Französisch: vollständig (je 19 Seiten). Für weitere Sprachen (it, pl, pt, tr, cz, ro; in `i18n/languages.json` deaktiviert) werden fehlende Seiten mit Hinweis auf Deutsch angezeigt. Die Übersetzungen nl/es/fr wurden nicht von Muttersprachlern geprüft.

## Neue Sprache hinzufügen
1. `i18n/en.json` kopieren nach `i18n/<code>.json` und übersetzen (Oberfläche).
2. `pages/de/` kopieren nach `pages/<code>/` und die `.md`-Dateien übersetzen. Fehlende Seiten werden automatisch auf Deutsch angezeigt (mit Hinweis).
3. In `i18n/languages.json` bei der Sprache `"enabled": true` (Schalter in der Oberfläche) und `"content": true` (Inhaltsseiten vorhanden) setzen.
   Die Sprachen-Fallbackkette steht dort unter `"fallback"`.

## Links in den Markdown-Seiten
- Andere Seite: `[Text](#options)`
- Abschnitt einer anderen Seite: `[Text](#options/3-der-designeditor)`
- Abschnitt der aktuellen Seite: `[Text](#1-einleitung)`
- Anker = Überschrift in Kleinbuchstaben, ä/ö/ü/ß → ae/oe/ue/ss, alles andere → `-`.

## Bibliotheken (lokal in `assets/vendor/`)
Bootstrap 5.3.3, Bootstrap Icons 1.11.3, marked 14.1.4, flag-icons 7.2.3. Es werden keine externen CDNs mehr geladen.
