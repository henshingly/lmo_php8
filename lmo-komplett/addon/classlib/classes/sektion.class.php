<?
/**
 * Sektion
 *
 * Sektionen eines LigFiles zB. [Round1]
 *
 * @package   classLib
 * @access  public
*/

class sektion {
  var $keyValues;
  var $name;

  function sektion($new_name) {
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