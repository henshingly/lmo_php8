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
  * $Id$
  */
?>
<nav>
  <ul class="nav nav-tabs nav-justified">
    <?php if($st<0 || $todo!="edit"){?>
    <li class="nav-item"><a href='<?php echo $addr?>1' class="nav-link"><?php echo $text[412]?></a></li><?php
    }else{?>
    <li class="nav-item active"><a href="#" class="nav-link active"><?php echo $text[412]?></a></li><?php
    }?>
    <?php if ($einspieler==1) {
       if ($st!=-4) {?>
      <li class="nav-item"><a href='<?php echo $addr?>-4' class="nav-link"><?php echo $text['spieler'][18]?></a></li><?php
      }else{?>
      <li class="nav-item active"><a href="#" class="nav-link active"><?php echo $text['spieler'][18]?></a></li><?php
      }
    } ?>
    <?php if($st!=-1){?>
    <li class="nav-item"><a href='<?php echo $addr?>-1' class="nav-link"><?php echo $text[99]?></a></li><?php
    }else{?>
    <li class="nav-item active"><a href="#" class="nav-link active"><?php echo $text[99]?></a></li><?php
    } ?>
    <?php if($hands==1){
         if($todo!="tabs"){?>
    <li class="nav-item"><a href='<?php echo $addb.$stx?>' class="nav-link"><?php echo $text[410]?></a></li><?php
         }else{?>
    <li class="nav-item active"><a href="#" class="nav-link active"><?php echo $text[410]?></a></li><?php
         }
    } ?>
    <?php if($_SESSION['lmouserok']==2 || $_SESSION['lmouserokerweitert']==1){
          if($st!=-2){?>
    <li class="nav-item"><a href='<?php echo $addr?>-2' class="nav-link"><?php echo $text[101]?></a></li><?php
          }else{?>
    <li class="nav-item active"><a href="#" class="nav-link active"><?php echo $text[101]?></a></li><?php
          }
    }?>
  </ul>
</nav>