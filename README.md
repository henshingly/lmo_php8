[![LMO für PHP 8](https://www.liga-manager-online.org/forum_files/md/logo.svg)](https://www.liga-manager-online.org/forum)  
[![GitHub release](https://img.shields.io/github/release/henshingly/lmo_php8?include_prereleases=&sort=semver&color=blue)](https://github.com/henshingly/lmo_php8/releases/) 
[![commits](https://img.shields.io/github/commits-since/henshingly/lmo_php8/latest)](https://github.com/henshingly/lmo_php8/commits/main/) 
[![download-badge](https://img.shields.io/github/downloads/henshingly/lmo_php8/total.svg?style=flat-square "Download status")](https://github.com/henshingly/lmo_php8/releases/latest "Download status") 
[![discussion](https://img.shields.io/github/discussions/henshingly/lmo_php8)](https://github.com/henshingly/lmo_php8/discussions) 
[![issues](https://img.shields.io/github/issues/henshingly/lmo_php8)](https://github.com/henshingly/lmo_php8/issues) 
[![Message](https://img.shields.io/badge/CHANGELOG-blue)](https://github.com/henshingly/LMO_PHP8/blob/master/changelog.md) 
[![Donate](https://img.shields.io/badge/-Buy%20me%20a%20coffee-brown.svg)](https://paypal.me/LMOforum)
# (ENGLISH) LMO on PHP8
Together with others, I want to ensure that Liga Manager Online runs on PHP 8.
However, the project page is still <a target="_blank" href="https://www.liga-manager-online.de/homepage/">https://www.liga-manager-online.de/homepage/</a>
## Description of the LMO
With this script you can offer your visitors a great results service for your favorite leagues. The best part is that all league management takes place directly on the server. So all you have to worry about is the results and your visitors will immediately receive the latest tables, statistics and more. This is really super convenient because it means you no longer have to deal with third-party software and also saves a lot of time that you would otherwise have to spend on exports and uploads.

Currently supported languages (_sorted alphabetically_)
- [![Bosnian](https://www.liga-manager-online.org/forum_files/md/Bosanski.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Bosanski) Bosnian
- [![Croatian](https://www.liga-manager-online.org/forum_files/md/Hrvatski.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Hrvatski) Croatian
- [![Czech](https://www.liga-manager-online.org/forum_files/md/Cestina.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Cestina) Czech
- [![Dutch](https://www.liga-manager-online.org/forum_files/md/Nederlands.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Nederlands) Dutch
- [![English](https://www.liga-manager-online.org/forum_files/md/English.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=English) English
- [![French](https://www.liga-manager-online.org/forum_files/md/Francais.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Francais) French
- [![German](https://www.liga-manager-online.org/forum_files/md/Deutsch.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Deutsch) German ([help files](https://www.liga-manager-online.org/test/lmo_git/help/Deutsch/index.html))
- [![Hungarian](https://www.liga-manager-online.org/forum_files/md/Magyar.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Magyar) Hungarian
- [![Italian](https://www.liga-manager-online.org/forum_files/md/Italiano.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Italiano) Italian
- [![Norwegian](https://www.liga-manager-online.org/forum_files/md/Norsk.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Norsk) Norwegian
- [![Portuguese](https://www.liga-manager-online.org/forum_files/md/Portugues.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Portugues) Portuguese
- [![Romanian](https://www.liga-manager-online.org/forum_files/md/Romanian.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Romanian) Romanian
- [![Slovenian](https://www.liga-manager-online.org/forum_files/md/Slovenskega.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Slovenskega) Slovenian
- [![Spanish](https://www.liga-manager-online.org/forum_files/md/Espanol.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Espanol) Spanish

### System requirement
- Web server with at least PHP 8.0 - maximum PHP 8.5

### Installation
LMO is installed with [Composer](https://getcomposer.org/).
1. Run this in your project folder (the folder that contains or will contain `composer.json`):
   ```
   composer require lmo/lmo_php8
   vendor/bin/lmo-install
   ```
   LMO is set up in the folder `lmo` of your project. For another folder, name it, e.g. `vendor/bin/lmo-install public/lmo`.
2. Open `lmo/lmo.php` in your browser. LMO sets itself up.
3. Open `lmo/lmoadmin.php` **right away** and choose the admin user name and password.

Update: run `composer update`. The LMO in the folder `lmo` is brought up to date automatically. Your settings, leagues, tips and a changed `.htaccess` are kept.

Existing installation (uploaded by FTP): name its folder as the target of `lmo-install`. The program files are replaced, your data is kept. Make a backup first.

If the web server delivers your whole project folder, the folder `vendor` next to `lmo` must not be reachable from a browser; `lmo-install` puts an `.htaccess` there. On nginx or other servers without `.htaccess`, block `vendor` and the folders `config`, `includes`, `ligen` and `vendor` inside `lmo` yourself.

> [!NOTE]
This LMO version is still a beta version. Please note this. Before copying over an existing LMO, make a backup first!

After joker has removed the forum on the LMO's project page (because of the General Data Protection Regulation GDPR), I offer a support forum for this LMO on my website (https://www.liga-manager-online.org/forum/).

--------------------------------------------------------------------------------------------------------
# (DEUTSCH) LMO auf PHP8
Ich möchte hier mit anderen die Lauffähigkeit des Liga Managers Online unter PHP 8 gewährleisten.
Die Projektseite ist aber weiterhin <a target="_blank" href="https://www.liga-manager-online.de/homepage/">https://www.liga-manager-online.de/homepage/</a>
## Beschreibung des LMO's
Mit diesem Skript können Sie Ihren Besuchern einen tollen Ergebnisdienst über Ihre Lieblingsligen anbieten. Das Beste daran ist, dass die gesamte Verwaltung der Ligen direkt auf dem Server abläuft. Sie müssen sich also nur noch um die Ergebnisse kümmern und Ihre Besucher erhalten sofort die aktuellen Tabellen, Statistiken und mehr. Das ist wirklich super praktisch, denn so müssen Sie sich nicht mehr mit Fremdsoftware befassen und sparen sich auch noch viel Zeit, die Sie sonst für Exporte und Uploads aufwenden müssten.

Momentan unterstützte Sprachen (_alphabetisch sortiert_)
- [![Bosnian](https://www.liga-manager-online.org/forum_files/md/Bosanski.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Bosanski) Bosnisch
- [![German](https://www.liga-manager-online.org/forum_files/md/Deutsch.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Deutsch) Deutsch ([Hilfedateien](https://www.liga-manager-online.org/test/lmo_git/help/Deutsch/index.html))
- [![English](https://www.liga-manager-online.org/forum_files/md/English.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=English) Englisch
- [![French](https://www.liga-manager-online.org/forum_files/md/Francais.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Francais) Französisch
- [![Italian](https://www.liga-manager-online.org/forum_files/md/Italiano.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Italiano) Italienisch
- [![Croatian](https://www.liga-manager-online.org/forum_files/md/Hrvatski.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Hrvatski) Kroatisch
- [![Dutch](https://www.liga-manager-online.org/forum_files/md/Nederlands.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Nederlands) Niederländisch
- [![Norwegian](https://www.liga-manager-online.org/forum_files/md/Norsk.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Norsk) Norwegisch
- [![Portuguese](https://www.liga-manager-online.org/forum_files/md/Portugues.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Portugues) Portugiesisch
- [![Romanian](https://www.liga-manager-online.org/forum_files/md/Romanian.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Romanian) Rumänisch
- [![Slovenian](https://www.liga-manager-online.org/forum_files/md/Slovenskega.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Slovenskega) Slowenisch
- [![Spanish](https://www.liga-manager-online.org/forum_files/md/Espanol.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Espanol) Spanisch
- [![Czech](https://www.liga-manager-online.org/forum_files/md/Cestina.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Cestina) Tschechisch
- [![Hungarian](https://www.liga-manager-online.org/forum_files/md/Magyar.svg)](https://www.liga-manager-online.org/test/lmo_git/lmo.php?file=1l_2023-24.l98&lmouserlang=Magyar) Ungarisch

### Systemvorraussetzung
- Webserver mit mindestens PHP 8.0  -  maximal PHP 8.5

### Installation
Der LMO wird mit [Composer](https://getcomposer.org/) installiert.
1. Im Projektordner ausführen (dort, wo die `composer.json` liegt oder liegen soll):
   ```
   composer require lmo/lmo_php8
   vendor/bin/lmo-install
   ```
   Der LMO wird im Ordner `lmo` des Projekts eingerichtet. Für einen anderen Ordner diesen angeben, z. B. `vendor/bin/lmo-install public/lmo`.
2. `lmo/lmo.php` im Browser aufrufen. Der LMO richtet sich selbst ein.
3. **Sofort** `lmo/lmoadmin.php` aufrufen und Benutzername und Passwort des Admins festlegen.

Update: `composer update` ausführen. Der LMO im Ordner `lmo` wird dabei automatisch aktualisiert. Einstellungen, Ligen, Tipps und eine angepasste `.htaccess` bleiben erhalten.

Bestehende Installation (per FTP hochgeladen): deren Ordner als Ziel von `lmo-install` angeben. Die Programmdateien werden ersetzt, die Daten bleiben erhalten. Vorher eine Sicherung machen.

Liefert der Webserver den ganzen Projektordner aus, darf der Ordner `vendor` neben `lmo` nicht per Browser erreichbar sein; `lmo-install` legt dort eine `.htaccess` ab. Bei nginx oder anderen Servern ohne `.htaccess` diesen Ordner und in `lmo` die Ordner `config`, `includes`, `ligen` und `vendor` selbst sperren.

> [!NOTE]
Bei dieser LMO Version handelt es sich immer noch um eine Beta Version. Beachtet das bitte. Vor dem drüberkopieren über einen vorhandenen LMO macht zuerst eine Sicherung!

Nachdem joker auf der Projektseite des LMO's das Forum entfernt hat (wegen der Datenschutz-Grundverordnung DSGVO), biete ich auf meiner Webseite ein Supportforum für diesen LMO an (https://www.liga-manager-online.org/forum/). 
