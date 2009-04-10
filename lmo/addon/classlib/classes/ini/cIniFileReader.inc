<?
/*
CLASS NAME
INI File Reader

VERSION
1.0

AUTHOR
Scott Christensen (raven1004@home.com)

LICENCE
I am providing this class as is with NO WARRANTY and I take no
responsibility for any problems that occur as a result of using this
software.  You may modify this code as you like as long as this notice
remains in tact. Please let me know via email what changes you
have made so that I may update my code if it makes sense to do so.

If you have any problems with the class, please let me know what they are so that I
may fix them promptly.  I may or may not come out with updates to this
code depending on the issues that arise and time permitting.

Finally, please also let me know if you are using this in any production envrionment
(or for that matter, any environment at all). I am extremely interested in finding
out if the classes I write are useful to others or just to me.  If you are using them,
please send the link when you write.

If you redistribute this code please mention in your script my info (Name & Email) as it's creator.
If you are using this code please send me your feedback and your improvements to it.

CHANGE LOG

Version  Name                  Date        Description
--------+---------------------+-----------+---------------------------------------------
1.0.0    Scott Christensen     04/04/2001  Creation
1.0.1    Scott Christensen     04/08/2001  Fixed error that caused class to not function
                                           properly.
1.0.2    Scott Christensen     04/20/2001  Added better function comments, added more
                                           error checking on file opens and closes.  Lock
                                           file when writing to it.  Added PHP version
                                           checking when removing comments so they are
                                           removed properly.
1.0.3    Scott Christensen     05/03/2001  Added function sections() that returns all
                                           sections in an ini file, keys() that returns
                                           all keys for the given section and
                                           deleteKey() which deletes a key for the
                                           given section.
--------+---------------------+-----------+---------------------------------------------
*/

/*
This class requires the PHPVer class which can be found on
phpclasses.upperdesign.com
*/
 //require($DOCUMENT_ROOT."/library/headers/hPHPVersion.inc");


/**
This class allows one to read or write to a file with the INI format.  There are two main
functions, setIniFile and getIniFile.  The first one associates a key with a given value
in a given section and the second returns the value for a given key in a given section.

@access public
*/
class IniFileReader {
    var $_iniFile;

    /**
    This is the constructor for the IniFileReader object
    @param iniFile This is the name of the file to read.  It is
    a required parameter.  If not passed in, the script will
    <code>die</code>.

    @param $iniFile The full path to the ini file to read or
    write to

    @access public
    */
    function IniFileReader($iniFile = "") {
        if (!(empty($iniFile))) {
            $this->_iniFile = $iniFile;
        } else {
            die("INI File Required");
        }
    }


    /**
    This function removes all comments from a given line.  A comment
    is defined as starting at a # marker and going to the end of the
    line.

    <p>This function requires the use of the PHP version parser which
    can be found on phpclasses.upperdesign.com

    @param $line The line to remove comments for.

    @return string The resulting string after removing the comments from
    the line.  May be an empty string.

    @access private
    */
    function removecomments($line) {
        $pos = strpos($line, "#");
//        $ver = new PHPVer();

        $bFound = true;
        if ($pos === false) $bFound = false;
/* Brauchen wir nicht mehr. Setzen mal PHP > 4.0b3 voraus
        if ($ver->compare("4.0b3") < 0) {
            // version >= 4.0b3
            $sEval = "if (\$pos === false) \$bFound = false;";
        } else {
            // version < 4.0b3
            $sEval = "if (is_string(\$pos) && !\$pos) \$bFound = false;";
        }

        eval($sEval);
*/
        if (!$bFound) {
            $tmpLine = $line;
        } else {
            $tmpLine = rtrim(substr($line, 0, $pos));
        }

        return $tmpLine;
    }


    /**
    This function returns true if the <code>$line</code> is the beginning of
    a section marker and false if it is not.

    @param $line The line to search for a section marker in

    @return boolean True if <code>$line</code> is the beginning of a section
    marker, false otherwise

    @access private
    */
    function issection($line) {
        return (substr($line, 0, 1) == "[");
    }

