<?
// LMO-Archiv Addon zum LigaManager Online
// Copyright(C)2003 Georg Strey
/** Liga Manager Online 4
  *
  * http://lmo.sourceforge.net/
  *
  * This program is free software; you can redistribute it and/or
  * modify it under the terms of the GNU General Public License as
  * published by the Free Software Foundation; either version 2 of
  * the License, or (at your option) any later version.
  * 
  * This program is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
  * General Public License for more details.
  *
  * REMOVING OR CHANGING THE COPYRIGHT NOTICES IS NOT ALLOWED!
  *
  */
  
  
//==============================================================================
                   // sichergehen, dass der Slah am Ende dran ist    
$GLOBALS["ArchivDir"] .= preg_match("=/?=", $ArchivDir) ? "" : "/";


//===============================================//
//             LiesVerzeichnisse                 //
//-----------------------------------------------//
// Diese Funktion ermittelt die Unterverzeichn.  //
// des Verzeichnis $verz                         //
//===============================================//
function get_dirs($verz)
{
  $ret = array();  // Rückgabe initialisieren
                   // Sicher gehen, dass der Slash da ist
  $verz .= preg_match("=\x2f$=", $verz) ? "" : "/";

                   // Lesen Initialisieren
  $handle = opendir($verz);
                   // Alle Einträge lesen
  while ($file = readdir ($handle))
  {                // aber diese Verzeichnisse brauchen wir nicht
      if ($file != "." && $file != "..")
      {            // Ist der Eintrag ein Verzeichnis
        if (is_dir($verz.$file))
        {          // Dann in Rückgabemenge aufnehmen
          $ret[] = $file;
        }
      }
  }
                   // Lesen beenden
  closedir($handle);
                   // und Tschüssssssssssssssssss
  return $ret;
}

//===============================================//
//              VerzeichnisInfo                  //
//-----------------------------------------------//
// Diese Funktion liest die Datei mit den Infos  //
// zum Archivverzeichnis $verz und gibt diese in //
// einem String zurück.                          //
//===============================================//
function VerzeichnisInfo($verz)
{
                   // Sicher gehen, dass der Slash da ist
  $verz .= preg_match("=\x2f$=", $verz) ? "" : "/";
  $Infos = file($verz."dir-descr.txt");
  return implode("",$Infos);
}

//===============================================//
//               AuswahlArchiv                   //
//-----------------------------------------------//
// Diese Funktion zeigt die Archivverzeichnisse  //
// und ihre Beschreibungen an                    //
//===============================================//
function AuswahlArchiv()
{                  // Zuerst alle unterverzeichnisse auslesen
  
  $Dirs = LiesVerzeichnisse($GLOBALS["ArchivDir"]);

                   // Rahmen ausgeben
  include("Rahmen1.html");
                   // Für jedes Verzeichnis
  foreach($Dirs as $ArcDir)
  {                // die Infodatei auslesen
    $DirInfo = VerzeichnisInfo($GLOBALS["ArchivDir"].$ArcDir."/");
                   // Und als Linkbeschreibung ausgeben
    echo "<li><a href=\"".$_SERVER["PHP_SELF"]."?archiv=$ArcDir\">".$DirInfo."</a></li>";
  }
                   // Den Rahmen unten wieder zumachen
  include("Rahmen2.html");
                   // Das war's
}

//===============================================//
//          WechselLigaVerzeichnis               //
//-----------------------------------------------//
// Diese Funktion wechselt das Liga verzeichnis  //
// zu einem angegebenen Archiv Verzeichnis       //
//===============================================//
function chg_work_dir()
{
                   // Parameter enthält Archiv Verzeichnis
  $arbDir = $GLOBALS["ArchivDir"].$_REQUEST["archiv"];
                   // Gibt es das Verzeichnis
  if(is_dir($arbDir))
  {                // Ja, dann die Dateien anzeigen
    $GLOBALS["dirliga"]=$arbDir."/";
    AuswahlLiga();
  }
  else             // Verzeichnis nicht vorhanden
  {                // Die Archive anzeigen
    AuswahlArchiv();
  }
}


?>