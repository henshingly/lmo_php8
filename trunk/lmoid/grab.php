<pre>
<?

function decode_entities($text) {
  $text= html_entity_decode($text,ENT_QUOTES,"ISO-8859-1"); #NOTE: UTF-8 does not work!
  $text= preg_replace('/&#(\d+);/me',"chr(\\1)",$text); #decimal notation
  $text= preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)",$text);  #hex notation
  return $text;
}

function myshuffle($array)
{
  mt_srand((double) microtime() * 1000000);
  $num = count($array);
  for ($i = 0; $i < $num; $i ++)
  {
    $n = mt_rand(0, $num - 1);
    // Swap the data.
    $temp = $array[$n];
    $array[$n] = $array[$i];
    $array[$i] = $temp;
  } // ends for

} // ends function myshuffle(&array)

$sourcelinks = implode ('', file('http://williswappen.de/help.htm'));
preg_match_all("/HREF=\"(.*?)\"/",$sourcelinks,$source);
//print_r($source);exit;
//$source[1][0]='http://www.williswappen.de/nordostnord.htm';

myshuffle(&$source[1]);

foreach ($source[1] as $url) {
  $site= implode ('', file ($url));

  $s=(strip_tags($site,"<img>"));

  $sa = explode("\n",$s);
  //print_r($sa);

  $teams=array();
  $league='';
  $count = count($sa);
  $c=0;
  for ($i=0;$i<$count;$i++) {

    if (trim($sa[$i])=='') continue;

    if (trim($sa[$i])=='Fußball Links') continue;

    if (strpos($sa[$i],'tabelle.gif')!==false) continue;

    $sa[$i] = decode_entities($sa[$i]);

    if (empty($league)) {
      $league=trim($sa[$i]);
      continue;
    }

    if (empty($teams[$c]['name'])) {
      $teams[$c]['name']= trim($sa[$i]);
      continue;
    }

    if (strpos($sa[$i],'IMG')!==false) {
      $sa[$i] = str_replace('IMG SRC="','',$sa[$i]);
      $teams[$c]['img'] = trim(substr($sa[$i],1,strpos($sa[$i],'"')-1));
      continue;
    }


    if (trim($sa[$i])=='-') {
      $teams[$c]['url'] = '';
    }else {
      $teams[$c]['url'] = "http://".trim($sa[$i]);
    }
    $c++;

  }
  mysql_connect('localhost',"root","moni69"); //Verbindung zur Datenbank
  mysql_select_db ("lmo-iconbase"); //Datenbank auswählen
  echo mysql_error();

  $search = '';

  foreach ($teams as $team) {
    $team_name  = str_replace(' von ','',$team['name']);
    $parts=explode(' ',$team['name']);
    $city='';
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



    echo date("H:i:s").": ".$team['name']."\n";
    mysql_query ("INSERT INTO team (name, country, city, url) VALUES ('{$team['name']}', 'Deutschland', '$city','{$team['url']}')");
    echo mysql_error();
    $search.=mysql_insert_id().";";

    //save (big) image
    if (!empty($team['img'])) {
      $path_parts = pathinfo($team['img']);

      copy('http://www.williswappen.de/'.$team['img'],'icons/big/'.str_replace('/','',$team['name']).".".$path_parts["extension"]);
    }

  }

  mysql_query("INSERT INTO search (league, teams, `from`) VALUES ('$league','$search','joker')");
  echo mysql_error();
  //print_r($teams);
}?>