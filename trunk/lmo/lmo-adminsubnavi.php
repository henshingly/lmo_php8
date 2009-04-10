<table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><? 
if($st<0 || $todo!="edit"){?>
    <td align="center"><a href='<?=$addr?>1' onClick="return chklmolink();" title="<?=$text[411]?>"><?=$text[412]?></a></td><?
}else{?>
    <td align="center"><?=$text[412]?></td><?
}
if ($einspieler==1) {
  if ($st!=-4) {?>
      <td align="center"><a href='<?=$addr?>-4' onClick="return chklmolink();" title="<?=$text['spieler'][1]?>"><?=$text['spieler'][18]?></a></td><?
  }else{?>
      <td align="center"><?=$text['spieler'][18]?></td><?
  }
}

if($st!=-1){?>
    <td align="center"><a href='<?=$addr?>-1' onClick="return chklmolink();" title="<?=$text[100]?>"><?=$text[99]?></a></td><?
}else{?>
    <td align="center"><?=$text[99]?></td><?
}

if($hands==1){
  if($todo!="tabs"){?>
    <td align="center"><a href='<?=$addb.$stx?>' onClick="return chklmolink();" title="<?=$text[409]?>"><?=$text[410]?></a></td><?
  }else{?>
    <td align="center"><?=$text[410]?></td><?
  }
}

if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){
  if($st!=-2){?>
    <td align="center"><a href='<?=$addr?>-2' onClick="return chklmolink();" title="<?=$text[102]?>"><?=$text[101]?></a></td><?
  }else{?>
    <td align="center"><?=$text[101]?></td><?
  }
}?>
  </tr>
</table>