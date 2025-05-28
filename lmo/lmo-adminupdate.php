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


require_once(PATH_TO_LMO . "/lmo-admintest.php");
if (($action == "admin") && ($todo == "update")) {
    $adda = $_SERVER['PHP_SELF'] . '?action=admin&amp;todo=update';?>
      <table class="lmoMiddle" cellspacing="0" cellpadding="0" border="0">
        <tr>
          <td align="center"><h1><?php if ($new_lmo_version > $lmo_version) {echo $text[593];} else {echo $text[596];}?></h1></td>
        </tr>
        <tr>
          <td align="center">
            <table class="lmoInner" cellspacing="0" cellpadding="0" border="0">
              <tr>
                <td class="lmost5" align="left">
<?php
    if ($new_lmo_version > $lmo_version) {
        echo '                  ' . $text[590] . "<br><br>\n";?>
                  <fieldset>
                    <legend><?php echo $text[603];?></legend>
                      <dl>
                        <dt><label><?php echo $text[605];?>:</label></dt>
                        <dd>LMO v.<?php echo $lmo_version;?></dd>
                      </dl>
                      <dl>
                        <dt><label><?php echo $text[604];?>:</label></dt>
                        <dd><a title="<?php echo $text[314];?>" href="<?php echo $new_lmo_version_link;?>">LMO v.<?php echo $new_lmo_version;?></a></dd>
                      </dl>
                  </fieldset><br>
                  <fieldset>
                    <legend><?php echo $text[591];?></legend>
                      <dl>
                        <dt><label><?php echo $text[592];?>:</label></dt>
                        <dd><?php echo $new_lmo_version_require_php;?></dd>
                      </dl>
                  </fieldset><br>
                  <fieldset>
                    <legend><?php echo $text[597] . ': ' . $new_lmo_version;?></legend>
                      <dl>
                        <dt><label><?php echo $text[598];?>:</label></dt>
                        <dd><?php echo $new_lmo_version;?></dd>
                      </dl>
                      <dl>
                        <dt><label><?php echo $text[599];?>:</label></dt>
                        <dd><a target="_blank" href="<?php echo $new_lmo_version_announcement;?>"><?php echo $text[80];?></a></dd>
                      </dl>
                      <dl>
                        <dt><label><?php echo $text[600];?>:</label></dt>
                        <dd><a target="_blank" href="<?php echo $new_lmo_version_changelog;?>"><?php echo $text[80];?></a></dd>
                      </dl>
                      <dl>
                        <dt><label><?php echo $text[314];?>:</label></dt>
                        <dd><a href="<?php echo $new_lmo_version_link;?>"><?php echo $text[314];?></a></dd>
                      </dl>
                      <dl>
                        <dt><label><?php echo $text[601];?>:</label></dt>
                        <dd><?php echo $new_lmo_version_time;?></dd>
                      </dl>
                      <dl>
                        <dt><label><?php echo $text[602];?>:</label></dt>
                        <dd><?php echo $lmo_license;?></dd>
                      </dl>
                  </fieldset>
<?php
    }
    else { ?>
                  <fieldset>
                    <legend><?php echo $text[20];?></legend>
                      <dl>
                        <dt><label><?php echo $text[594];?></label></dt>
                      </dl>
                      <dl>
                        <dt><label><a href="<?php echo $adda;?>"><?php echo $text[595];?></a></label></dt>
                      </dl>
                  </fieldset>
<?php
    } ?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table><?php
}
?>