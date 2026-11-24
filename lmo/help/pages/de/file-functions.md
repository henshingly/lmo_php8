# Dateifunktionen

1. [Löschen einer Liga](#1-loeschen-einer-liga)
2. [Upload einer Liga](#2-upload-einer-liga)
3. [Download/Mailen einer Liga](#3-download-mailen-einer-liga)

---

## 1. Löschen einer Liga

Ist eine Liga veraltet oder willst du sie durch eine Sicherheitskopie ersetzen, wähle im Menü **Löschen** und klicke in der Ligenliste die Liga an. Nach einer Sicherheitsabfrage wird sie **unwiderruflich gelöscht**. Sei also vorsichtig.

---

## 2. Upload einer Liga

Mit **Upload** überträgst du eine Liga von deiner Festplatte direkt in dein Ligenverzeichnis. Wähle über **Durchsuchen …** eine Liga (`*.l98`) und starte mit **Upload starten** (nur einmal klicken). Vorhandene Ligen werden nicht überschrieben: Gibt es den Dateinamen schon, wird nummeriert, aus `liga.l98` wird `liga_1.l98`.

---

## 3. Download/Mailen einer Liga

Für eine Sicherheitskopie, die Offline-Bearbeitung oder zum Weitergeben wählst du **Download**. Der Bildschirm zeigt die Ligenliste zweimal:

- **Links:** Ein Klick lädt die Liga auf deine Festplatte. Mit **Alle Ligen auf einmal downloaden** erhältst du eine ZIP-Datei mit allen aufgelisteten Ligen.
- **Rechts:** Ein Klick öffnet ein Eingabefenster für die E-Mail-Adresse des Empfängers. Die Liga (oder alle) wird in eine ZIP-Datei gepackt und per E-Mail verschickt. Absender ist die in den Optionen hinterlegte Absenderadresse bzw. die E-Mail des Webmasters. Versandart ist die dort eingestellte (PHP `mail()` oder SMTP, siehe [E-Mail-Versand](#options/e-mail-versand-smtp)).
