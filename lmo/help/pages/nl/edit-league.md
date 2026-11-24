# Competitie bewerken

1. [Een competitie aanmaken](#1-een-competitie-aanmaken)
2. [Een competitie openen](#2-een-competitie-openen)
3. [De uitslageneditor](#3-de-uitslageneditor)
4. [Basisinstellingen](#4-basisinstellingen)
5. [Handmatige tabelsortering](#5-handmatige-tabelsortering)
6. [De teameditor](#6-de-teameditor)

---

## 1. Een competitie aanmaken

Klik in het menu op **Nieuw** om een nieuwe competitie aan te maken. Het proces verloopt in 4 stappen:

**Stap 1:** Bepaal de **bestandsnaam** van de competitie, zonder pad en bestandsextensie, die zijn al vastgelegd. De invoer mag maximaal 28 tekens lang zijn. Geef de competitie een duidelijke **naam**, die in de lijsten en als kop in het bezoekersgedeelte verschijnt. Naast de titel moet je ook het seizoen vermelden, bijv. `1e klasse Achterhoek 2001/02`. Kies ook of je een **competitie** (met punten, stand enz.) of een **knock-outtoernooi** (play-off of iets dergelijks) aanmaakt. Klik op **Verder**.

**Stap 2:** Bepaal het **aantal teams**. Bij een competitie geef je ook het **aantal speeldagen** en de **wedstrijden per speeldag** op. Bij knock-outtoernooien vervalt dit, omdat deze waarden uit het aantal teams volgen. Klik op **Verder**.

**Stap 3:** Bij competities volgt nu het **aanmaken van het speelschema**. Je kunt een speelschema van een andere competitie overnemen (alleen mogelijk bij competities met hetzelfde aantal teams, wedstrijden en speeldagen), een **willekeurig speelschema** genereren (het systeem uit LM98Free; alleen mogelijk bij een „normale" competitie waarin elk team één thuis- en één uitwedstrijd tegen elke tegenstander speelt, zoals in de Bundesliga) of er helemaal van afzien. Bij knock-outtoernooien bepaal je hier de **speelwijze** van de afzonderlijke rondes. Klik op **Verder**.

**Stap 4:** De **competitie is opgeslagen!** Bewerk daarna de [teams](#6-de-teameditor), die in eerste instantie alleen genummerd zijn. Heb je het speelschema van een andere competitie overgenomen, kijk dan eerst in het bezoekersgedeelte om te zien welk team bij welk nummer hoort.

---

## 2. Een competitie openen

Na het [inloggen](#getting-started/6-inloggen-uitloggen) zie je direct een overzicht van alle beschikbare competities. Klik anders in het menu op **Openen**. Kies de competitie die je wilt bewerken. [Hulpbeheerders](#options/hulpbeheerders) zien alleen de voor hen vrijgegeven competities.

---

## 3. De uitslageneditor

Na het [openen van een competitie](#2-een-competitie-openen) kom je automatisch in de uitslageneditor met de huidige speeldag. Met het keuzemenu onder het menu kun je ook andere speeldagen oproepen.

**Datum:** Helemaal bovenaan kun je de **begin- en einddatum** van de speeldag instellen. Het formaat is `DD.MM.JJJJ`. Let erop dat de datum met twee cijfers voor dag en maand en vier cijfers voor het jaar, gescheiden door punten, wordt ingevoerd. Naast de datumvelden opent een knop een pop-upkalender waarin je de datum met een klik kiest. Deze data worden bezoekers alleen getoond als de [instelling](#4-basisinstellingen) **Speeldagdatum** actief is.

**Aanvangstijden:** Aan elke wedstrijd kan een **aanvangstijdstip** worden toegewezen, eveneens in het formaat `DD.MM.JJJJ`, en ook hier is er een knop voor de pop-upkalender. Voer je een datum maar geen tijd in, dan wordt de [standaard aanvangstijd](#options/1-globale-opties) overgenomen. Geef tijden op in het formaat `UU:MM` (twee cijfers voor uur en minuut, gescheiden door `:`).

**Teams:** Je kiest de teams via de keuzelijsten.

**Uitslagen invoeren:** Het eenvoudigst is met de pijlknoppen naast de uitslagvelden. Je kunt ook rechtstreeks cijfers typen of de pijltoetsen gebruiken terwijl de cursor in het veld staat. Zijn decimalen ingeschakeld, dan voer je uitslagen nog steeds als gehele getallen in; de omrekening gebeurt pas bij de weergave.

**Einde van de wedstrijd:** Bij competities met [open wedstrijdeinde](#4-basisinstellingen) of knock-outtoernooien geef je aan hoe de wedstrijd eindigde: normaal (\_), na verlenging/overtime (n.v.) of na strafschoppen (i.e.).

> **Opmerking:** Bij uitspraken van het sporttribunaal die zowel punten als doelpunten raken (bijv. het ontnemen van een overwinning) heb je het volgende veld niet nodig.

**Groene-tafelbeslissing:** Dit veld is normaal niet nodig. Maar er zijn steeds weer uitspraken van het sporttribunaal die uitslagen op hun kop zetten. Los van de ingevoerde uitslag kun je hier een beslissing over de winnaar instellen. De doelpunten tellen voor de stand zoals ingevoerd, maar de punten volgen deze instelling. Meestal zegt het tribunaal dan bijv.: 0:0 doelpunten en team X wint. De optie **uitslag voor beide teams** geldt als het tribunaal de wedstrijd voor beide teams gelijk beslist (bijv. 2:0 voor beide).

**Notitie:** Hier kun je een notitie bij de wedstrijd invoeren, bijv. de speellocatie. Ook een gewone uitspraak van het sporttribunaal kun je hier vermelden. De bijzondere gevallen van groene-tafelbeslissingen hoef je niet nogmaals te vermelden; ze worden automatisch als notitie ingevoegd.

**Wedstrijdverslag-URL:** Optioneel kun je een link naar het wedstrijdverslag toevoegen. Die wordt alleen getoond als **Wedstrijdverslagen koppelen** in de [instellingen](#4-basisinstellingen) actief is.

**Voorspellingsspel:** Gebruik je het [voorspellingsspel](#addon-betting-game), dan kun je afzonderlijke wedstrijden van de beoordeling uitsluiten.

**Instellingen die niet van de speeldag afhangen:** Onder de wedstrijden vind je verdere instellingen die je meteen hier kunt aanpassen.

**Huidige speeldag:** Hier hoef je alleen iets te wijzigen als de speeldag die je bewerkt *niet* als huidige speeldag gemarkeerd moet worden, bijv. als je een verplaatste wedstrijd bewerkt of een oudere uitslag corrigeert. Kies dan de speeldag die als huidige moet gelden. Laat het veld anders alsjeblieft ongewijzigd.

**Nieuwsticker:** Activeer de ticker en voer berichten in, één per regel, zonder lege regels.

Klik op **Speeldag en ticker opslaan** om alles over te nemen. Je wijzigingen zijn meteen zichtbaar voor bezoekers, dus controleer liever nog een keer!

> Is de [handmatige tabelsortering](#5-handmatige-tabelsortering) actief: een eerdere handmatige sortering van deze of latere speeldagen vervalt na het opslaan.

---

## 4. Basisinstellingen

Hier stel je alle instellingen van de competitie in. Bij knock-outtoernooien worden alleen de relevante opties getoond.

**Basiswaarden**
De **competitienaam** verschijnt in de lijsten en als kop in het bezoekersgedeelte, inclusief seizoen, bijv. `1e klasse Achterhoek 2001/02`. Verder bepaal je de **benamingen voor punten en doelpunten** (aanpasbaar aan de sport) en kun je **decimale punten/doelpunten** activeren. Kies ook de **favoriete ploeg** en de **standaardteams voor speelschema, vormcurve en statistiek**.

**Koppelingen**
Bepaal of [teamhomepages](#6-de-teameditor) (in de stand) en [wedstrijdverslagen](#3-de-uitslageneditor) (in uitslagen en speelschema's) worden gekoppeld.

**Weergave/Uiterlijk**
Hier bepaal je wat je je bezoekers wilt aanbieden. Met **Startweergave** bepaal je wat bezoekers als eerste zien bij het laden van de competitie. Je kunt **speeldagdatum** en **aanvangstijden** activeren; zonder beide is er ook geen kalender. De **kalender** kan ook apart worden uitgeschakeld. Zijn aanvangstijden actief, kies dan het gewenste **weergaveformaat**.

**Wedstrijd om plaats 3** en **Play-down mogelijk maken** zijn alleen beschikbaar bij knock-outtoernooien. Hier bepaal je of er een kleine finale is en of (zoals bij play-downs gebruikelijk) ook de verliezer een ronde verder kan.

De **kruistabel** en de **vormcurve** kunnen worden uitgeschakeld. De vormcurve wordt in de browser getekend en heeft geen serverbibliotheek nodig. De kruistabel heeft weinig zin als er geen terugwedstrijden zijn (bijv. groepswedstrijden op het WK).

**Speelsysteem**
Het speelsysteem bevat alle instellingen die de modus van de competitie betreffen.

- **Minpunten** bestaan in 2-puntscompetities, in 3-puntscompetities niet meer.
- **Open wedstrijdeinde** hoef je alleen te activeren als na een gelijkspel een verlenging/overtime en eventueel strafschoppen volgen.
- De tabelkolom **Gelijkspel** hoef je alleen te verbergen als er in je competitie in het algemeen geen gelijke spelen zijn.
- **Onderling resultaat** betekent dat bij gelijk aantal punten de directe vergelijking van de gelijkstaande teams onderling wordt meegenomen.
- **Gescoorde doelpunten gaan voor doelsaldo** activeer je alleen als in je competitie de gescoorde doelpunten zwaarder wegen dan het doelsaldo, wat vrij zelden voorkomt.
- De **handmatige sortering van de stand** moet je echt alleen in uitzonderlijke gevallen toestaan, bijv. bij bijzondere regels waarmee deze software geen rekening houdt. Dan kun je de [stand handmatig corrigeren](#5-handmatige-tabelsortering).

**Tabel**
Bepaal welke regels van je stand (en de vormcurve) worden gemarkeerd of getoond:

- Heen-/terugrondestanden
- Thuis-/uitstanden
- Kampioen, promovendus, degradant
- Overige markeringen (bijv. UEFA Cup-plaatsen)

Een waarde van `0` schakelt de betreffende markering uit.

**Puntensysteem**
Hier stel je de puntentoekenning in. Zijn minpunten ingeschakeld, dan zijn winstpunten tegelijk negatieve verliespunten en omgekeerd; bij een gelijkspel worden de punten voor beide kanten geteld.

**Aantal speeldagen en wedstrijden**
Deze functie heb je meestal niet nodig. Moet je achteraf het aantal speeldagen of wedstrijden wijzigen, dan kan dat hier. Maak er eerst wel een [reservekopie](#file-functions/3-een-competitie-downloaden-e-mailen) van! Niet beschikbaar bij knock-outtoernooien.

---

## 5. Handmatige tabelsortering

Heb je de [instelling](#4-basisinstellingen) **Handmatige sortering van de stand toestaan** ingeschakeld, dan verschijnt onderaan de [uitslageneditor](#3-de-uitslageneditor) de optie **Stand**. Klik erop om de stand te controleren en zo nodig handmatig te corrigeren.

Kies onder het menu de speeldag waarvan je de stand wilt bewerken. De stand wordt getoond zoals de software hem heeft berekend. Klopt alles, dan hoef je niets te doen.

Wijs anders de teams nieuwe plaatsen toe. Elke plaats mag maar één keer voorkomen (een JavaScript-functie voorkomt dubbele plaatsen normaal automatisch).

Klik daarna op **Handmatige stand opslaan**. In het bezoekersgedeelte wordt de stand (en de vormcurve) volgens je correcties getoond.

---

## 6. De teameditor

Hier kun je **teamnamen** invoeren en wijzigen. De **afkorting** mag maximaal 5 tekens lang zijn.

Kent de bond straf- of bonuspunten en doelpunten toe, dan kun je die hier invoeren; ze worden bij de berekening van de stand meegenomen. Je kunt ook instellen vanaf welke speeldag de wijziging geldt.

Wil je teamhomepages koppelen, voer dan de URL's in de bijbehorende kolom in. De links verschijnen in de stand als **Teamhomepages koppelen** in de [instellingen](#4-basisinstellingen) actief is.

> **Let op:** Voor elk team zijn er functies om het uit de competitie **terug te trekken** en om **achteraf** een nieuw team **toe te voegen**. *Maak eerst een [reservekopie](#file-functions/3-een-competitie-downloaden-e-mailen)!* Gebruik je het voorspellingsspel voor deze competitie, dan kunnen deze functies tot storingen leiden. Deze opties zijn niet beschikbaar bij knock-outtoernooien.
