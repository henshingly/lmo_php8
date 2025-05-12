<?php

/**
* This class extends Cache_Lite and uses output buffering to get the data to cache.
*
* There are some examples in the 'docs/examples' file
* Technical choices are described in the 'docs/technical' file
*
* @package Cache_Lite
*
* @author Fabien MARTY <fab@php.net>
*/

require_once(PATH_TO_LMO.'/includes/Lite.php');

class Cache_Lite_Output extends Cache_Lite
{

    // --- Public methods ---

    /**
    * Constructor
    *
    * $options is an assoc. To have a look at availables options,
    * see the constructor of the Cache_Lite class in 'Cache_Lite.php'
    *
    * @param array $options options
    * @access public
    */
    function Cache_Lite_Output($options)
    {
        $this->Cache_Lite($options);
    }

    /**
    * Start the cache
    *
    * @param string $id cache id
    * @param string $group name of the cache group
    * @return boolean true if the cache is hit (false else)
    * @access public
    */
    function start($id, $group = 'default')
    {
        $data = $this->get($id, $group);
        if ($data !== false) {
            echo($data);
            return true;
        } else {
            ob_start();
            ob_implicit_flush(false);
            return false;
        }
    }

    /**
    * Stop the cache
    *
    * @access public
    */
    function end()
    {
        $data = ob_get_contents();
        ob_end_clean();
        $this->save($data, $this->_id, $this->_group);
        echo($data);
    }

}


?>
