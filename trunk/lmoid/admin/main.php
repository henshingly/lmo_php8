<?
session_start();

$initial=array();
$teams=array();
$count=0;
$step=1;
$error='';

require("../db_connect.php");
require("../cfg.php");

$term=!empty($_GET['term'])?str_replace('*','%',$_GET['term']):'';
$ini=!empty($_GET['i'])?$_GET['i']:'';
$edit=!empty($_GET['edit'])?$_GET['edit']:'';
$step=!empty($_FILES['teamicon']['name'])?2:1;

$query=mysql_query("SELECT id FROM team");
$count=mysql_num_rows($query);
$query=mysql_query("SELECT DISTINCT LEFT (city, 1) as anfangsbuchstabe FROM team ORDER by anfangsbuchstabe");
while($i = mysql_fetch_row($query)) {
  if ($ini=='' && $term=='') {
    $ini=$i[0];
  }
  $initial[]=$i[0];
} 

if ($edit != '') {
  $query=mysql_query("SELECT id,name,city,country,region FROM team WHERE id='$edit'");
}elseif ($term=="") {
  $query=mysql_query("SELECT id,name,city,country,region FROM team WHERE city LIKE '$ini%' ORDER by name");
} else {
  $query=mysql_query("SELECT id,name,city,country,region FROM team WHERE name LIKE '%$term%' OR city LIKE '%$term%' ORDER by name LIMIT ".MAXIMUM_SEARCH_RESULTS);
}
while($i = mysql_fetch_assoc($query)) {
  $teams[]=$i;
} 

if ($step==2) {
  $userfile =      !empty($_FILES['teamicon']['tmp_name']) ? $_FILES['teamicon']['tmp_name'] :'';
  $userfile_name = !empty($_FILES['teamicon']['name'])     ? $_FILES['teamicon']['name']     :'';
  $userfile_type = !empty($_FILES['teamicon']['type'])     ? $_FILES['teamicon']['type']     :'';
  $iconfile = ICON_PATH.$userfile_name;
  if ($userfile!='' && $userfile_name!='' && $userfile_type=='image/gif' && move_uploaded_file($userfile, $iconfile)) {
    @chmod($iconfile, 0666);
    $error="Upload Success!";
    
    
    $team=basename($userfile_name, '.gif');
    $city='';
    $country=DEFAULT_COUNTRY;
    $region='';
    
    
    
    $parts=explode(' ',$team);
    $anz=count($parts);
    switch ($anz) {
      case 1: $city=$parts[0];break;
      default: 
        if (strlen($parts[$anz-1])<5 && strlen($parts[$anz-2])>=4) {
          $city=$parts[$anz-2];
        } else {
          $city=$parts[$anz-1];
        }
        break;
     
    }
    
    mysql_query("INSERT INTO team (id,name,city,country,region) VALUES (NULL,'$team','$city','$country','$region')");
    
    
  } else {
    $error="Upload-Error!";
    $step=1;
  }
}



echo mysql_error();


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
  <head>
    <title>LMO Icon Database <?=VERSION?> &mdash; Adminbereich</title>
    <link type='text/css' rel='stylesheet' href='../style.css'>
  </head>
  <body>
    <h1>LMO Icon Database <?=VERSION?> &mdash; Adminbereich</h1><?
