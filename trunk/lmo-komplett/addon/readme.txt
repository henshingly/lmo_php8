Addons:

- Ein Verzeichnis = Ein Addon
- Wenn benötigt eine Konfigurationsdatei cfg.txt (Format wie lmo-cfg.txt im LMO-Verzeichnis)
- Wenn benötigt eine Datei lang.txt und zusätzlich auch lang-[LMO-Sprache].txt erstellen
- An den Anfang der Startdatei(en) des Addons diese Zeile einfügen
  
  require_once(dirname(__FILE__).'/../../init.php');

  Jetzt stehen zur Verfügung:

    # Die Konstanten PATH_TO_LMO, PATH_TO_ADDONDIR, ADDON_NAME und PATH_TO_ADDON
      Diese sind bei allen Pfadangaben zu benutzen!
      z.B. include('lmo-openfile.php'); wird zu include(PATH_TO_LMO.'/lmo-openfile.php');
      z.B. require('lmo-addondatei.php'); wird zu require(PATH_TO_ADDONDIR.'/lmo-addondatei.php');

    # Alle Konfigurationsvariablen als Variablen der Form $<Addonname>_<Variablenname>
      z.B. der Wert foo=bar in der cfg-Datei des Addons brain steht als $brain_foo mit dem Wert bar zur Verfügung

    # Alle Textvariablen als Variablen der Form $text[<Addonname>][<Textnummer>] 
      z.B. der Wert 001=Hallo in der lang-Datei des Addons brain steht als $text[brain][1] zur Verfügung

    # Die globalen Konfigurationsvariablen des LMO aus der lmo-cfg.txt

    # Die globale Sprache des LMO (das $text[xxx]-Array]

- Das Ändern der Konfigurationsvariablen geschieht im Adminbereich des LMO