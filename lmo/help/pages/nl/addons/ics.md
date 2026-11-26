# ICS-agenda

1. [Overzicht](#1-overzicht)
2. [ICS-pagina openen](#2-ics-pagina-openen)
3. [Download of abonnement?](#3-download-of-abonnement)
4. [Abonneren in agenda-apps](#4-abonneren-in-agenda-apps)
5. [Veelgestelde vragen](#5-veelgestelde-vragen)

Met de ICS-addon kunnen bezoekers het speelschema van een team in hun eigen agenda opnemen (Google Agenda, Apple Agenda, Outlook, Thunderbird en vele andere). Als de agenda wordt **geabonneerd**, worden nieuwe speeltijden en verplaatsingen automatisch bijgewerkt.

> **Opmerking:** De ICS-addon maakt geen deel uit van het LMO-pakket, maar is een **aparte download**: [Laatste release op GitHub](https://github.com/henshingly/ics-calendar/releases/latest). Pak hem uit in je LMO-map (hij maakt `addon/ics/`, `lang/ics/` en `config/ics/` aan).

---

## 1. Overzicht

| Bestand | Doel |
|---|---|
| `addon/ics/lmo-ics.php` | de ICS-pagina: competitie kiezen, team kiezen, bestand maken |
| `lang/ics/lang-<taal>.txt` | teksten in 14 talen |
| `config/ics/cfg.txt` | instellingen (wedstrijdduur, herinnering, URL in de afspraak, clubnamen inkorten) |

Op de pagina stel je het team, de URL in de afspraak, de wedstrijdduur (minuten) en een herinnering voor aanvang in. Daarna verschijnen de **downloadlink** en de **abonnementslink**.

---

## 2. ICS-pagina openen

* **Vanuit de tabel:** is in de basisinstellingen van de competitie onder *Weergave → Koppelingen* de optie **ICS-agenda koppelen** actief, dan verschijnt achter elk team een klein agenda-icoon. Een klik opent de ICS-pagina van dat team.
* **Rechtstreeks:** `addon/ics/lmo-ics.php` openen en competitie en team kiezen.

---

## 3. Download of abonnement?

| | Download (`.ics`-bestand) | Abonnement (`webcal://`) |
|---|---|---|
| Werking | eenmalige import van de huidige wedstrijden | agenda blijft verbonden met de LMO |
| Wijzigingen in de LMO | komen **niet** door | worden automatisch overgenomen |
| Geschikt voor | eenmalige import, apparaten zonder abonnementen | meestal de betere keuze |

De abonnementslink begint met `webcal://`; dat is gewoon een andere schrijfwijze voor `https://`. Bij programma's die `webcal://` niet kennen vervang je dit door `https://` (of `http://` als de site geen HTTPS gebruikt).

---

## 4. Abonneren in agenda-apps

Kopieer eerst de abonnementslink van de ICS-pagina. Op een smartphone is tikken op de link vaak genoeg; de agenda-app vraagt dan of je wilt abonneren.

### Google Agenda (computer)

1. Open [calendar.google.com](https://calendar.google.com).
2. Klik naast **Andere agenda's** op **+** en kies **Via URL**.
3. Plak de link, met `https://` in plaats van `webcal://`.
4. Klik op **Agenda toevoegen**.

De agenda verschijnt daarna ook in de Google Agenda-app op Android met hetzelfde account. Google vernieuwt geabonneerde agenda's zelden; wijzigingen kunnen tot een dag duren.

### Apple Agenda (iPhone en iPad)

1. **Instellingen → Agenda → Accounts → Voeg account toe → Overig → Voeg agenda-abonnement toe**.
2. Plak de link, tik op **Volgende** en **Bewaar**.

Of tik op de `webcal://`-link en kies **Abonneer**.

### Apple Agenda (Mac)

1. In Agenda: **Archief → Nieuw agenda-abonnement**.
2. Plak de link en klik op **Abonneer**.
3. Stel de naam en het vernieuwinterval in (bijvoorbeeld elk uur of dagelijks).

### Microsoft Outlook (Windows, klassiek)

1. **Bestand → Accountinstellingen → Accountinstellingen**.
2. Tabblad **Internetagenda's → Nieuw**.
3. Plak de link, klik op **Toevoegen** en geef een naam.

### Outlook op het web en nieuwe Outlook

1. **Agenda → Agenda toevoegen → Abonneren via internet**.
2. Plak de link (indien nodig met `https://` in plaats van `webcal://`), geef een naam, **Importeren**.

Het bijwerken kan enkele uren duren.

### Mozilla Thunderbird

1. Ga naar de agendaweergave en kies **Nieuwe agenda** (plusteken naast "Agenda").
2. Kies **Op het netwerk** en **Volgende**.
3. Kies formaat **iCalendar (ICS)**, plak de link in **Locatie**, **Volgende** en geef een naam.
4. Rechtsklik op de agenda → **Eigenschappen** om het vernieuwinterval in te stellen (bijvoorbeeld elke 30 minuten).

### Android zonder Google-account (en Samsung Agenda)

Veel Android-agenda's kunnen geen abonnementen toevoegen. De gratis app **ICSx⁵** (F-Droid of Play Store) abonneert op ICS-links en stelt ze beschikbaar aan de agenda van het apparaat: app openen, op **+** tikken, link plakken, opslaan.

### Andere programma's

Nextcloud, GMX, web.de, IONOS en veel andere diensten kennen een functie zoals *agenda abonneren*, *agenda toevoegen via URL* of *internetagenda*. Voer daar de link in, bij twijfel met `https://` aan het begin.

---

## 5. Veelgestelde vragen

**De agenda toont nieuwe speeltijden laat.**
Dat bepaalt de agenda-app, niet de LMO. Google en Outlook op het web vernieuwen zelden; bij Apple en Thunderbird kun je een korter interval instellen.

**Ik zie geen wedstrijden.**
De agenda bevat alleen wedstrijden met een datum. Onder de lijst toont de pagina hoeveel wedstrijden zonder datum ontbreken.

**De tijden zijn verschoven.**
De tijden worden berekend met de in de LMO ingestelde tijdzone en in UTC aan de agenda doorgegeven. Controleer de tijdzone in de LMO-opties en in je agenda.

**Het abonnement werkt niet.**
De link moet van buitenaf bereikbaar zijn (geen wachtwoordbeveiliging, geen server alleen op het intranet). Test hem in de browser met `https://` in plaats van `webcal://`: er moet een `.ics`-bestand downloaden.

**Ik wil de wedstrijdduur of herinnering wijzigen.**
Wijzig de waarden op de ICS-pagina en kies **ICS-bestand maken**. De abonnementslink bevat deze instellingen. Een bestaand abonnement moet opnieuw met de nieuwe link worden afgesloten.
