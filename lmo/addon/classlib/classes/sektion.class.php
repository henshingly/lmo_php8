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

class sektion
{
    public $keyValues;
    public $name;

    public function __construct($new_name)
    {
        $this->name = $new_name;
        $this->keyValues = [];
    }

    public function sektionName()
    {
        return '[' . $this->name . ']';
    }

    public function setKeyValue($new_key, $new_value)
    {
        $this->keyValues[$new_key] = $new_value;
    }

    public function addKeyValue($new_key, $new_value)
    {
        $this->keyValues[$new_key] = $new_value;
    }

    public function valueForKey($key)
    {
        return $this->keyValues[$key];
    }

    public function HTMLoutput()
    {
        echo '<BR>' . $this->sektionName();
        foreach ($this->keyValues as $key => $value) {
            echo "<BR>$key = $value";
        }
    }
}
