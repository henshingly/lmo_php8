<? 
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
  * $Id$
  */

if (!file_exists(dirname(__FILE__)."/config/init-parameters.php") || isset($_POST['lmo_install_step'])) {
      include(dirname(__FILE__)."/install/install.php");
} else {
  if (basename($_SERVER['PHP_SELF'])==basename(__FILE__)) {
    if (!defined('LMO_TEMPLATE')) {
      define("LMO_TEMPLATE","lmo-standard-komplett.tpl.php");
    }
  } else { //includet
    if (!defined('LMO_TEMPLATE')) {
      define("LMO_TEMPLATE","lmo-standard.tpl.php");
    }
  }
  require(dirname(__FILE__)."/lmo-start.php");
}?>