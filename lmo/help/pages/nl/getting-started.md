# Aan de slag

1. [Inleiding](#1-inleiding)
2. [Systeemeisen](#2-systeemeisen)
3. [Installatie](#3-installatie)
4. [Bestandsrechten herstellen](#4-bestandsrechten-herstellen)
5. [Update-installatie](#5-update-installatie)
6. [Inloggen/Uitloggen](#6-inloggen-uitloggen)
7. [Juridische informatie](#7-juridische-informatie)

---

## 1. Inleiding

Welkom bij de Liga Manager Online! Met dit script bied je je bezoekers een uitslagendienst voor je favoriete competities. Het hele beheer gebeurt rechtstreeks op de server: jij voert alleen de uitslagen in en je bezoekers zien meteen de actuele standen, statistieken en speelschema's.

Het beheergedeelte bereik je via `lmoadmin.php`. Maak er het beste een bladwijzer voor, want in het bezoekersgedeelte staat om veiligheidsredenen geen link ernaartoe. Je bezoekers starten de LMO via het bestand `lmo.php`. Hoe je hem in je homepage opneemt, lees je bij [Aanpassen](#customization/4-de-lmo-in-bestaande-homepages-opnemen).

Bij elke link hoort een tooltip, dus verdere uitleg over de bediening is meestal niet nodig.

---

## 2. Systeemeisen

- **Webserver:** Apache, Nginx of een andere webserver met PHP (Linux of Windows)
- **PHP:** versie **8.2 of hoger**
- **Database:** niet nodig, de LMO slaat alles op in bestanden (flat files)
- **PHP-extensies:** `mbstring`, `session` en `json` (bij vrijwel elke hoster voorgeïnstalleerd). Optioneel: **Zip** voor het downloaden van alle competities en zip-bijlagen bij e-mails, **OpenSSL** voor e-mailverzending via SMTP met versleuteling (TLS/SSL). De vormcurves (competitie en voorspellingsspel) worden in de browser getekend en hebben geen GD-bibliotheek nodig.
- **Schrijfrechten:** PHP moet kunnen schrijven in de mappen voor competities, configuratie en uitvoer. Het installatieprogramma controleert dit en stelt de rechten waar mogelijk in.
- **Browser:** een actuele browser met JavaScript ingeschakeld

> **Opmerking voor Apache 2:** Verwijder alle speciale tekens uit de bestandsnamen van teamiconen. Alleen letters en cijfers zijn toegestaan.

---

## 3. Installatie

De installatie verloopt volledig in de browser, je hoeft geen FTP-gegevens in te voeren.

1. Pak het ZIP-archief uit en upload de **volledige inhoud** naar je server, met behoud van de mapstructuur.
2. Open de LMO in je browser, bijv. `https://www.jouw-site.nl/lmo/lmoadmin.php`. **De installatie start automatisch** en stelt paden, configuratie en toegangsgegevens in.
3. Na een geslaagde installatie verschijnt de knop **Installatiemap nu verwijderen**. Klik erop, zodat de map `install` niet op de server blijft staan.
4. Log in en wijzig meteen het wachtwoord (zie [Inloggen/Uitloggen](#6-inloggen-uitloggen)).

Normaal is de LMO daarna klaar voor gebruik. Breekt de installatie af, controleer dan eerst de [bestandsrechten](#4-bestandsrechten-herstellen).

### Handmatige installatie

> **Alleen nodig als de automatische installatie niet werkt.**

1. Kopieer de inhoud van de map `install` naar je LMO-map en verwijder daarna het bestand `install/install.php`.
2. Maak het bestand `config/init-parameters.php` aan (of open het) en vul de twee paden in:

   ```php
   <?php
   $lmo_dateipfad = '/absoluut/pad/naar/lmo'; // bestandspad naar de LMO
   $lmo_url = 'https://www.jouw-site.nl/lmo'; // absolute URL van de LMO
   ```

   Weet je ze niet, vraag het dan aan je provider.
3. Stel de bestandsrechten in zoals in de volgende paragraaf beschreven.

---

## 4. Bestandsrechten herstellen

De LMO moet naar enkele mappen en bestanden kunnen schrijven. Meldt hij dat iets niet beschrijfbaar is, stel dan de rechten (chmod) als volgt in:

![Rechten instellen (chmod)](./assets/media/manual_chmod.png)

**Mappen (777):**

- `ligen` en alle submappen
- `output`
- `config` en de submappen `config/viewer` en `config/smtp`
- `addon/spieler/stats`
- `addon/tipp/tipps` en alle submappen

**Bestanden (666):**

- `config/lmo-auth.php`
- `addon/tipp/lmo-tipperauth.php`
- `config/smtp/cfg.php` en `config/smtp/key.php` (indien aanwezig)
- alle `cfg.txt`-bestanden in de map `config` en de submappen
- alle competities in de map `ligen` en de submappen
- alle bestanden in `output`, `addon/spieler/stats` en `addon/tipp/tipps` (indien aanwezig)

---

## 5. Update-installatie

Bij het updaten van een bestaande installatie worden je configuratiebestanden en competities niet overschreven.

1. Maak eerst een back-up van je hele LMO-map (minstens `ligen`, `config` en `addon/tipp/tipps`).
2. Kopieer de nieuwe bestanden over de bestaande. Eigen aanpassingen (bijv. in `template/` of `img/teams/`) blijven behouden zolang je dezelfde bestanden niet vervangt.
3. Open het beheergedeelte. De LMO meldt **Update gevonden**. Klik op **Update-installatie starten**.
4. De update past de configuratie aan. Daarbij worden onder meer de wachtwoorden van de voorspellers in het voorspellingsspel omgezet naar veilige (gehashte) opslag.
5. Verwijder daarna met de knop **Installatiemap nu verwijderen** de map `install`.

> **Opmerking:** Is de map `config/smtp` niet beschrijfbaar, dan geeft de LMO dat aan. SMTP-instellingen kunnen dan pas worden opgeslagen nadat de rechten zijn ingesteld.

---

## 6. Inloggen/Uitloggen

Bij het openen van `lmoadmin.php` verschijnt het inlogscherm. Na een nieuwe installatie zijn de gebruikersnaam `admin` en het wachtwoord `lmo` (kleine L, M, O) voorgeprogrammeerd. **Wijzig het wachtwoord zo snel mogelijk** onder [Opties → Gebruikersbeheer](#options/4-gebruikersbeheer), zodat niemand ongeautoriseerd toegang krijgt.

Ben je ingelogd, dan vind je in het menu het item **Uitloggen**. Gebruik het aan het eind van elke sessie.

---

## 7. Juridische informatie

> Dit script wordt gepubliceerd onder de voorwaarden van de [GPL](https://www.gnu.org/licenses/gpl.txt). Dat betekent: je mag het script gebruiken, doorgeven en wijzigen, maar er wordt geen garantie gegeven. **Copyrightvermeldingen moeten in alle gevallen behouden blijven en mogen niet worden verwijderd of gewijzigd.**

Hoewel de software zorgvuldig is ontwikkeld, kan geen aansprakelijkheid worden aanvaard voor fouten of schade die door het gebruik ontstaat.