foreach($initial as $i) {
  if ($ini!=$i) {
    echo "<a href='".$_SERVER['PHP_SELF']."?i=$i'>";
  } else {
    $current_initial=$i;
  }
  echo $i;
  if ($ini!=$i) {
    echo "</a>";
  }
  echo " | ";
}?>
    <p><?=$error?></p>
    <div id="search">
      <h2>Neues Team hinzufügen</h2>
      <form action="<?=$_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" ><?
      if ($step==2) {?>
        <h3>2. Schritt: Verein editieren</h3>
        <p>
          <img style="border:0.5em solid #fff;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
          <img style="border:0.5em solid #eee;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
          <img style="border:0.5em solid #ddd;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
          <img style="border:0.5em solid #ccc;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
          <img style="border:0.5em solid #aaa;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
          <img style="border:0.5em solid #888;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
          <img style="border:0.5em solid #666;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
          <img style="border:0.5em solid #444;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
          <img style="border:0.5em solid #000;" src="<?=ICON_URL.rawurlencode($userfile_name)?>" border="0" alt="teamicon">
        </p>
        <p>
          <label>Name <input type="text" name="teamname" value="<?=$team;?>"></label>
          <label>Ort <input type="text" name="teamcity" value="<?=$city?>"></label>
          <label>Land <input type="text" name="teamcountry" value="<?=$country?>"></label>
          <label>Region <input type="text" name="teamregion" value="<?=$region?>"></label>
        <input type="submit" value="Weiter..."></p><?
      } else {?>
        <h3>1. Schritt: Icon uploaden</h3>
        <p><label>Teamicon <input type="file" name="teamicon"></label><input type="submit" value="Weiter..."></p><?
      }?>
      </form>
    </div>
    <div id="search">
      <h2><?=SEARCH?></h2>
      <form action="<?=$_SERVER['PHP_SELF']?>">
        <p><label><?=TEAM?> <input type="text" name="term"></label><input type="submit" value="Suche"></p>
        <p></p>
      </form>
      <h2><?
       $search_results=mysql_num_rows($query);
       echo $search_results." teams with «".str_replace('%','*',$term.$ini)."» found";
       if ($term!="" && $search_results>=MAXIMUM_SEARCH_RESULTS) {
         echo " (Search limited to ".MAXIMUM_SEARCH_RESULTS." results)";
       }
      ?></h2>
    </div><?
    if ($edit != '') {?>
    <form method="post" action="<?=$_SERVER['PHP_SELF'];?>"><?
    }?>
    <table>
      <thead>
        <tr>
          <th width="15"></th><th>Team</th><th>Land</th><th>Region</th><th colspan="2"></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th width="15"></th><th>Team</th><th>Land</th><th>Region</th><th colspan="2"></th>
        </tr>
      </tfoot><?
  if (!empty($teams)) {
    $anz=count($teams);
    for($i=0;$i<$anz;$i++) {
      $j=$teams[$i];
      $class=fmod($i,2)!=0?" class='odd'":'';?>
    <tr<?=$class?>>
      <td><?
      if (file_exists("../icons/".$j['name'].".gif")) {?>
        <img src="../icons/<?=rawurlencode($j['name']);?>.gif" border="0" width="15" height="15" alt="teamicon"><?
      }?>
      </td><?
      if ($edit == '') {?>
      <td><strong><?=$j['name']?></strong> <small>(<?=$j['city']?>)</small>
      <td><?=$j['country']?></td>
      <td><?=$j['region']?></td>
      <td><a href="<?=$_SERVER['PHP_SELF']?>?edit=<?=$j['id']?>"><img src="../img/edit.gif" border="0" width="16" height="12" alt="edit" title="Edit this Team"></a></td><?
      } else {?>
      <td><strong><input type="text" name="xname" value="<?=$j['name']?>"></strong> <small>(<input type="text" name="xcity" value="<?=$j['city']?>">)</small></td>
      <td><input type="text" name="xcountry" value="<?=$j['country']?>"></td>
      <td><input type="text" name="xregion" value="<?=$j['region']?>"></td>
      <td><a href="<?=$_SERVER['PHP_SELF']?>?edit=<?=$j['id']?>"><img src="../img/edit.gif" border="0" width="16" height="12" alt="edit" title="Edit this Team"></a></td><?
      }
      
      if (file_exists("../icons/".$j['name'].".gif")) {?>
      <td><a href="<?=$_SERVER['PHP_SELF']?>?del=<?=$j['id']?>" onclick="return confirm('Really delete this team?');"><img src="../img/delete.gif" border="0" width="11" height="13" alt="delete" title="Delete this Team"></a></td><?
      }?>
    </tr><?
    }
  } else {?>
      <tr>
        <td colspan="4">Not found</td>
      </tr><?
}?>
    </table><?
    if ($edit != '') {?>
    </form><?
    }?>
    <address>© René Marth</address>
<?
foreach($initial as $i) {
  if ($ini!=$i) {
    echo "<a href='".$_SERVER['PHP_SELF']."?i=$i'>";
  } else {
    $current_initial=$i;
  }
  echo $i;
  if ($ini!=$i) {
    echo "</a>";
  }
  echo " | ";
}  ?>
  </body>
</html>