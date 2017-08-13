<?php 
/**
 * Sektion
 *
 * Sektionen eines LigFiles zB. [Round1]
 *
 * @package   classLib
 * @access  public
 * @version $Id: sektion.class.php 514 2009-11-01 17:52:09Z jokerlmo $
 */

class sektion {
  var $keyValues;
  var $name;

  function __construct($new_name) {
    $this->name = $new_name;
    $this->keyValues = array();
  }

  function sektionName() {
    return "[".$this->name."]";
  }

  function setKeyValue ($new_key,$new_value) {
    $this->keyValues[$new_key]=$new_value;
  }

  function addKeyValue ($new_key,$new_value) {
    $this->keyValues[$new_key]=$new_value;
  }

  function valueForKey($key) {
    return $this->keyValues[$key];
  }

  function HTMLoutput() {
    echo"<BR>".$this->sektionName();
    foreach ($this->keyValues as $key=>$value) {
      echo"<BR>$key = $value";
    }
  }
}
?>
