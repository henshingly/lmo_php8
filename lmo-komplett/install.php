<?
$filelist=array(
  '666'=>array('lmo-auth.txt','config/cfg.txt','config/tipp/cfg.txt',/*'config/viewer/cfg.txt',*/'config/spieler/cfg.txt','config/ticker/cfg.txt','config/wap/cfg.txt','addon/tipp/lmo-tippauth.txt','ligen/*.l98'),
  '777'=>array('ligen','output','ligen/archiv','addon/tipp/tipps','addon/tipp/tipps/auswert','addon/tipp/tipps/einsicht','addon/tipp/tipps/auswert/vereine','addon/spieler/stats'),
  '644'=>array('init-parameters.php')
  );
error_reporting(E_ERROR | E_PARSE);
$step=isset($_POST['step'])?$_POST['step']:0;
$patherror='';
$urlerror='';
$installerror='';
$loginerror='';
$ftpserver='';
$ftpuser='';
$path=str_replace('\\','/',dirname(__FILE__));
$url='http://'.$_SERVER['HTTP_HOST'].dirname($_SERVER['SCRIPT_NAME']);
if (isset($_POST['step'])) {
  if ($step==1) {
    
    
    $path=isset($_POST['path'])?$_POST['path']:$path;
    $url= isset($_POST['url'])? $_POST['url']:$path;
    
    $path=substr($path,-1)=='/'?substr($path, 0, -1):$path;
    $url= substr($url,-1)=='/'? substr($url, 0, -1): $url;
      
    //Test
    if (!file_exists(dirname(__FILE__)."/init-parameters.php")) {
      $patherror='<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> Pfad "'.dirname(__FILE__).'" ist inkorrekt</p>';
    }
    if (function_exists('fsockopen') && phpLinkCheck($url."/init-parameters.php",TRUE)==404 || phpLinkCheck($url."/init-parameters.php",TRUE)==FALSE) {
      $urlerror='<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> URL "'.$url.'" ist inkorrekt</p>';
    }
    if ($urlerror=='' && $patherror=='') {
      $step=2;
    }
  }
  
  if ($step==2) {

    $filename = dirname(__FILE__)."/init-parameters.php";
    $somecontent='<? $lmo_dateipfad=\''.dirname(__FILE__)."'; //Dateipfad zum LMO\n".'$lmo_url=\''.$url.'\'; //abolute URL zum LMO?>';
    // Sichergehen, dass die Datei existiert und beschreibbar ist
    if (is_writable($filename)) {
      if (!$handle = fopen($filename, "wb")) {
        $installerror.= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> Kann die Datei '.basename($filename).' nicht öffnen</p>';
      }
      if (!fwrite($handle, $somecontent)) {
        $installerror.= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> Kann in die Datei '.basename($filename).' nicht schreiben</p>';
      }
      $installerror.="<p><em><img src='img/right.gif' border='0' width='12' height='12' alt='Erfolg'> Die Konfiguration wurde erfolgreich gespeichert</em></p>";
      fclose($handle);
    } else {
      $installerror.= '<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> Die Datei "'.basename($filename).'" ist nicht schreibbar. Bitte setzen Sie die Rechte auf chmod 666 und aktualisieren Sie diese Seite ([F5]), um den Vorgang zu wiederholen.</p>';
    }
  }
  if ($step==4) {
    $path=      isset($_POST['path'])?      $_POST['path']      : $path;
    $ftppath=   isset($_POST['ftppath'])?   $_POST['ftppath']   : $path;
    $ftpserver= isset($_POST['ftpserver'])? $_POST['ftpserver'] : '';
    $ftpuser=   isset($_POST['ftpuser'])?   $_POST['ftpuser']   : '';
    $ftppass=   isset($_POST['ftppass'])?   $_POST['ftppass']   : '';
    
    $conn = ftp_connect($ftpserver);
    if (!$conn) {
      $urlerror.='<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> Keine Verbindung zu "'.$url.'" möglich. Korrigieren Sie die Adresse oder passen Sie die Rechte manuell an.</p>';
      $step=3;
    } else {
      $conn2= ftp_login($conn, $ftpuser, $ftppass);
      if (!$conn2) {
        $loginerror.='<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> Fehler beim Einloggen. Korrigieren Sie die Benutzerdaten oder passen Sie die Rechte manuell an.</p>';
        $step=3;
      }
    }
    
    if ($conn && $conn2) {
      ftp_chdir($conn,$ftppath);
      if (!ftp_site($conn, "CHMOD 0644 install.php")) {  //Pathtest
        $patherror.='<p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler">Der automatisch ermittelte Pfad "'.$ftppath.'" ist inkorrekt. Geben Sie manuell den Pfad vom FTP-Hauptverzeichnis zum LMO an.</p>';
        $step=3;
      } else {
        foreach ($filelist as $chmod=>$files) {
          foreach ($files as $file) {
            if (strpos($file,'*')) {
              ftp_chdir($conn,$ftppath."/".dirname($file));
              $ligen=ftp_nlist($conn,'');
              foreach ($ligen as $liga) {
                if (substr($liga,-4)==substr($file,-4)){
                  if (ftp_site($conn, "CHMOD 0$chmod $liga")) {
                     $installerror.="<p><kbd>chmod $chmod \"$liga\"</kbd>: <img src='img/right.gif' border='0' width='12' height='12' alt='Erfolg'></p>";
                  } else {
                     $installerror.="<p class='error'><kbd>chmod $chmod \"$liga\"</kbd>: <img src='img/wrong.gif' border='0' width='12' height='12' alt='Fehler'> - Passen Sie die Rechte manuell an.</p>";
                  }
                }
              }
            } else{
              if (ftp_site($conn, "CHMOD 0$chmod $ftppath/$file")) {
                 $installerror.="<p><kbd>chmod $chmod \"$file\"</kbd>: <img src='img/right.gif' border='0' width='12' height='12' alt='Erfolg'></p>";
              } else {
                 $installerror.="<p class='error'><kbd>chmod $chmod \"$file\"</kbd>: <img src='img/wrong.gif' border='0' width='12' height='12' alt='Fehler'> - Passen Sie die Rechte manuell an.</p>";
              }
            }
          }
        }
      }
    }
  }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
  <head>
    <title>Installation Liga Manager Online</title>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" >
    <style type="text/css">
      @media all {
        body     {  max-width:50em;margin: 0.5em auto;padding:0 0.5em;font-size:85%;background-color: #ffffff;color: #000000;font-family:Tahoma, Verdana, sans-serif;border:1px solid #000;}
        acronym  {  cursor:help;border-bottom:1px dotted;}
        em       {  font-style:normal;font-weight:bold;color:#090;}
        img      {  border:0;}
        dd       {  margin: 0.5em 3em;}
        dt       {  padding:0.1em 1em;line-height:135%;font-weight:bold;background-color:#00f;color:#fcfcff;}
        dl       {  border:1px solid #00f;}
        strong   {  color:#fa6;}
        h1, h2   {  font-family:"Trebuchet MS", Georgia, sans-serif;}
        h1       {  font-size:135%;text-align:center;}
        h2       {  font-size:115%;}
        p        {  margin:0.3em;}
        .error   {  background-color:#c00;color:#ffe;font-weight:bold;padding:0.3em;}
        .foot    {  text-align:right;margin-top:1em;font-size:85%;}
      }
    </style>
  </head>
  <body>
  <h1> Installation des Liga Manager Online 4</h1><?
if ($step<2) {
  if (!is_writeable('init-parameters.php')) {?>
  <p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> Vergewissern Sie sich, dass die Datei <code>init-parameters.php</code> die Rechte 666 besitzt. Bitte setzen Sie die Rechte auf 
    chmod 666 und aktualisieren Sie diese Seite ([F5]), um den Vorgang zu wiederholen.</p><?
  }else{?>
  <h2>1. Pfade</h2>
  <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <dl>
      <dt>Geben Sie hier den <strong>kompletten Pfad</strong> zum LMO an.</dt>
      <dd>
      <?=$patherror?>
        <input name="path" type="text" size="55" value="<?=$path?>"> Bsp.: <em><kbd>/home/www/htdocs/lmo</kbd></em>
      </dd>
      <dt>Geben Sie hier die absolute URL zum LMO an.</dt>
      <dd>
      <?=$urlerror?>
        <input name="url" type="text" size="55" value="<?=$url?>"> Bsp.: <em><kbd>http://www.beispiel.de/lmo</kbd></em>
      </dd>
      <dt>
        <input type="hidden" name="step" value="1">
        <input type="submit" value="Weiter">
      </dt>
    </dl>
  </form>
<?}
}
if ($step==2) {?>
  <h2>2. Speichern der Konfiguration</h2>
  <?=$installerror;?>
  <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <dl>
      <dt>
        <input type="hidden" name="step" value="3">
        <input type="submit" value="Weiter">
      </dt>
    </dl>
  </form><?
}
if ($step==3) {?>
  <h2>3. Setzen der Schreibrechte</h2>
  <p>Um die passenden Schreibrechte zu setzen, ist ein Zugang per FTP notwendig. Dazu müssen Sie die Logindaten für Ihren 
     FTP-Zugang angeben. Die Daten werden vom LMO nicht gespeichert oder in irgendeiner anderen Weise weiterverwendet.
  </p>
  <p>
     Falls Sie dennoch auf das automatische Setzen der Schreibrechte verzichten möchten, können Sie die Rechte der 
     benötigten Dateien auch manuell über ein FTP-Programm ändern. Schauen Sie dazu in die 
     <code><a href="lmohelp1.htm#einstieg03">Hilfedatei</a></code>.
  </p><?
  if (function_exists('ftp_connect')) {?>
  <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <dl>
      <dt>Geben sie hier die Adresse ihres FTP-Servers ein.</dt>
      <dd>
      <?=$urlerror?>
        <input name="ftpserver" type="text" size="50" value="<?=$ftpserver?>"> Bsp.: <em><kbd>ftp.beispiel.de</kbd></em>
      </dd>
      <dt>Geben Sie hier Ihren Usernamen und Ihr Passwort ein.</dt>
      <dd>
      <?=$loginerror?>
        User:<input name="ftpuser" type="text" size="25" value="<?=$ftpuser?>"> Pass:<input name="ftppass" type="password" size="25" value=""><?
    if (empty($patherror) && !isset($_POST['ftppath'])) {?>
        <input type="hidden" name="path" value="<?=$path?>"><?
    } else {
    echo $patherror;?>
        </dd>
        <dt>Geben Sie hier den <strong>FTP-Pfad</strong> zum LMO ein.</dt><dd><input type="text" size="40" name="ftppath" value="<?=$ftppath?>"> Bsp.: <em><kbd>/htdocs/lmo</kbd></em><?
    }?>
        <input type="hidden" name="step" value="4">
      </dd>
      <dt>
        <input type="submit" value="Weiter">
      </dt>
    </dl>
  </form><?
  } else {?>
  <p class="error"><img src="img/wrong.gif" border="0" width="12" height="12" alt="Fehler"> 
    Ihr Server unterstützt keine FTP-Funktionen. Sie müssen die Schreibrechte manuell ändern. 
    Konsultieren Sie dazu die <code><a href="lmohelp1.htm#einstieg03">Hilfedatei</a></code></p><?
  }
}
if ($step==4) {
  echo $installerror;?>
  <dl>
    <dt>Der Liga Manager Online 4 ist installiert worden!</dt>
    <dd>Falls Fehler aufgetreten sind, wiederholen sie die Installation oder installieren Sie den LMO manuell, indem Sie 
    die Datei <code>init-parameters.php</code> mit einem Texteditor anpassen und die Schreibrechte mit einem FTP-Programm 
    manuell vergeben.</dd>
    <dd><strong class="error">Bitte löschen Sie jetzt unbedingt die Datei <code>install.php</code> vom Server oder geben Sie der Datei chmod 000.</strong></dd>
    <dd>Der <acronym title="Liga Manager Online">LMO</acronym> ist jetzt unter der Adresse <code><a href="lmo.php">lmo.php</a></code> 
    zu erreichen, den Adminbereich finden Sie unter <code><a href="lmoadmin.php">lmoadmin.php</a></code>.</dd>
    <dt>Viel Spaß!</dt>
  </dl>
     <?
}?>

  <p class="foot">
    <a href="http://validator.w3.org/check/referer"><img
        src="http://www.w3.org/Icons/valid-html401"
        alt="Valid HTML 4.01!" height="31" width="88"></a> 
    <a href=" http://jigsaw.w3.org/css-validator/check/referer">
      <img width="88" height="31"
       src="http://jigsaw.w3.org/css-validator/images/vcss" 
       alt="Valid CSS!">
    </a> © René Marth/<a href="http://lmo.sourceforge.net/">LMO Group</a>
  </p>    
  </body>
</html>

<?
function phpLinkCheck($url, $r = FALSE)
{
  /*  Purpose: Check HTTP Links
   *  Usage:   $var = phpLinkCheck(absoluteURI)
   *           $var["Status-Code"] will return the HTTP status code
   *           (e.g. 200 or 404). In case of a 3xx code (redirection)
   *           $var["Location-Status-Code"] will contain the status
   *           code of the new loaction.
   *           See print_r($var) for the complete result
   *
   *  Author:  Johannes Froemter <j-f@gmx.net>
   *  Date:    2001-04-14
   *  Version: 0.1 (currently requires PHP4)
   */
  
  $url = trim($url);
  if (!preg_match("=://=", $url)) $url = "http://$url";
  $url = parse_url($url);
  if (strtolower($url["scheme"]) != "http") return FALSE;

  if (!isset($url["port"])) $url["port"] = 80;
  if (!isset($url["path"])) $url["path"] = "/";

  $fp = fsockopen($url["host"], $url["port"], $errno, $errstr, 30);

  if (!$fp) return FALSE;
  else
  {
    $head = "";
    $httpRequest = "HEAD ". $url["path"] ." HTTP/1.1\r\n"
                  ."Host: ". $url["host"] ."\r\n"
                  ."Connection: close\r\n\r\n";
    fputs($fp, $httpRequest);
    while(!feof($fp)) $head .= fgets($fp, 1024);
    fclose($fp);

    preg_match("=^(HTTP/\d+\.\d+) (\d{3}) ([^\r\n]*)=", $head, $matches);
    $http["Status-Line"] = $matches[0];
    $http["HTTP-Version"] = $matches[1];
    $http["Status-Code"] = $matches[2];
    $http["Reason-Phrase"] = $matches[3];

    if ($r) return $http["Status-Code"];

    $rclass = array("Informational", "Success",
                    "Redirection", "Client Error",
                    "Server Error");
    $http["Response-Class"] = $rclass[$http["Status-Code"][0] - 1];

    preg_match_all("=^(.+): ([^\r\n]*)=m", $head, $matches, PREG_SET_ORDER);
    foreach($matches as $line) $http[$line[1]] = $line[2];

    if ($http["Status-Code"][0] == 3)
      $http["Location-Status-Code"] = phpLinkCheck($http["Location"], TRUE);

    return $http;
  }
}

?>