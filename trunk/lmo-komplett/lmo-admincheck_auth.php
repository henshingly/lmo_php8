<?

if(!isset($_SESSION['lmousername'])){$_SESSION['lmousername']="";}
if(!isset($_SESSION['lmouserpass'])){$_SESSION['lmouserpass']="";}
if(!isset($_SESSION['lmouserfile'])){$_SESSION['lmouserfile']="";}
if(!isset($_SESSION['lmouserokerweitert'])){$_SESSION['lmouserokerweitert']=0;}
if(!isset($_SESSION['lmouserok']) || $_SESSION['lmouserok']==0){
  if(isset($_POST["xusername"])){
    $_SESSION['lmousername']=$_POST["xusername"];
    $_SESSION['lmouserpass']=$_POST["xuserpass"];
    require(PATH_TO_LMO."/lmo-loadauth.php");
    foreach ($lmo_admin_data as $lmo_admin) {

      if(($_SESSION['lmousername']==$lmo_admin[0]) && ($_SESSION['lmouserpass']==$lmo_admin[1])){
        $_SESSION['lmouserok']=$lmo_admin[2];
        if($_SESSION['lmouserok']==1){
          $_SESSION['lmouserfile']=isset($lmo_admin[3])?$lmo_admin[3]:'';
          $_SESSION['lmouserokerweitert']=isset($lmo_admin[4])?$lmo_admin[4]:0;
        }
        break;
      }
    }
  }
}
?>