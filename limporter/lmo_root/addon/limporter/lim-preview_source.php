<?PHP
//
// Limporter Addon for LigaManager Online
// Copyright (C) 2003 by Tim Schumacher
// timme@uni.de /
//
// This program is free software; you can redistribute it and/or
// modify it under the terms of the GNU General Public License as
// published by the Free Software Foundation; either version 2 of
// the License, or (at your option) any later version.
//
// This program is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
// General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with this program; if not, write to the Free Software
// Foundation, Inc., 675 Mass Ave, Cambridge, MA 02139, USA.
//

  require_once(PATH_TO_LMO."/lmo-admintest.php");
  require_once(PATH_TO_ADDONDIR.'/limporter/lim_ini.php');
  require_once(PATH_TO_ADDONDIR.'/limporter/lim-functions.php');
  require_once(PATH_TO_ADDONDIR.'/limporter/lim-classes.php');
  require_once(PATH_TO_ADDONDIR.'/limporter/classes/ini/cIniFileReader.inc');
  include(PATH_TO_ADDONDIR."/limporter/lim-javascript.php");

  $hw = isset($_POST['hw'])?$_POST['hw']:0;
  $imppage = isset($_POST['imppage'])?$_POST['imppage']:0;
//  $ximportFile = isset($_POST['ximportFile'])?$_POST['ximportFile']:"";
//  $ximporttype = isset($_POST['ximporttype'])?$_POST['ximporttype']:0;
//  $xparserFile = isset($_POST['xparserFile'])?$_POST['xparserFile']:"";

