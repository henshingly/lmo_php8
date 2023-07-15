<?PHP
require(dirname(__FILE__).'/../../init.php');
require_once(PATH_TO_LMO."/lmo-cfgload.php");
require_once(PATH_TO_LMO."/lmo-langload.php");
define('BASEDIR', rtrim(dirname(''), '/\\'));
$output_platz = $text['tipp'][205];
$output_name = $text['tipp'][23];
$output_punkte = $text['tipp'][38];
if (!isset($cfgarray))$cfgarray = array();
$multi1 = PATH_TO_CONFIGDIR . '/tipp/' . $multi . '.tipp';
if (file_exists($multi1)) {
  $multi_cfgarray = parse_ini_file($multi1);
  $multi_cfgarray += $main_cfgarray;
  extract ($multi_cfgarray);
} else {
  die($text['viewer'][55] . ": " . $multi1 . " " . $text['viewer'][56]);
}

$template_file = $multi_cfgarray['template'];
$template = new HTML_Template_IT(PATH_TO_TEMPLATEDIR . '/tipp');
$template -> loadTemplatefile($template_file . ".tpl.php");
$array = array("");
$endtab = isset($_REQUEST['endtab'])? $_REQUEST['endtab']:""; 
if ($endtab == 0) {
  if (isset($anzst)) {
    $endtab = $anzst;
  }
  $tabdat = "";
} else {
  $tabdat = $endtab.". ".$text[2];
}
if($all == 1) {
  $endtab = 0;
  $tabdat = "";
  $anzst = 0;
} else {
  $st = $endtab;
}
if(!isset($wertung)) {
  $wertung="einzel";
}

if(!isset($gewicht)) {
  $gewicht = "absolut";
}

if(!isset($stwertmodus)) {
  $stwertmodus = "nur";
}

if(!isset($anzseite)) {
  $anzseite = $multi_cfgarray['anzahl_tipper'];
}

if(!isset($von)) {
  $von = 1;
}

if(!isset($start)) {
  $start = 1;
}

if($wertung=="intern") {
  $start = 1;
  $anzseite = $multi_cfgarray['anzahl_tipper'];
}

if($anzseite<1) {
  $anzseite = $multi_cfgarray['anzahl_tipper'];
}

if ($endtab > 1 && $tabdat != "" && $stwertmodus != "nur") {
  $endtab --;
  if ($wertung == "einzel" || $wertung == "intern") {
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwert.php");
  } else {
    require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwertteam.php");
  }
  if($wertung == "team") {
    $anzseite = $teamsanzahl;
  }
  $platz1 = array("");
  $platz1 = array_pad($array, $anzseite + 1, "");
  for($x = 0; $x < $anzseite; $x ++) {
    $x3 = intval(substr($tab0[$x], 25));
    $platz1[$x3] = $x + 1;
  }
  $endtab ++;
}

if ($wertung == "einzel" || $wertung == "intern") {
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwert.php");
} else {
  require(PATH_TO_ADDONDIR."/tipp/lmo-tippcalcwertteam.php");
}
 
if ($wertung == "team" && isset($teamsanzahl)) {
  $anztipper = $teamsanzahl;
}
$platz0 = array("");
if (!isset($anztipper)) {
  $anztipper = 0;
}
$platz0 = array_pad($array, $anztipper+1, "");
for($x = 0; $x < $anztipper; $x++) {
  $x3 = intval(substr($tab0[$x], -7));
  $platz0[$x3] = $x+1;
}
$j=1;
$spv=-1;
$ppv=-1;
$ende = (int)$start + (int)$anzseite - (int)1;
//if((int)$ende > (int)$$anzseite) {
if((int)$ende > (int)4) {
  $ende = $anzseite;
}
for($x = $start; $x <= $ende; $x ++) {
  $i = intval(substr($tab0[$x-1], -7));
  if($wertung != "intern" || $teamintern == $tipperteam[$i]) {
    if($spielegetippt[$i] != $spv || $tipppunktegesamt[$i] != $ppv) {
      $template -> setVariable(array("Platz" => $x . "."));
      $lax = $x;
    } elseif ($wertung == "intern" && $lax != $lx)
    $y = 0;
    if(($endtab > 1) && ($tabdat != "")) {
      if($platz0[$i] < $platz1[$i]) {
        $y = 1;
      } elseif ($platz0[$i] > $platz1[$i]) {
        $y = 2;
      }
    }/*
    if($shownick==1 || ($showemail==0 && $showname==0)) {
    }*/
    if( $tipp_tipperimteam >= 0) {
      if( $wertung == "einzel" || $wertung == "intern") {
        if($tipperteam[$i] == "") {
          $tipperteam[$i] = "&nbsp;";
        }
      }
    }
    if($spielegetippt[$i] != $spv || $tipppunktegesamt[$i] != $ppv) {
      $lx = $x;
    }
    $spv = $spielegetippt[$i];
    $ppv = $tipppunktegesamt[$i];
    $template -> setVariable("NPlatz", $output_platz);
    $template -> setVariable("NName", $output_name);
    $template -> setVariable("NPunkte", $output_punkte);
    $template -> setCurrentBlock("Inhalt");
    $template -> setVariable(array("Name" => $tippernick[$i]));
    $template -> setVariable(array("Punkte" => $tipppunktegesamt[$i]));
  }
  $template->parseCurrentBlock();
}
if ($multi_cfgarray['all'] != 1) {
  $template -> setVariable("Link", BASEDIR.'/lmo.php?action=tipp&amp;&todo=wert&amp;file='.$multi_cfgarray['file']);
  $template -> setVariable("Lmo", BASEDIR.'/lmo.php?todo=&file='.$multi_cfgarray['file']);
} else {
  $template -> setVariable("Link", URL_TO_LMO.'/?action=tipp');
  $template -> setVariable("Lmo", URL_TO_LMO.'/lmo.php');
}
//$template -> parse()
$template -> show();
?>
