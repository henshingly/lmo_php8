<html>
<!-- Creation date: 24.07.2004 -->
<head>
<title></title>
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="author" content="silver">
<meta name="generator" content="AceHTML 5 Pro">
</head>
<body>
<?php
error_reporting(E_ALL);

require("db_connect.php");
    mysql_query("DELETE FROM team");
function show_dir($dir, $pos=2)
{
    require("db_connect.php");

    if($pos == 2)
    {
        echo "<hr><pre>";
    }

    $handle = opendir($dir);
    while ($file = readdir ($handle))
    {
      if ($file=="." || $file==".." || $file=="small"|| $file=="big")
        {
            continue;
        }

        if(is_dir($dir.$file))
        {
            printf ("% ".$pos."s <b>%s</b>\n", "|-", $file);
            show_dir($dir.$file."/", $pos + 3);
        }
        else
        {
           if ($dir!="./icons" && substr($file,-4)==".gif") { 
             if (!file_exists("./icons/small/$file")) {
                copy($dir.$file,"./icons/small/$file");
              }
              /*Heuristik zur Stadtbestimmung*/
              $parts=explode(' ',substr($file,0,-4));
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

              
              $query=mysql_query("INSERT INTO team (id,name,country,city) values (NULL,'".substr($file,0,-4)."','Deutschland','$city')"); 
              echo mysql_error();
              printf ("% ".$pos."s %s\n", "|-", $file);
            }
        }
    }
    closedir($handle);

    if($pos == 2)
    {
        echo "</pre><hr>";
    }

}

show_dir("../icons/");
?>
</body>
</html>