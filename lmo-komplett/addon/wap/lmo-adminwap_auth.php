<?
if(!isset($_SESSION['wap_userok']) || $_SESSION['wap_userok']==0) {
  $pswfile=PATH_TO_LMO."/lmo-auth.txt";
  $psw1file=PATH_TO_LMO."/lmo-access.txt";
  if (($admins=@file($pswfile))===FALSE) $admins = array();
 
  foreach($admins as $admin){
    $admin_files = explode('|',trim($admin));
    if(($_SESSION['wap_username']==$admin_files[0]) && ($_SESSION['wap_userpass']==$admin_files[1])){
      $_SESSION['wap_userok']=$admin_files[2];
      if($_SESSION['wap_userok']==1){
        if ($datei=fopen($psw1file,"rb")) {
          while ($dateien=fgetcsv($datei,1000,'|')) {
            if(count($dateien)>0){
              if($_SESSION['wap_username']==$dateien[0]){$_SESSION['wap_userfile']=$dateien[1];}
            }
          }
          fclose($datei);
        }
      }elseif($_SESSION['wap_userok']==2){
        $_SESSION['wap_userfile']="";
      }
    }
  }
}
?>