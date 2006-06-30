<?
session_start();
if (empty($_SESSION['ok'])) {
  header("Location: ".$_SERVER['HTTP_HOST']."/index.php");
  exit;
}

$rejected=array();
$sendfiles=isset($_POST['file'])?$_POST['file']:array();

require("../db_connect.php");
require("../cfg.php");
if (isset($_POST['send']) && !empty($sendfiles)) {
  
  require("zip.php");

  $zipfile = new zipfile();
  foreach($sendfiles as $file) {
    $query=mysql_query("SELECT name FROM team WHERE id='$file'");
    while($j = mysql_fetch_assoc($query)) {
     $team=$j['name'];
    } 
    if (file_exists("icons/$team.gif")) {
      //echo $team;
      $zipfile->add_file(implode('',file("icons/$team.gif")), $team.".gif");
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

if (!empty($_GET['del'])) {
  $del_files=explode(',',$_GET['del']);
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
    <link type='text/css' rel='stylesheet' href='../style.css'>
  </head>
  <body>
  <h1>Your Zip-File</h1><?
if (count($_SESSION['files'])>0) {
  if (count($rejected)>0) {?>
    <dl>
      <dt>Icon nicht in Zip aufgenommen <small>(Doppeleintrag oder maximale Anzahl [<?=MAXIMUM_ICONS_PER_ZIP?>] überschritten)</small></dt><?
      
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
        <th colspan="4">Selected Icons</th>
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
      if (file_exists("icons/".$team.".gif")) {?>
          <img src="icons/<?=rawurlencode($team);?>.gif" border="0" width="15" height="15" alt=""><?
      }?>
        </td>
        <td><?=$team?><input type="hidden" name="file[]" value="<?=$file?>"></td>
        <td><a href="<?=$_SERVER['PHP_SELF']?>?del=<?=$file?>"><img src="img/delete.gif" border="0" width="11" height="13" alt="delete" title="Delete file from list"></a></td>
      </tr><?
    }?>
    </table>
    <p><input type="hidden" name="send"><input type="submit" value="Download Icons"> <a href="<?=$_SERVER['PHP_SELF']?>?del=<?=implode(',',$_SESSION['files'])?>"><img src="img/delete.gif" border="0" width="11" height="13" alt="delete all" title="Delete all files from List"></a></p>
  </form><?
  }
  ?>
  <address>© René Marth</address>
  </body>
</html><?
}?>