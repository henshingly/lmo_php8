<?
session_start();
if (empty($_SESSION['ok'])) {
  header("Location: ".$_SERVER['HTTP_HOST']."/index.php");
  exit;
}
$initial=array();
$teams=array();
$count=0;

require("db_connect.php");
require("cfg.php");

$term=!empty($_GET['term'])?str_replace('*','%',$_GET['term']):'';
$ini=!empty($_GET['i'])?$_GET['i']:'';
 
$query=mysql_query("SELECT id FROM team");
$count=mysql_num_rows($query);
$query=mysql_query("SELECT DISTINCT LEFT (city, 1) as anfangsbuchstabe FROM team ORDER by anfangsbuchstabe");
while($i = mysql_fetch_row($query)) {
  if ($ini=='' && $term=='') {
    $ini=$i[0];
  }
  $initial[]=$i[0];
} 
if ($term=="") {
  $query=mysql_query("SELECT id,name,city,country,region FROM team WHERE city LIKE '$ini%' ORDER by name");
} else {
  $query=mysql_query("SELECT id,name,city,country,region FROM team WHERE name LIKE '%$term%' OR city LIKE '%$term%' ORDER by name LIMIT ".MAXIMUM_SEARCH_RESULTS);
}
while($i = mysql_fetch_assoc($query)) {
  $teams[]=$i;
} 
echo mysql_error();

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="de">
  <head>
    <title>LMO-Icondatabase <?=VERSION?></title>
    <link type='text/css' rel='stylesheet' href='style.css'>
  </head>
  <body>
    <h1>LMO Icon Database <?=VERSION?></h1><?
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
}
echo "<small> [$count teams in database]</small>";?>
    
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
         echo " <small>(Search limited to ".MAXIMUM_SEARCH_RESULTS." results - Please be more specific)";
       }
      ?></h2>
    </div>
    <table>
      <thead>
        <tr>
          <th width="15"></th><th><acronym title="Big Icon available">bI</th><th>Team <small>(Ort)</small></th><th>Land</th><th>Region</th><th></th>
        </tr>
      </thead><?
  if (!empty($teams)) {
    $anz=count($teams);
    $cluster=array();
    $zipcluster=array();
    for($i=0;$i<$anz;$i++) {
      if ($i % 30 == 0 && $i>0) {?>
      <thead>
        <tr>
          <th width="15"></th><th><acronym title="Big Icon available">bI</th><th>Team <small>(Ort)</small></th><th>Land</th><th>Region</th><th></th>
        </tr>
      </thead><?
      }
      $j=$teams[$i];
      $cluster[]=$teams[$i]['id'];
      if (fmod($i+1,MAXIMUM_ICONS_PER_ZIP)==0) {
        $zipcluster[]=$cluster;
        $cluster=array();
      }
      $class=fmod($i,2)!=0?" class='odd'":'';?>
    <tr<?=$class?>>
      <td><?
      if (file_exists("icons/small/".str_replace('/','',$j['name']).".gif")) {?>
        <img src="icons/small/<?=rawurlencode(str_replace('/','',$j['name']));?>.gif" border="0" width="15" height="15" alt="teamicon"><?
      } else {?>
        <img src="img/nobig.gif" border="0" alt="-" width="12" height="12"><?
      }?></td>
      <td><?
      if (file_exists("icons/big/".str_replace('/','',$j['name']).".gif")) {?>
        <img src="img/big.gif" border="0" alt="+" width="12" height="12"><?
      } else {?>
        <img src="img/nobig.gif" border="0" alt="-" width="12" height="12"><?
      }?>
      </td>
      <td><strong><?=$j['name']?></strong> <small>(<?=$j['city']?>)</small></td>
      <td><?=$j['country']?></td>
      <td><?=$j['region']?></td>
      <td><?
      if (file_exists("icons/small/".str_replace('/','',$j['name']).".gif")) {?>
      <a target="result" href="result.php?add=<?=$j['id']?>"><img src="img/zip.gif" border="0" width="16" height="16" alt="add" title="Add to Zip"></a><?
      }?></td>
    </tr><?
    }
    $zipcluster[]=$cluster;
  } else {?>
      <tr>
        <td colspan="6">Not found</td>
      </tr><?
}?>
      <tr>
        <th align="right" colspan="6"><?
if (!empty($teams)) {
  if (count($zipcluster)==1) {?>
           <a target="result" href="result.php?add=<?=implode(',',$zipcluster[0]);?>"><img src="img/all.gif" border="0" width="22" height="22" alt="add all" title="Add all to Zip"></a><?
  } else {
    foreach($zipcluster as $cluster) {?>
           <a target="result" href="result.php?add=<?=implode(',',$cluster);?>"><img src="img/all40.gif" border="0" width="22" height="22" alt="add <?=MAXIMUM_ICONS_PER_ZIP?>" title="Add <?=MAXIMUM_ICONS_PER_ZIP?> to Zip"></a><?
    }
  }
}  
  ?></th>
      </tr>
    </table>
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