# Spielerstatistik

1. [Konfiguration](#1-konfiguration)

![Useransicht](./assets/media/spielerstatistik01.png)

Mit diesem Addon kannst du Spielerstatistiken für den Liga Manager Online erfassen und veröffentlichen. Die flexible Konfiguration macht es für viele verschiedene Sportarten nutzbar.

Du kannst drei Arten von Spalten anlegen: **Text**, **Zahlen** und **Formeln**. Die Reihenfolge der Spalten lässt sich nachträglich leider nicht mehr ändern – überlege also gut, bevor du anfängst. Nach dem Anlegen der Spieler erscheint die Aufstellung darunter, wo du für jeden Spieler die passenden Werte einträgst. In Formelspalten kannst du mit den Zahlenspalten rechnen (z. B. Durchschnittstore).

**Spielerfotos einbinden**
Fotos gehören ins Verzeichnis `img/spieler/small/`, benannt nach dem jeweiligen Spieler. Achte auf eine sinnvolle Dateigröße.

**Spielerlinks einbinden**
Um Spieler zu verlinken, lege im Adminbereich eine Spalte **„Spielerlink"** (oder das Äquivalent aus `lang/lmo-[Sprache].txt`) an. Für jeden Spieler kann ein Link hinterlegt werden – fehlt die Angabe, wird nicht verlinkt.

**Spaltengrafiken einbinden**
Statt Text-Überschriften kannst du auch Icons für Spalten verwenden. Speichere dazu ein **GIF**-Bild mit dem Spaltennamen im Verzeichnis `img/spieler/`. Beispiele sind bereits enthalten.

**Statistiken mehrerer Vereine mit Wappen**
Wenn du als Spaltenüberschrift **„Verein"** (oder das Äquivalent aus `lmo-[Sprache].txt`) verwendest, wird die Vereinsunterstützung aktiviert: Dropdown-Auswahl, Vereinswappen (falls vorhanden) und Links zu Vereinshomepages.

---

## 1. Konfiguration

### Besucher-Ansicht

| Einstellung | Bedeutung |
|---|---|
| Anzeige pro Seite | Anzahl der angezeigten Einträge; `0` = keine Begrenzung |
| Vorsortierung | Spalte, nach der zuerst sortiert wird |
| Sortierung | Reihenfolge der Vorsortierung |
| Extra Sortierspalte | Zeigt eine separate Sortierspalte an; sonst erfolgt die Sortierung über die Tabellenköpfe |
| Vereinsweise anzeigen | Aktiviert die Aufteilung nach Vereinen |
| Nullwerte einblenden | Zeigt auch leere Felder an; Zeichenketten werden immer angezeigt |

### Admin-Ansicht

| Einstellung | Bedeutung |
|---|---|
| Vorsortierung Admin | Spalte, nach der zuerst sortiert wird |
| Hilfsadmin | Gibt Hilfsadmins Zugriff auf die Spielerstatistik |
| Hilfsadmin (Spalten) | Gibt Hilfsadmins auch Zugriff auf die Spaltenverwaltung |

---