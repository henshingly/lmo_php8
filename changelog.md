# Liga Manager Online (classic design) Change Log (german)
__Alle wesentlichen Änderungen am PHP Script des LMO werden in dieser Datei dokumentiert.__  

## [Unveröffentlicht] - YYYY-MM-DD

_Hier schreiben wir Changelog Hinweise der nächsten Version._  

### Added   


### Changed  
* Seitenquelltextausgabe der beiden Datein lmo-savehtml.php und lmo-savehtml1.php verbessert. Außerdem den Tabellen der beiden Seiten runde Ecken verpasst.

### Deprecated  


### Removed  


### Fixed  


### Security  


***
## [4.1.4] - 2024-10-20

_Hier hätten wir die Changelogs für 4.1.4._  

### Added  
* Grundeinstellung des LMO's geändert. Die Mindestanforderung des Webservers beträgt PHP 7.4.xxx - besser wäre einer größer 8.0.0  
* Erstellung eines KO-Turniers mit 24 Teams möglich (neuer UEFA Modus Champions League, Europa League)  
* Erstellung eines Rückrundenspielplans in einer Liga hinzugefügt (thx [DwB](https://github.com/babbisch) and [webfalter](https://github.com/webfalter) for help)  
* Playoff Modus kann nun bei KO-Turnieren besser dargestellt und eingestellt werden ([Preview](https://www.vest-sport.de/forum/viewtopic.php?p=833#p833)).  


### Changed  
* Pop-Up Kalender im Admin Backend auf Mehrsprachig geändert (war vorher fest auf deutsch)  
* TabSprünge bei Eingabe von Daten in KO-Turnieren nach Hinweis von DwB optimiert. 
* Verwendung von [PHPMailer()](https://github.com/PHPMailer/PHPMailer) anstelle von [mail()](https://www.php.net/manual/de/function.mail.php)  
* Sprachdateien aktualisiert (doppelte entfernt bzw. in neue Bezeichnung geändert)  
* Die Flaggen der Sprachauswahl geändert (GIF -> SVG)  
* Ticker Addon nun mit JQuery-Plugin anstelle von eigenem JS >>by [DwB](https://github.com/babbisch)  


### Deprecated  
* utf8_decode() entfernt (mit PHP 8.2.xx deprecated) stattdessen iconv()  



### Removed  
* alte Dateien des Addons Limporter entfernt  


### Fixed  
* Fehler in der Ligastatistik [gefixt](https://github.com/henshingly/lmo_php8/issues/18). Thx DwB
* null-Zugriff vermeiden [#9](https://github.com/henshingly/lmo_php8/pull/9) (thx tombrain)  
* Vermeinden von outOfIndex-Zugriff in liga.class mit Handsortierung [#10](https://github.com/henshingly/lmo_php8/pull/10) (thx tombrain)  
* Message für Tipp-Reminder wird als 0 vorbelegt. [#12](https://github.com/henshingly/lmo_php8/pull/12)  
* PHP-Warnings im Addon Tippspiel [#13](https://github.com/henshingly/lmo_php8/issues/13) >>thx [DwB](https://github.com/babbisch)  
* Fehler, wenn Passwörter Sonderzeichen wie '@!$' enthalten und diese dann in cfg-Dateien gespeichert werden (z.B. in einem FTP Zugang eines Addons). >>thx [DwB](https://github.com/babbisch)  
* diverse Fehler im Addon Tippspiel gefixt (Dank an alle Helfer)


### Security  


***
## [4.1.2] - 2023-10-26

_Hier hätten wir die Changelogs für 4.1.2.  
Wenn ich Sie mir alle gemerkt hätte, deswegen nur ein Auszug_  

### Added  

### Changed  
* Wechselnde Ausgabe der Heimmannschaft in Best-of-3-, Best-of-5- oder Best-of-7-Playoff-Spielen.  
* Bosnische und kroatische Sprachdateien hinzugefügt (thx franjo)  

### Deprecated  

### Removed  

### Fixed  
* Sprachdateien aktualisiert bzw. geändert
* weitere Fehler im Addon Tippspiel gefixt (leider immer noch nicht fehlerfrei)  
* [Fix](https://www.vest-sport.de/forum/viewtopic.php?p=779): Fehler beim erstellen einer NICHT STANDARD Liga  

### Security 


***
***
# League Manager Online (classic design) Change Log (english)  
__All significant changes to the LMO PHP script are documented in this file.__  

## [Unreleased] - YYYY-MM-DD

_Here we write changelog notes for the next version._  

### Added  


### Changed  


### Deprecated  


### Removed  


### Fixed  


### Security  


***
## [4.1.4] - 2024-10-20

_Here we had the changelogs for 4.1.4._  

### Added  
* Basic setting of the LMO changed. The minimum requirement of the web server is PHP 7.4.xxx - one higher than 8.0.0 would be better  
* Creation of a knockout tournament with 24 teams possible (new UEFA mode Champions League, Europa League)  
* Added creation of a second half game plan in a league (thx [DwB](https://github.com/babbisch) and [webfalter](https://github.com/webfalter) for help)  
* Playoff mode can now be displayed and set better in knockout tournaments ([Preview](https://www.vest-sport.de/forum/viewtopic.php?p=833#p833)).  


### Changed  
* Pop-up calendar in the admin backend changed to multilingual (was previously fixed in German)  
* Optimized tab jumps when entering data in knockout tournaments following advice from DwB.  
* Using [PHPMailer()](https://github.com/PHPMailer/PHPMailer) instead of [mail()](https://www.php.net/manual/de/function.mail.php)  
* Language files updated (duplicate ones removed or changed to new name)  
* Changed the language selection flags (GIF -> SVG)  
* Ticker addon now with JQuery plugin instead of its own JS >>by [DwB](https://github.com/babbisch)


### Deprecated  
* utf8_decode() removed (with PHP 8.2.xx deprecated) iconv() instead  


### Removed  
* Removed old files from the Limporter addon  


### Fixed  
* Bug in league statistics [fixed](https://github.com/henshingly/lmo_php8/issues/18). Thx DwB  
* avoid null access [#9](https://github.com/henshingly/lmo_php8/pull/9) (thx tombrain)  
* Avoid outOfIndex access in liga.class with hand sorting [#10](https://github.com/henshingly/lmo_php8/pull/10) (thx tombrain)  
* Message for tip reminder is preset as 0. [#12](https://github.com/henshingly/lmo_php8/pull/12)  
* PHP warnings in the addon betting game [#13](https://github.com/henshingly/lmo_php8/issues/13) >>thx [DwB](https://github.com/babbisch)  
* Error when passwords contain special characters like '@!$' and these are then saved in cfg files (e.g. in an FTP access of an addon). >>thx [DwB](https://github.com/babbisch)  
* various errors in the addon betting game fixed (thanks to all helpers)  


### Security  


***
## [4.1.2] - 2023-10-26

_Here we have the changelogs for 4.1.2.  
If only I had remembered them all. So just an excerpt from it._  

### Added  


### Changed  
* Alternating edition of the home team in best-of-3, best-of-5 or best-of-7 playoff games.  
* Added Bosnian and Croatian language files (thx franjo)  


### Deprecated  


### Removed  


### Fixed  
* Language files updated or changed  
* further errors fixed in the addon betting game (unfortunately still not error-free)  
* [Fix](https://www.vest-sport.de/forum/viewtopic.php?p=779): Error when creating a NON-STANDARD league  


### Security  