    function isEmtyLine($line) {
        return (!isset($line) or $line == "");
    }


    /**
    This function is used to set a key and value in the ini file
    for the given section

    @param $section The section to add the key/value pair to.

    @param $key The key in the key/value pair

    @param $value The value in the key/value pair

    @return boolean True if the data was updated, false if not.

    @access public
    */
    function setIniFile($section, $key, $value) {
        $found = false;

        $newline = "\n";
// Wo kommt $OS her?

/*        if (substr($OS, 0, 3) == "Win") {
            // windows environment
            $newline = "\r\n";
        } else {
            // other environment.  assume *nix
            $newline = "\n";
        }
*/
        // return false if the file does not exist
        if (!(file_exists($this->_iniFile))) {
            return false;
        }

        // read the entire contents of the file into the array
        $arrFile = file($this->_iniFile);
        // open the file for write access deleting all contents
        if (!($fp = @fopen($this->_iniFile, "w")) || !(flock($fp, 6))) {
            return false;
        } else {
            while (list($line_num, $line) = each($arrFile)) {
                $oldLine = trim($line);
                $line = trim($this->removecomments($oldLine));

                fputs($fp, $oldLine.$newline);

                if (strlen($line) > 0 && $line == "[".$section."]") {
                    $found = true;

                    $finished = false;
                    while (!$finished) {
                        if (list($line_num, $line) = each($arrFile)) {
                            $oldLine = trim($line);
                            $line = trim($this->removecomments($oldLine));

                            if (strlen($line) > 0) {
                                if ($this->issection($line)) {
                                    $finished = true;
                                    fputs($fp, $key."=".$value.$newline);
                                    prev($arrFile);
                                } else {
                                    $arrKeyVal = explode("=", $line);
                                    if (trim($arrKeyVal[0]) == $key) {
                                        $finished = true;
                                        fputs($fp, $key."=".$value.$newline);
                                    }
                                }
                            }

                            if (!$finished) {
                                fputs($fp, $oldLine.$newline);
                            }
                        } else {
                            $finished = true;
                            fputs($fp, $key."=".$value.$newline);
                        }
                    }
                }
            }

            if (!$found) {
                fputs($fp, "[".$section."]".$newline);
                fputs($fp, $key."=".$value.$newline);
            }

            flock($fp, 3) || die("Couldn't unlock file: ".$this->_iniFile);

            fclose($fp) || die("Couldn't close file: ".$this->_iniFile);
        }

        return true;
    }


    /**
    This function is used to delete a key in the ini file
    for the given section

    @param $section The section to add the key/value pair to.

    @param $key The key to delete from the section

    @return boolean True if the key was deleted, false if not.

    @access public
    */
    function deleteKey($section, $key) {
        $found = false;

        if (substr($OS, 0, 3) == "Win") {
            // windows environment
            $newline = "\r\n";
        } else {
            // other environment.  assume *nix
            $newline = "\n";
        }

        // return false if the file does not exist
        if (!(file_exists($this->_iniFile))) {
            return false;
        }

        // read the entire contents of the file into the array
        $arrFile = file($this->_iniFile);

        // open the file for write access deleting all contents
        if (!($fp = @fopen($this->_iniFile, "w")) || !(flock($fp, 6))) {
            return false;
        } else {
            while (list($line_num, $line) = each($arrFile)) {
                $oldLine = trim($line);
                $line = trim($this->removecomments($oldLine));

                fputs($fp, $oldLine.$newline);

                if (strlen($line) > 0 && $line == "[".$section."]") {
                    $found = true;

                    $finished = false;
                    while (!$finished) {
                        if (list($line_num, $line) = each($arrFile)) {
                            $oldLine = trim($line);
                            $line = trim($this->removecomments($oldLine));

                            if (strlen($line) > 0) {
                                if ($this->issection($line)) {
                                    $finished = true;
                                    prev($arrFile);
                                } else {
                                    $arrKeyVal = explode("=", $line);
                                    if (trim($arrKeyVal[0]) == $key) {
                                        $finished = true;
                                    }
                                }
                            }

                            if (!$finished) {
                                fputs($fp, $oldLine.$newline);
                            }
                        } else {
                            $finished = true;
                        }
                    }
                }
            }

            flock($fp, 3) || die("Couldn't unlock file: ".$this->_iniFile);

            fclose($fp) || die("Couldn't close file: ".$this->_iniFile);
        }

        return true;
    }


