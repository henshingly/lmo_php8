<?
  switch ($show) {
    case 0:
      isset($_POST["xtippmodus"])?                            $tipp_tippmodus=$_POST["xtippmodus"]:                   $tipp_tippmodus=0;
      break;
    case 1:
      isset($_POST["xdirtipp"])?                              $tipp_dirtipp=$_POST["xdirtipp"]:                       $tipp_krit1="tipps/";
      if(substr($tipp_dirtipp,-1)!="/"){                      $tipp_dirtipp=$tipp_dirtipp."/";}
                                                              $tipp_dirtipp=str_replace("\\","/",$tipp_dirtipp);
      break;
    case 2:
      if ($tipp_tippmodus==1) {
        isset($_POST["xrergebnis"])  && 
          is_numeric($_POST["xrergebnis"]) &&
          intval($_POST["xrergebnis"])>0 ?                    $tipp_rergebnis=$_POST["xrergebnis"]:                   $tipp_rergebnis=0;
        isset($_POST["xrtendenzdiff"]) &&
          is_numeric($_POST["xrtendenzdiff"]) &&
          intval($_POST["xrtendenzdiff"])>0 ?                 $tipp_rtendenzdiff=$_POST["xrtendenzdiff"]:             $tipp_rtendenzdiff=0;
        if ($tipp_rergebnis<$tipp_rtendenzdiff) {             $tipp_rergebnis=$tipp_rtendenzdiff;}
        isset($_POST["xrtendenz"]) &&
          is_numeric($_POST["xrtendenz"]) &&
          intval($_POST["xrtendenz"])>0 ?                     $tipp_rtendenz=$_POST["xrtendenz"]:                     $tipp_rtendenz=0;
        if ($tipp_rtendenzdiff<$tipp_rtendenz) {              $tipp_rtendenzdiff=$tipp_rtendenz;}
        isset($_POST["xrtor"])  &&
          is_numeric($_POST["xrtor"]) &&
          intval($_POST["xrtor"])>0 ?                         $tipp_rtor=$_POST["xrtor"]:                             $tipp_rtor=0;
        isset($_POST["xrtendenztor"])?                        $tipp_rtendenztor=$_POST["xrtendenztor"]:               $tipp_rtendenztor=0;
        isset($_POST["xrtendenzremis"])?                      $tipp_rtendenzremis=$_POST["xrtendenzremis"]:           $tipp_rtendenzremis=0;
      }
      
      isset($_POST["xrremis"])  &&
        is_numeric($_POST["xrremis"]) &&
        intval($_POST["xrremis"])>0 ?                         $tipp_rremis=$_POST["xrremis"]:                         $tipp_rremis=0;
      
      isset($_POST["xentscheidungnv"])?                       $tipp_entscheidungnv=1:                                 $tipp_entscheidungnv=0;
      isset($_POST["xentscheidungie"])?                       $tipp_entscheidungie=1:                                 $tipp_entscheidungie=0;
      
      isset($_POST["xgtpunkte"])?                             $tipp_gtpunkte=$_POST["xgtpunkte"]:                     $tipp_gtpunkte=0;
      break;
    case 3:
      isset($_POST["xtippeinsicht"])?                         $tipp_tippeinsicht=1:                                   $tipp_tippeinsicht=0;
      isset($_POST["xtipptabelle1"])?                         $tipp_tipptabelle1=1:                                   $tipp_tipptabelle1=0;
      isset($_POST["xtippfieber"])?                           $tipp_tippfieber=1:                                     $tipp_tippfieber=0;
      if (isset($_POST["xgesamt"])) {
        $tipp_gesamt=1;
      } else {
        $tipp_gesamt=0;
        $tipp_nurgesamt=0;
      }
      isset($_POST["xregeln"])?                               $tipp_regeln=1:                                         $tipp_regeln=0;
      if($tipp_regeln==1){
        isset($_POST["xregelnlink"])?                         $tipp_regelnlink=$_POST["xregelnlink"]:                 $tipp_regelnlink="tippregeln.php";
      }
      isset($_POST["xshownick"])?                             $tipp_shownick=$_POST["xshownick"]:                     $tipp_shownick="";
      isset($_POST["xshowname"])?                             $tipp_showname=$_POST["xshowname"]:                     $tipp_showname="";
      isset($_POST["xshowemail"])?                            $tipp_showemail=$_POST["xshowemail"]:                   $tipp_showemail="";
      if($tipp_showname==0 && $tipp_showemail==0){            $tipp_shownick=1;}
      break;
    case 4:
      isset($_POST["xtippohne"])?                             $tipp_tippohne=$_POST["xtippohne"]:                     $tipp_tippohne=0;
      
      isset($_POST["xtippbis"])  &&
        is_numeric($_POST["xtippbis"])?                       $tipp_tippBis=$_POST["xtippbis"]:                       $tipp_tippBis=0;
      
      isset($_POST["xtipperteam"])  &&
        is_numeric($_POST["xtipperteam"])?                    $tipp_tipperimteam=$_POST["xtipperteam"]:               $tipp_tipperimteam=0;
      
      isset($_POST["ximvorraus"])  &&
        is_numeric($_POST["ximvorraus"])?                     $tipp_imvorraus=$_POST["ximvorraus"]:                   $tipp_imvorraus=-1;  
      
      isset($_POST["xjokertipp"])?                            $tipp_jokertipp=1:                                      $tipp_jokertipp=0;
      if($tipp_jokertipp==1){
        isset($_POST["xjokertippmulti"])  &&
          is_numeric($_POST["xjokertippmulti"]) &&
          intval($_POST["xjokertippmulti"])>0 ?               $tipp_jokertippmulti=$_POST["xjokertippmulti"]:         $tipp_jokertippmulti=2;
      }
      break;
    case 5:
      isset($_POST["xadresse"])?                              $tipp_adresse=1:                                        $tipp_adresse=0;
      isset($_POST["xrealname"])?                             $tipp_realname=1:                                       $tipp_realname=0;
      isset($_POST["xfreischaltcode"])?                       $tipp_freischaltcode=1:                                 $tipp_freischaltcode=0;
      isset($_POST["xfreischaltung"])?                        $tipp_freischaltung=1:                                  $tipp_freischaltung=0;
      isset($_POST["xmailbeianmeldung"])?                     $tipp_mailbeianmeldung=1:                               $tipp_mailbeianmeldung=0;
    break;
    case 6:
      isset($_POST["xpfeiltipp"])?                            $tipp_pfeiltipp=1:                                      $tipp_pfeiltipp=0;
      isset($_POST["xshowtendenzabs"])?                       $tipp_showtendenzabs=$_POST["xshowtendenzabs"]:         $tipp_showtendenzabs="";
      isset($_POST["xshowtendenzpro"])?                       $tipp_showtendenzpro=$_POST["xshowtendenzpro"]:         $tipp_showtendenzpro="";
      isset($_POST["xshowdurchschntipp"])?                    $tipp_showdurchschntipp=$_POST["xshowdurchschntipp"]:   $tipp_showdurchschntipp="";
      if($tipp_showtendenzabs==1 || 
         $tipp_showtendenzpro==1 || 
         ($tipp_showdurchschntipp==1 && $tipp_tippmodus==1)){ $tipp_tippeinsicht=1;}
      isset($_POST["xsttipp"])?                               $tipp_sttipp=1:                                         $tipp_sttipp=-1;
      isset($_POST["xviewertipp"])?                           $tipp_viewertipp=1:                                     $tipp_viewertipp=0;
      if ($tipp_viewertipp==1) {
        isset($_POST["xviewertage"])  &&
          is_numeric($_POST["xviewertage"]) &&
          intval($_POST["xviewertage"])>0 ?                   $tipp_viewertage=$_POST["xviewertage"]:                 $tipp_viewertage=8;
      }
      isset($_POST["xakteinsicht"])?                          $tipp_akteinsicht=1:                                    $tipp_akteinsicht=0;
      break;
    case 7:
      isset($_POST["xeinsichterst"])?                         $tipp_einsichterst=$_POST["xeinsichterst"]:             $tipp_einsichterst=0;
      isset($_POST["xanzseite"])  &&
        is_numeric($_POST["xanzseite"]) &&
        intval($_POST["xanzseite"])>0 ?                       $tipp_anzseite=$_POST["xanzseite"]:                     $tipp_anzseite=40;
      break;
    case 8:
      isset($_POST["xtipptabelle"])?                          $tipp_tipptabelle=1:                                    $tipp_tipptabelle=0;
      isset($_POST["xwertverein"])?                           $tipp_wertverein=1:                                     $tipp_wertverein=0;
      break;
    case 9:
      isset($_POST["xnurgesamt"])?                  $tipp_nurgesamt=1:                            $tipp_nurgesamt=0;
      
      isset($_POST["xanzseite1"])  &&
            is_numeric($_POST["xanzseite1"]) &&
            intval($_POST["xanzseite1"])>0 ?                  $tipp_anzseite1=$_POST["xanzseite1"]:                   $tipp_anzseite1=40;
      isset($_POST["xshowzus"])?                              $tipp_showzus=1:                                        $tipp_showzus=0;
      isset($_POST["xshowstsiege"])?                          $tipp_showstsiege=1:                                    $tipp_showstsiege=0;
      break;
    case 10:
      isset($_POST["xkrit1"])?                                $tipp_krit1=$_POST["xkrit1"]:                           $tipp_krit1=0;
      isset($_POST["xkrit2"])?                                $tipp_krit2=$_POST["xkrit2"]:                           $tipp_krit2=0;
      isset($_POST["xkrit3"])?                                $tipp_krit3=$_POST["xkrit3"]:                           $tipp_krit3=0;
      break;
    case 11:
      isset($_POST["xaktauswert"])?                           $tipp_aktauswert=1:                                     $tipp_aktauswert=0;
      isset($_POST["xaktauswertges"])?                        $tipp_aktauswertges=1:                                  $tipp_aktauswertges=0;
      break;
    case 12:
      isset($_POST["ximmeralle"])?                            $tipp_immeralle=1:                                      $tipp_immeralle=0;
      $tipp_ligenzutippen="";
      if($tipp_immeralle!=1){
        if(isset($_POST["xtipperligen"]) && !empty($_POST["xtipperligen"])){
          $tipp_ligenzutippen=implode(",",$_POST["xtipperligen"]);
        }
      }
      break;
    }
    //isset($_POST["xtippspiel"])?                            $tipp_tippspiel=1:                                      $tipp_tippspiel=0;
?>