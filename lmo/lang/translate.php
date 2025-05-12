<?php
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

session_start();

if ($_SESSION['lmouserok'] == 2) {

  //This is the base language on the left side - Change it to fit your needs
  $from_lang = "Deutsch";
  //$from_lang = "English"; //Example for English

  function getFiles($directory) {
    // Try to open the directory
    if ($dir = opendir($directory)) {
      // Create an array for all files found
      $tmp = Array();
      // Add the files
      while($file = readdir($dir)) {
        // Make sure the file exists

        if ($file != "." && $file != ".." && $file[0] != '.' && $file!="CVS") {

          // If it's a directiry, list all files within it
          if (is_dir($directory . "/" . $file)) {

            $tmp2 = getFiles($directory . "/" . $file);
            if (is_array($tmp2)) {
              $tmp[$file] = $tmp2;
            }
          } elseif ( strpos($file,'.txt')!==false) {
            if ($directory == '.' ) {
              $tmp[$directory][]=$file;
            } else {
              $tmp[]=$file;
            }
          }
        }
      }

      // Finish off the function
      closedir($dir);
      return $tmp;
    }
  }
  //print_r(getFiles('.'));exit;
  $langFiles=(getFiles('.'));
  $lang = isset($_POST['lang'])?$_POST['lang']:'English';
  $file = isset($_POST['file'])?$_POST['file']:'.';

  $save = isset($_POST['save'])?true:false;

  $i = isset($_POST['i'])?$_POST['i']:array();

?>
<html>
  <head>
    <title>LMO Translation</title>
    <style type="text/css">
      button {
        padding: .4em .8em;
        background: #3839ab linear-gradient(hsl(0 0% 100% /.2), transparent);
        border: thin solid rgb(0 0 0 /.1);
        border-radius: 0 0.4em 0.4em 0.4em;
        box-shadow: 0 .2em 0.4em rgb(0 0 0 /.5);
        color: white;
        text-shadow: 0 -.05em .05em rgb(0 0 0 /.5);
        font-weight: bold;
        font-size: 125%;
        line-height: 1.5;
      }
      button.ok {
        background-color: #5a9900;
      }
      button:focus,
      button:hover {
       	box-shadow: 0 .3em 0.6em rgb(0 0 0 / .8);
      }
      body {background:#fff;}
      body * {font-size:10px;font-family:Tahoma;}
      tbody textarea,tbody input {width:100%;height:100%;border:0;margin:0;padding:0;background:transparent;}
      tbody textarea:focus,tbody input:focus {background:yellow;}
      .odd {background:#fff;}
      .even {background:#c0c7ff;}
      .uncomplete {background:#ffc7c0;}
      .complete {background:#c7ffc0;}
      #result {position:fixed;width:30%;left:30%;top:30%;border:2px solid red;background:white;padding:1em;cursor:pointer;}
      table{border:1px solid #999;border-spacing:0;border-collapse:collapse;}
      td, th {border:1px solid #999;padding:0 3px;vertical-align:top;}
      th {text-align:right;}
    </style>
  </head>
  <body>
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method='post'>
    <table>
      <caption><h1>Translation</h1></caption>
      <thead>
        <tr>
          <th><center>#</center></th>
          <td width="49%"><h2><?php echo $file?></h2></td>
          <th width="49%">
            Translate
              <select size="1" name="file"><?php
              foreach($langFiles as $dir => $files) {
                echo '<option value="'.$dir.'"'.($file==$dir?" selected":'').'>'.$dir;
              }?>
              </select> to
              <select size="1" name="lang"><?php
              foreach ($langFiles["."] as $langfile) {
                echo "<option".($lang==$langfile?" selected":'').">".$langfile;
              }?>

              </select>
              <input type="submit" name="change_lang" value="ok">

          </th>
          <th><center>#</center></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <td align="center" colspan="4"><button class="ok" type="submit" name="save">Save</button></td>
        </tr>
        <tr>
          <th colspan="4"><small>LMO-Translation Tool – © Rene Marth/<a href="https://www.liga-manager-online.de/">LMO-Group</a></small></td>
        </tr>
      </tfoot>
  <?php
  $de = file($file."/lang-$from_lang.txt");
  $to = array();

  //SAVE
  if ($save) {
    $to=$i;
  } else {
    $pre_to=array();
    if (file_exists($file."/$lang")) {
      $pre_to = file($file."/$lang");
    }
    foreach ($pre_to as $to_line) {
      $pieces_to = explode("=",trim($to_line),2);
      $to[intval($pieces_to[0])] = $pieces_to[1];
    }
  }

  //$to = array_pad($to,count($de),'=');
  $uncomplete_count=0;
  $count=0;

  //SAVE
  if ($save) {
    $fd_new = fopen($file."/$lang","w+b");
  }

  foreach ($de as $line) {
    $uncomplete = true;
    $pieces_de = explode("=",$line,2);
    if (!empty($to[intval($pieces_de[0])])) {
      //SAVE
      if ($save) {
        fwrite($fd_new,$pieces_de[0]."=".trim(stripslashes($to[intval($pieces_de[0])]))."\n");
      }
      $val = htmlspecialchars(stripslashes($to[intval($pieces_de[0])]),ENT_QUOTES);
      if (strlen($pieces_de[1])<3 || trim($to[intval($pieces_de[0])]) != trim($pieces_de[1]) ) {
        $uncomplete=false;
        $uncomplete_count++;
      }
    } else {
      //SAVE
      if ($save) {
        fwrite($fd_new,$pieces_de[0]."=".trim($pieces_de[1])."\n");
      }
      $val= htmlspecialchars($pieces_de[1],ENT_QUOTES);
    }





    echo "<tr class='".($count%2?"odd":"even")."'><th>".$pieces_de[0]."</th>";
    echo "<td>".htmlentities($pieces_de[1])."</td>";
    echo "<td class='";
    if ($uncomplete) {
      echo "uncomplete'";
    } else {
      echo "complete'";
    }
    echo ">";
    if (strlen($pieces_de[1])>88) {
      echo "<textarea name='i[".intval($pieces_de[0])."]'>".$val."</textarea></td>";
    } else {
      echo "<input type='text' name='i[".intval($pieces_de[0])."]' value='".$val."'></td>";
    }
    echo "<th>".$pieces_de[0]."</th></tr>";
    $count++;

  }
  //SAVE
  if ($save) {
    fclose($fd_new);
  }
?>

    </table><div id="result" onClick="this.style.display='none';"><h1><?php echo sprintf("%2d",($uncomplete_count/$count*100))?>% seems to be translated!</h1><p>Please note: This script checks only for emtpy values and if 2 values are equal. So if a word in 2 languages is the same you get false negatives. Then you can ignore the marked values.</p><small>Click</small></div>
    </form>

  </body>
</html><?php
}?>