    /**
    This function gets a value for the given key in the given section.
    If the key does not exist in the section, the value given by
    the <code>$default</code> variable is returned.

    @param $section The section to look at when looking for the key

    @param $key The key that contains the value

    @param $default The value that is returned if <code>$key</code> is
    not found in <code>$section</code>

    @access public
    */
    function getIniFile($section, $key, $default="") {
        $value = $default;
        // read the entire contents of the file into the array
        if (file_exists($this->_iniFile)) {
            $arrFile = file($this->_iniFile);
        } else {
            $arrFile = array();
        }

        while (list($line_num, $line) = each($arrFile)) {
            $line = $this->removecomments(trim($line));

            if (strlen($line) > 0 && $line == "[".$section."]") {
                $finished = false;

                while (!$finished) {
                    if (list($line_num, $line) = each($arrFile)) {
                        $line = $this->removecomments(trim($line));

                        if ($this->issection($line)) {
                            $finished = true;
                        } else {
                            $arrKeyVal = explode("=", $line);
                            // NUll Line
                            if (count($arrKeyVal) == 2 and trim($arrKeyVal[0]) == $key) {
                                return trim($arrKeyVal[1]);
                            }
                            // Workaround um auch values die '=' enthalten zurückzugeben
                            // Timme
                            elseif (count($arrKeyVal) > 2 and trim($arrKeyVal[0]) == $key) {
                                $tmp='';
                                for ($sp = 1;$sp <count($arrKeyVal);$sp++) {
                                    if ($tmp=='')
                                      $tmp = $tmp.$arrKeyVal[$sp];
                                    else
                                      $tmp = $tmp.'='.$arrKeyVal[$sp];
                                }
                                return trim($tmp);
                            }
                        }
                    } else {
                        $finished = true;
                    }
                }
            }
        }

        return $value;
    }


    function sections() {
        $result = array();

        // read the entire contents of the file into the array
        if (file_exists($this->_iniFile)) {
            $arrFile = file($this->_iniFile);
        } else {
            $arrFile = array();
        }

        $i = 0;
        while (list($line_num, $line) = each($arrFile)) {
            $line = trim($this->removecomments(trim($line)));

            if (strlen($line) > 0 && $this->issection($line)) {
                $result[$i] = substr($line, 1, strlen($line) - 2);
                $i++;
            }
        }

        return $result;
    }


    function keys($section) {
        $keys = array();

        // read the entire contents of the file into the array
        if (file_exists($this->_iniFile)) {
            $arrFile = file($this->_iniFile);
        } else {
            $arrFile = array();
        }

        $i = 0;
        while (list($line_num, $line) = each($arrFile)) {
            $line = $this->removecomments(trim($line));

            if (strlen($line) > 0 && $line == "[".$section."]") {
                $finished = false;

                while (!$finished) {
                    if (list($line_num, $line) = each($arrFile)) {
                        $line = $this->removecomments(trim($line));

                        if ($this->issection($line)) {
                            $finished = true;
                        } else {
                            // Leerzeilen unterdrücken
                            if (!$this->isEmtyLine($line)) {
                              $arrKeyVal = explode("=", $line);
                              $keys[$i] = $arrKeyVal[0];
                              $i++;
                            }
                        }
                    } else {
                        $finished = true;
                    }
                }
            }
        }

        return $keys;
    }
}
?>