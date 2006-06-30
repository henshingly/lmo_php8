<?
session_start();
if (empty($_SESSION['ok'])) {
  header("Location: ".$_SERVER['HTTP_HOST']."/index.php");
  exit;
}

$rejected=array();
$sendfiles=isset($_POST['file'])?$_POST['file']:array();
$apache2=isset($_POST['apache2'])?1:0;

require("db_connect.php");
require("cfg.php");
if (isset($_POST['send']) && !empty($sendfiles)) {
  
  require("zip.php");

  $zipfile = new zipfile();
  foreach($sendfiles as $file) {
    $query=mysql_query("SELECT name FROM team WHERE id='$file'");
    while($j = mysql_fetch_assoc($query)) {
     $team=$j['name'];
     $team2=$team;
     if ($apache2==1) $team2=preg_replace("/[^a-zA-Z0-9]/",'',$team);
    } 
    if (file_exists("icons/small/$team.gif")) {
      //echo $team;
      $zipfile->add_file(implode('',file("icons/small/$team.gif")), "small/".$team2.".gif");
      
    }
    if (file_exists("icons/big/$team.gif")) {
      //echo $team;
      $zipfile->add_file(implode('',file("icons/big/$team.gif")), "big/".$team2.".gif");
      
    }
  }
  header("Content-Type: application/zip");
  header("Content-Disposition: attachment; filename=\"icons.zip\"");
  echo $zipfile->file();
} else {



if (!isset($_SESSION['files'])) $_SESSION['files']=array();

if (!empty($_GET['add'])) {
  
  $add_files=explode(',',$_GET['add']);
  foreach ($add_files as $add) {
    if (count($_SESSION['files'])<MAXIMUM_ICONS_PER_ZIP) {
      $x=array_search($add,$_SESSION['files']);
      if ($x===FALSE) {
        $_SESSION['files'][]=$add;
      } else {
        $rejected[]=$add;
      }
    } else{
      $rejected[]=$add;
    }
  }
}

if (!empty($_POST['del'])) {
  $del_files=explode(',',$_POST['del']);
  foreach ($del_files as $del) {
    $x=array_search($del,$_SESSION['files']);
    if ($x!==FALSE) {
      unset($_SESSION['files'][$x]);
    }
  }
}


 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
  <head>
    <title>Result</title>
    <link type='text/css' rel='stylesheet' href='style.css'>
  </head>
  <body>
  <h1>Auswahl</h1><?
if (count($_SESSION['files'])>0) {
  if (count($rejected)>0) {?>
    <dl>
      <dt>Icon nicht in die Auswahl aufgenommen <small>(Doppeleintrag oder maximale Anzahl [<?=MAXIMUM_ICONS_PER_ZIP?>] überschritten)</small></dt><?
      
    foreach ($rejected as $file) {
      
      $query=mysql_query("SELECT name FROM team WHERE id=$file");
      $j = mysql_fetch_row($query);
      $team=$j[0];?>
      <dd><?=$team?></dd><?
    }?>
  </dl><?
  }?>
  <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
    <table>
      <tr>
        <th colspan="5">Selected Icons</th>
      </tr><?
    $i=0;
    foreach ($_SESSION['files'] as $file) {
      $i++;
      $query=mysql_query("SELECT name FROM team WHERE id=$file");
      $j = mysql_fetch_row($query);
      $team=$j[0];?>
      <tr>
        <td><?=$i?>.</td>
        <td><?
      if (file_exists("icons/small/".$team.".gif")) {?>
          <img src="icons/small/<?=rawurlencode($team);?>.gif" border="0" width="15" height="15" alt=""><?
      }?>
        </td>
        <td><?
      if (file_exists("icons/big/".$team.".gif")) {?>
          <img src="img/big.gif" border="0" alt="+" width="12" height="12"><?
      } else {?>
          <img src="img/nobig.gif" border="0" alt="-" width="12" height="12"><?
      }?>
        </td>
        <td><?=$team?><input type="hidden" name="file[]" value="<?=$file?>"></td>
        <td><a href="<?=$_SERVER['PHP_SELF']?>?del=<?=$file?>"><img src="img/delete.gif" border="0" width="11" height="13" alt="delete" title="Delete file from list"></a></td>
      </tr><?
    }?>
    </table>
    <table id="choose">
      <tr>
        <td>
          <input type="hidden" name="send">
          <input type="hidden" name="del" value="<?=implode(',',$_SESSION['files'])?>">
          <input type="checkbox" name="apache2">
        </td>
        <td><acronym title="If you want to use Apache2 check this box">Apache2 compatibility</acronym></td>
      </tr>
      <tr>
        <td><img src="img/zip.gif"></td>
        <td><input type="submit" value="Auswahl herunterladen"></td>
      </tr>
      <!--<tr>
        <td><img src="img/save.gif"></td>
        <td><input type="submit" value="Auswahl speichern"></td>
      </tr>-->
      <!--<tr>
        <td><img src="img/delete.gif" border="0" width="11" height="13" alt="delete list" title="Delete all files from List"></td>
        <td><input type="submit" value="Auswahl löschen"></a></td>
      </tr>-->
    </table>
  </form><?
  }
  if ($i==0) {?>
    <p>Please select your teams</p><?
  }
  ?>
  <address>© René Marth</address>
  </body>
</html><?
}?>