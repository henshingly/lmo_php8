<table class="lmoSubmenu" width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr><? 
if($st<0 || $todo!="edit"){?>
    <td align="center"><a href='<?=$addr?>1' onclick="return chklmolink(this.href);" title="<?=$text[411]?>"><?=$text[412]?></a></td><?
}else{?>
    <td align="center"><?=$text[412]?></td><?
}
if($st!=-1){?>
    <td align="center"><a href='<?=$addr?>-1' onclick="return chklmolink(this.href);" title="<?=$text[100]?>"><?=$text[99]?></a></td><?
}else{?>
    <td align="center"><?=$text[99]?></td><?
}
if($hands==1){
  if($todo!="tabs"){?>
    <td align="center"><a href='<?=$addb.$stx?>' onclick="return chklmolink(this.href);" title="<?=$text[409]?>"><?=$text[410]?></a></td><?
  }else{?>
    <td align="center"><?=$text[410]?></td><?
  }
}
if($_SESSION['lmouserok']==2){
  if($st!=-2){?>
    <td align="center"><a href='<?=$addr?>-2' onclick="return chklmolink(this.href);" title="<?=$text[102]?>"><?=$text[101]?></a></td><?
  }else{?>
    <td align="center"><?=$text[101]?></td><?
  }
}?>
  </tr>
</table>