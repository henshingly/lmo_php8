# Bestandsfuncties

1. [Een competitie verwijderen](#1-een-competitie-verwijderen)
2. [Een competitie uploaden](#2-een-competitie-uploaden)
3. [Een competitie downloaden/e-mailen](#3-een-competitie-downloaden-e-mailen)

---

## 1. Een competitie verwijderen

Is een competitie verouderd of wil je hem vervangen door een reservekopie, kies dan in het menu **Verwijderen** en klik in de lijst op de competitie. Na een beveiligingsvraag wordt hij **definitief verwijderd**. Wees dus voorzichtig.

---

## 2. Een competitie uploaden

Met **Upload** breng je een competitie van je harde schijf rechtstreeks over naar je competitiemap. Kies via **Bladeren …** een competitie (`*.l98`) en start met **Upload starten** (maar één keer klikken). Bestaande competities worden niet overschreven: bestaat de bestandsnaam al, dan wordt genummerd; `liga.l98` wordt `liga_1.l98`.

---

## 3. Een competitie downloaden/e-mailen

Voor een reservekopie, offline bewerken of om door te geven kies je **Download**. Het scherm toont de competitielijst twee keer:

- **Links:** Een klik downloadt de competitie naar je harde schijf. Met **Alle competities in één keer downloaden** krijg je een ZIP-bestand met alle vermelde competities.
- **Rechts:** Een klik opent een invoervenster voor het e-mailadres van de ontvanger. De competitie (of alle) wordt in een ZIP-bestand verpakt en per e-mail verstuurd. Afzender is het in de opties ingestelde afzenderadres of het e-mailadres van de webmaster. De verzendmethode is de daar ingestelde (PHP `mail()` of SMTP, zie [E-mailverzending](#options/e-mailverzending-smtp)).
