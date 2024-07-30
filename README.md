[<img src="https://www.vest-sport.de/forum_files/addon_history.svg">](https://www.vest-sport.de/forum/)

[![GitHub release](https://img.shields.io/github/release/henshingly/history?include_prereleases=&sort=semver&color=blue)](https://github.com/henshingly/history/releases/)
[![download-badge](https://img.shields.io/github/downloads/henshingly/history/total.svg?style=flat-square "Download status")](https://github.com/henshingly/history/releases/latest "Download status")
[![Donate](https://img.shields.io/badge/-Buy%20me%20a%20coffee-brown.svg)](https://paypal.me/LMOforum)

# History (deutsch)

Addon für den LMO.

> [!NOTE]
> __Systemvorraussetzung:__  
> Lauffähiger (Liga Manager Online [(LMO-klassisch)](https://github.com/henshingly/lmo_php8)  
> PHP: >7.4

Mit diesem Addon erstellst Du aus Ligadateien des LMO, aus mehreren Spielzeiten, eine History Tabelle.

### Installation

Die vier Verzeichnisse des Downloads in den root Ordner des LMO kopieren.

Es werden dabei keine Dateien des LMO's geändert, sondern nur neue hinzugefügt.

Nach dem kopieren per FTP in der Administration des LMOs unter (1.rot)`Optionen` (2.grün)`Addons` (3.blau)`history` die notwendigen Angaben machen, um die csv-Dateien zu erstellen (siehe Bild 01).

![Alt-Text](https://www.vest-sport.de/forum_files/history_01_ger.png "Bild 01")

* `lmo_ftpdir` - den FTP-Pfad zum LMO Ordner angeben
* `lmo_ftpuser` - den FTP Benutzername eintragen
* `lmo_ftpserver` - Name des FTP Servers angeben
* `lmo_ftppass` - zum Schluss noch das Passwort für den FTP Benutzer eintragen
* `lmo_autocreate` - lass vorerst die '1' dort stehen

Aufrufen des Scripts mit `<iframe>` oder `include()`. Es kann der komplette Archivordner, oder bestimmte Unterordner im Archivordner, verwendet werden.

Außerdem können konkrete Ligen benannt werden, die in die Auswertung einfliessen.

Beim Aufruf, per `<iframe>` oder `include()`, wird im Ordner `output` die gleiche Ordnerstruktur wie im Ligenverzeichnis erstellt.

Anschließend werden die Ordner mit CSV Dateien der gescannten Ligen gefüllt.

URL-Parameter:

* `his_liga`  //Dateiname der aktuellen Liga
* `his_ligen`  //Ligen die zur Berechnung der ewigen Tabelle genutzt werden sollen, außer die aktuelle Liga. //nur im Notfall nutzen
* `his_folder`  //Ordner mit dem Ligenarchiv
* `his_sort`  //Sortiervorgabe der ewigen Tabelle
  * 0   //Standartsortierung nach Punkten
  * 1   //Sortierung nach Spielen
  * 2   //Sortierung nach Siegen
  * 3   //Sortierung nach Toren
  * 4   //Sortierung nach Punkte pro Spiel
  * 5   //Sortierung nach +Toren
  * 6   //Sortierung nach Diff. +Tore/-Tore
  * 7   //Sortierung nach Ø Punkte pro Spiel
  * 8   //Sortierung nach Diff. +Punkte/-Punkte
  * 9   //Sortierung nach +Punkte
  * 10  //Sortierung nach Meisterschaften
  * 11  //Sortierung nach Abstiegen
  * 12  //Sortierung nach Spielzeiten

* `his_template` - Template, dass benutzt werden soll
* `his_headline` - Überschrift die in der Tabelle erscheinen soll

#### HTML
```html
<iframe src="<url_to_lmo>/addon/history/lmo-history.php?his_liga=xyz.l98&his_folder=archiv/bundesliga"></iframe>
<iframe src="<url_to_lmo>/addon/history/lmo-history.php?his_liga=xyz.l98&his_ligen=abc.l98,def.l98,ghi.l98,jkl.l98"></iframe>
```

#### PHP
```php
<?php
require_once("PfadZumLMO/init.php");  //bearbeite PfadZumLMO
$his_liga = "xyz.l98";  //die erste LMO Ligadatei
$his_folder = "archiv/bundesliga";  //der Pfad zu den l98 Dateien aus den alten Spielzeiten
$his_headline = "ÜBERSCHRIFT_DER_HISTORY_TABELLE";  //die Überschrift die in der Tabbele stehen soll
// wird $his_headline nicht angegeben wird "History Tabelle" als Default Wert ausgegeben
include (PATH_TO_ADDONDIR."/history/lmo-history.php");
?>
```
```php
<?php
require_once("PfadZumLMO/init.php");
$his_liga = "xyz.l98";
$his_ligen = "abc.l98,def.l98,ghi.l98,jkl.l98";
include (PATH_TO_ADDONDIR."/history/lmo-history.php");
?>
```

Optional kann noch das zu nutzende Template mitgegeben werden
#### HTML
```html
his_template=mytemplate
```
#### PHP
```php
<?php
...
$his_template='mytemplate'
...
?>
```

___
[Beispielseite](http://lmo8.bplaced.net/history.php) für die Einbindung per `ìnclude()`

Der Code dieser PHP-Beispielseite lautet

```php
<?php
require_once("./history/init.php");
$his_liga = "1l_2024-25.l98";
$his_folder = "national/1Bundesliga";
$his_template = "history_all";
$his_headline = ".: Ewige Tabelle der 1. Fussball Bundesliga 1963/64 - 2024/25 :.";
include (PATH_TO_ADDONDIR."/history/lmo-history.php");
?>
```

___
[Beispielseite](http://lmo8.bplaced.net/history.html) für die Einbindung per `<iframe>`

Der Code dieser HTML-Beispielseite lautet

```html
<center>
<iframe width=1012 height=600 align=center src="http://lmo8.bplaced.net/history/addon/history/lmo-history.php?his_liga=1l_2024-25.l98&his_template=history_all&his_headline=.: Ewige Tabelle der 1. Fussball Bundesliga 1963/64 - 2024/25 :.&his_folder=national/1Bundesliga"></iframe>
</center>
```

___
___
# History (english)

Addon for the LMO.

With this addon you can create a history table from LMO league files from several seasons.

> [!NOTE]
> **System requirements:**  
> Running (Liga Manager Online [(LMO-classic)](https://github.com/henshingly/lmo_php8)  
> PHP: >7.4

### Installation

Copy the four directories of the download into the root folder of the LMO.

No files of the LMO will be changed, only new ones will be added.

After copying via FTP, make the necessary entries in the administration of the LMO under (1.red)`Options` (2.green)`Add-ons` (3.blue)`history` to create the csv files (see Fig. 01).

![Alt-Text](https://www.vest-sport.de/forum_files/history_01_eng.png "Fig. 01")

* `lmo_ftpdir` - enter the FTP path to the LMO folder
* `lmo_ftpuser` - enter the FTP user name
* `lmo_ftpserver` - enter the name of the FTP server
* `lmo_ftppass` - finally enter the password for the FTP user
* `lmo_autocreate` - leave the ‘1’ there for the time being

Call the script with `<iframe>` or `include()`. The complete archive folder or certain subfolders in the archive folder can be used.

In addition, specific leagues can be named which are included in the evaluation.

When called via `<iframe>` or `include()`, the same folder structure is created in the `output` folder as in the leagues directory.

The folders are then filled with CSV files of the scanned leagues.

URL parameter:

* `his_liga` //filename of the current league
* `his_ligen` //Leagues to be used to calculate the perpetual table, except the current league //only use in an emergency
* `his_folder` //Folder with the league archive
* `his_sort` //Sort default of the perpetual table
  * 0  //Standard sorting by points
  * 1  //Sort by games
  * 2  //Sort by wins
  * 3  //Sorting by goals
  * 4  //Sorting by points per game
  * 5  //Sorting by +goals
  * 6  //Sorting by diff. +goals/goals
  * 7  //Sorting by Ø points per game
  * 8  //Sorting by diff. +points/points
  * 9  //Sorting by +points
  * 10 //Sorting by championships
  * 11 //Sorting by relegations
  * 12 //Sorting by seasons

* `his_template` - Template that should be used
* `his_headline` - Headline that should appear in the table

#### HTML
```html
<iframe src=‘<url_to_lmo>/addon/history/lmo-history.php?his_liga=xyz.l98&his_folder=archiv/bundesliga’></iframe>
<iframe src=‘<url_to_lmo>/addon/history/lmo-history.php?his_liga=xyz.l98&his_ligen=abc.l98,def.l98,ghi.l98,jkl.l98’></iframe>
```

#### PHP
```php
<?php
require_once(‘PathToLMO/init.php’); //edit PathToLMO
$his_liga = ‘xyz.l98’; //the first LMO league file
$his_folder = ‘archiv/bundesliga’; //the path to the l98 files from the old seasons
$his_headline = ‘ÜBERSCHRIFT_DER_HISTORY_TABELLE’; //the headline that should be in the table
// if $his_headline is not specified, ‘History table’ is output as the default value
include (PATH_TO_ADDONDIR.‘/history/lmo-history.php’);
?>
```
```php
<?php
require_once(‘PathToLMO/init.php’);
$his_liga = ‘xyz.l98’;
$his_ligen = ‘abc.l98,def.l98,ghi.l98,jkl.l98’;
include (PATH_TO_ADDONDIR.‘/history/lmo-history.php’);
?>
```

Optionally, the template to be used can also be specified
#### HTML
```html
his_template=mytemplate
```
#### PHP
```php
<?php
...
$his_template=‘mytemplate’
...
?>
```

___
[Example page](http://lmo8.bplaced.net/history.php) for integration via `ìnclude()`

The code of this PHP-example page is

```php
<?php
require_once(‘./history/init.php’);
$his_liga = ‘1l_2024-25.l98’;
$his_folder = ‘national/1Bundesliga’;
$his_template = ‘history_all’;
$his_headline = ‘: Perpetual table of the 1st Bundesliga 1963/64 - 2024/25 :.’;
include (PATH_TO_ADDONDIR.‘/history/lmo-history.php’);
?>
```

___
[Example page](http://lmo8.bplaced.net/history.html) for integration via `<iframe>`

The code of this HTML-example page is

```html
<center>
<iframe width=1012 height=600 align=center src=‘http://lmo8.bplaced.net/history/addon/history/lmo-history.php?his_liga=1l_2024-25.l98&his_template=history_all&his_headline=.: Perpetual table of the 1st Bundesliga 1963/64 - 2024/25 :.&his_folder=national/1Bundesliga’></iframe>
</centre>
```
