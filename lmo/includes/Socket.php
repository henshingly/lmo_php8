<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Net_FTP socket implementation of FTP functions.
 *
 * The functions in this file emulate the ext/FTP functions through
 * ext/Socket.
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.0 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_0.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category  Networking
 * @package   FTP
 * @author    Tobias Schlitt <toby@php.net>
 * @copyright 1997-2008 The PHP Group
 * @license   http://www.php.net/license/3_0.txt  PHP License 3.0
 * @version   CVS: $Id: Socket.php,v 1.5.2.2 2008/04/22 19:47:08 jschippers Exp $
 * @link      http://pear.php.net/package/Net_FTP
 * @since     File available since Release 0.0.1
 */

error_reporting(E_ALL);

/**
* Default FTP extension constants
*/
define('FTP_ASCII', 0);
define('FTP_TEXT', 0);
define('FTP_BINARY', 1);
define('FTP_IMAGE', 1);
define('FTP_TIMEOUT_SEC', 0);

/**
* What needs to be done overall?
*   #1 Install the rest of these functions
*   #2 Document better
*   #3 Alot of other things I don't remember
*/

/*
 * !!! NOTE !!!
 * Most of the comment's are "not working",
 * meaning they are not all up-to-date     
 * !!! NOTE !!!
 */

/**
 * &resource ftp_connect ( string host [, int port [, int timeout ] ] );
 *
 * Opens an FTP connection and return resource or FALSE on failure.
 *
 * FTP Success respons code: 220
 *
 * @param string $host    Host to connect to
 * @param int    $port    Optional, port to connect to
 * @param int    $timeout Optional, seconds until function timeouts
 *
 * @todo The FTP extension has ftp_get_option() function which returns the
 * timeout variable. This function needs to be created and contain it as
 * static variable.
 * @todo The FTP extension has ftp_set_option() function which sets the
 * timeout variable. This function needs to be created and called here.
 * @access public
 * @return &resource
 */
function &ftp_connect($host, $port = 21, $timeout = 90)
{
    $FALSE = FALSE; // We are going to return refrence (E_STRICT)

    if (!is_string($host) || !is_integer($port) || !is_integer($timeout)) {
        return $FALSE;
    }

    $control                        = @fsockopen($host, $port, $iError, $sError,
        $timeout);
    $GLOBALS['_NET_FTP']['timeout'] = $timeout;

    if (!is_resource($control)) {
        return $FALSE;
    }

    stream_set_blocking($control, TRUE);
    stream_set_timeout($control, $timeout);

    do {
        $content[] = fgets($control, 8129);
        $array     = socket_get_status($control);
    } while ($array['unread_bytes'] > 0);

    if (substr($content[count($content)-1], 0, 3) == 220) {
        return $control;
    }

    return $FALSE;
}

/**
 * boolean ftp_login ( resource stream, string username, string password );
 *
 * Logs in to an given FTP connection stream.
 * Returns TRUE on success or FALSE on failure.
 *
 * NOTE:
 *       Username and password are *not* optional. Function will *not*
 *       assume "anonymous" if username and/or password is empty
 *
 * FTP Success respons code: 230
 *
 * @param resource &$control FTP resource to login to
 * @param string   $username FTP Username to be used
 * @param string   $password FTP Password to be used
 *
 * @access public
 * @return   boolean
 */
function ftp_login(&$control, $username, $password)
{
    if (!is_resource($control) || is_null($username)) {
        return FALSE;
    }

    fputs($control, 'USER '.$username."\r\n");
    $contents = array();
    do {
        $contents[] = fgets($control, 8192);
        $array      = socket_get_status($control);
    } while ($array['unread_bytes'] > 0);

    if (substr($contents[count($contents)-1], 0, 3) != 331) {
        return FALSE;
    }

    fputs($control, 'PASS '.$password."\r\n");
    $contents = array();
    do {
        $contents[] = fgets($control, 8192);
        $array      = socket_get_status($control);
    } while ($array['unread_bytes']);

    if (substr($contents[count($contents)-1], 0, 3) == 230) {
        return TRUE;
    }

    trigger_error('ftp_login() [<a href="function.ftp-login">function.ftp-login'.
        '</a>]: '.$contents[count($contents)-1], E_USER_WARNING);
    
    return FALSE;
}

/**
 * boolean ftp_quit ( resource stream );
 *
 * Closes FTP connection.
 * Returns TRUE or FALSE on error.
 *
 * NOTE: The PHP function ftp_quit is *alias* to ftp_close, here it is
 * the *other-way-around* ( ftp_close() is alias to ftp_quit() ).
 *
 * NOTE:
 *       resource is set to null since unset() can't unset the variable.
 *
 * @param resource &$control FTP resource
 *
 * @access public
 * @return boolean
 */
function ftp_quit(&$control)
{
    if (!is_resource($control)) {
        return FALSE;
    }

    fputs($control, 'QUIT'."\r\n");
    fclose($control);
    $control = null;
    return TRUE;
}

/**
 * Alias to ftp_quit()
 *
 * @param resource &$control FTP resource
 *
 * @see ftp_quit()
 * @access public
 * @return boolean
 */
function ftp_close(&$control)
{
    return ftp_quit($control);
}

/**
 * string ftp_pwd ( resource stream );
 *
 * Gets the current directory name.
 * Returns the current directory.
 *
 * Needs data connection: NO
 * Success response code: 257
 *
 * @param resource &$control FTP resource
 *
 * @access public
 * @return string
 */
function ftp_pwd(&$control)
{
    if (!is_resource($control)) {
        return $control;
    }

    fputs($control, 'PWD'."\r\n");

    $content = array();
    do {
        $content[] = fgets($control, 8192);
        $array     = socket_get_status($control);
    } while ($array['unread_bytes'] > 0);

    if (substr($cont = $content[count($content)-1], 0, 3) == 257) {
        $pos  = strpos($cont, '"')+1;
        $pos2 = strrpos($cont, '"') - $pos;
        $path = substr($cont, $pos, $pos2);
        return $path;
    }

    return FALSE;
}

/**
 * boolean ftp_chdir ( resource stream, string directory );
 *
 * Changes the current directory to the specified directory.
 * Returns TRUE on success or FALSE on failure.
 *
 * FTP success response code: 250
 * Needs data connection: NO
 *
 * @param resource &$control FTP stream
 * @param string   $pwd      Directory name
 *
 * @access public
 * @return boolean
 */
function ftp_chdir(&$control, $pwd)
{
    if (!is_resource($control) || !is_string($pwd)) {
        return FALSE;
    }

    fputs($control, 'CWD '.$pwd."\r\n");
    $content = array();
    do {
        $content[] = fgets($control, 8192);
        $array     = socket_get_status($control);
    } while ($array['unread_bytes'] > 0);

    if (substr($content[count($content)-1], 0, 3) == 250) {
        return TRUE;
    }

    trigger_error('ftp_chdir() [<a
            href="function.ftp-chdir">function.ftp-chdir</a>]:
                ' .$content[count($content)-1], E_USER_WARNING);

    return FALSE;
}

$_NET_FTP                = array();
$_NET_FTP['USE_PASSIVE'] = FALSE;
$_NET_FTP['DATA']        = null;

/**
 * boolean ftp_pasv ( resource stream, boolean passive );
 *
 * Toggles passive mode ON/OFF.
 * Returns TRUE on success or FALSE on failure.
 *
 * Comment:
 *       Although my lack of C knowlege I checked how the PHP FTP extension
 *       do things here. Seems like they create the data connection and store
 *       it in object for other functions to use.
 *       This is now done here.
 *
 * FTP success response code: 227
 *
 * @param stream  &$control FTP stream
 * @param boolean $pasv     True to switch to passive, FALSE for active mode
 *
 * @access public
 * @return boolean
 */
function ftp_pasv(&$control, $pasv)
{
    if (!is_resource($control) || !is_bool($pasv)) {
        return FALSE;
    }

    // If data connection exists, destroy it
    if (isset($GLOBALS['_NET_FTP']['DATA'])) {
        fclose($GLOBALS['_NET_FTP']['DATA']);
        $GLOBALS['_NET_FTP']['DATA'] = null;

        do {
            fgets($control, 16);
            $array = socket_get_status($control);
        } while ($array['unread_bytes'] > 0);
    }

    // Are we suppost to create active or passive connection?
    if (!$pasv) {
        $GLOBALS['_NET_FTP']['USE_PASSIVE'] = FALSE;
        // Pick random "low bit"
        $low = rand(39, 250);
        // Pick random "high bit"
        $high = rand(39, 250);
        // Lowest  possible port would be; 10023
        // Highest possible port would be; 64246

        $port = ($low<<8)+$high;
        $ip   = str_replace('.', ',', $_SERVER['SERVER_ADDR']);
        $s    = $ip.','.$low.','.$high;

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if (is_resource($socket)) {
            if (socket_bind($socket, '0.0.0.0', $port)) {
                if (socket_listen($socket)) {
                    $GLOBALS['_NET_FTP']['DATA'] = &$socket;
                    fputs($control, 'PORT '.$s."\r\n");
                    $line = fgets($control, 512);
                    if (substr($line, 0, 3) == 200) {
                        return TRUE;
                    }
                }
            }
        }
        return FALSE;
    }

    // Since we are here, we are suppost to create passive data connection.
    $i = fputs($control, 'PASV' ."\r\n");

    $content = array();
    do {
        $content[] = fgets($control, 128);
        $array     = socket_get_status($control);
    } while ($array['unread_bytes']);

    if (substr($cont = $content[count($content)-1], 0, 3) != 227) {
        return FALSE;
    }

    $pos    = strpos($cont, '(')+1;
    $pos2   = strrpos($cont, ')')-$pos;
    $string = substr($cont, $pos, $pos2);

    $array = split(',', $string);
    // IP we are connecting to
    $ip = $array[0]. '.' .$array[1]. '.' .$array[2]. '.' .$array[3];
    // Port ( 256*lowbit + highbit
    $port = ($array[4] << 8)+$array[5];

    // Our data connection
    $data = fsockopen($ip, $port, $iError, $sError,
        $GLOBALS['_NET_FTP']['timeout']);

    if (is_resource($data)) {
        $GLOBALS['_NET_FTP']['USE_PASSIVE'] = TRUE;
        $GLOBALS['_NET_FTP']['DATA']        = &$data;
        stream_set_blocking($data, TRUE);
        stream_set_timeout($data, $GLOBALS['_NET_FTP']['timeout']);

        return TRUE;
    }

    return FALSE;
}

/**
 * array ftp_rawlist ( resource stream, string directory [,bool recursive] );
 *
 * Returns a detailed list of files in the given directory.
 *
 * Needs data connection: YES
 *
 * @param integer &$control  FTP resource
 * @param string  $pwd       Path to retrieve
 * @param boolean $recursive Optional, retrieve recursive listing
 *
 * @todo Enable the recursive feature.
 * @access public
 * @return   array
 */
function ftp_rawlist(&$control, $pwd, $recursive = FALSE)
{
    if (!is_resource($control) || !is_string($pwd)) {
        return FALSE;
    }

    if (!isset($GLOBALS['_NET_FTP']['DATA']) ||
            !is_resource($GLOBALS['_NET_FTP']['DATA'])) {
        ftp_pasv($control, $GLOBALS['_NET_FTP']['USE_PASSIVE']);
    }
    fputs($control, 'LIST '.$pwd."\r\n");

    $msg = fgets($control, 512);
    if (substr($msg, 0, 3) == 425) {
        return FALSE;
    }

    $data = &$GLOBALS['_NET_FTP']['DATA'];
    if (!$GLOBALS['_NET_FTP']['USE_PASSIVE']) {
        $data = &socket_accept($data);
    }

    $content = array();

    switch ($GLOBALS['_NET_FTP']['USE_PASSIVE']) {
    case TRUE:
        while (TRUE) {
            $string = rtrim(fgets($data, 1024));
            
            if ($string=='') {
                 break;
            }
            
            $content[] = $string;
        }
        
        fclose($data);
        break;
        
    case FALSE:
        $string = socket_read($data, 1024, PHP_BINARY_READ);
        
        $content = explode("\n", $string);
        unset($content[count($content)-1]);
        
        socket_close($GLOBALS['_NET_FTP']['DATA']);
        socket_close($data);
        break;
    }

    $data = $GLOBALS['_NET_FTP']['DATA'] = null;

    $f = fgets($control, 1024);
    return $content;
}

/**
 * string ftp_systype ( resource stream );
 *
 * Gets system type identifier of remote FTP server
 * Returns the remote system type
 *
 * @param resource &$control FTP resource
 *
 * @access public
 * @return string
 */
function ftp_systype(&$control)
{
    if (!is_resource($control)) {
        return FALSE;
    }

    fputs($control, 'SYST'."\r\n");
    $line = fgets($control, 256);

    if (substr($line, 0, 3) != 215) {
        return FALSE;
    }

    $os = substr($line, 4, strpos($line, ' ', 4)-4);
    return $os;
}

/**
 * boolean ftp_alloc ( resource stream, integer bytes [, string &message ] );
 *
 * Allocates space for a file to be uploaded
 * Return TRUE on success or FALSE on failure
 *
 * NOTE; Many FTP servers do not support this command and/or don't need it.
 *
 * FTP success respons key: Belive it's 200
 * Needs data connection: NO
 *
 * @param resource &$control FTP stream
 * @param integer  $int      Space to allocate
 * @param string   &$msg     Optional, textual representation of the servers response
 *                           will be returned by reference
 *
 * @access public
 * @return   boolean
 */
function ftp_alloc(&$control, $int, &$msg = null)
{
    if (!is_resource($control) || !is_integer($int)) {
        return FALSE;
    }

    fputs($control, 'ALLO '.$int.' R '.$int."\r\n");

    $msg = rtrim(fgets($control, 256));

    $code = substr($msg, 0, 3);
    if ($code == 200 || $code == 202) {
        return TRUE;
    }

    return FALSE;
}

/**
 * bool ftp_put ( resource stream, string remote_file, string local_file,
 *               int mode [, int startpos ] );
 *
 * Uploads a file to the FTP server
 * Returns TRUE on success or FALSE on failure.
 *
 * NOTE:
 *       The transfer mode specified must be either FTP_ASCII or FTP_BINARY.
 *
 * @param resource &$control FTP stream
 * @param string   $remote   Remote file to write
 * @param string   $local    Local file to upload
 * @param integer  $mode     Upload mode, FTP_ASCI || FTP_BINARY
 * @param integer  $pos      Optional, start upload at position
 *
 * @access public
 * @return boolean
 */
function ftp_put(&$control, $remote, $local, $mode, $pos = 0)
{
    if (!is_resource($control) || !is_readable($local) ||
            !is_integer($mode) || !is_integer($pos)) {
        return FALSE;
    }

    $types   = array (
        0 => 'A',
        1 => 'I'
    );
    $windows = array (
        0 => 't',
        1 => 'b'
    );

    /**
    * TYPE values:
    *       A ( ASCII  )
    *       I ( BINARY )
    *       E ( EBCDIC )
    *       L ( BYTE   )
    */

    if (!isset($GLOBALS['_NET_FTP']['DATA']) ||
            !is_resource($GLOBALS['_NET_FTP']['DATA'])) {
        ftp_pasv($control, $GLOBALS['_NET_FTP']['USE_PASSIVE']);

    }
    // Establish data connection variable
    $data = &$GLOBALS['_NET_FTP']['DATA'];

    // Decide TYPE to use
    fputs($control, 'TYPE '.$types[$mode]."\r\n");
    $line = fgets($control, 256); // "Type set to TYPE"
    if (substr($line, 0, 3) != 200) {
        return FALSE;
    }

    fputs($control, 'STOR '.$remote."\r\n");
    sleep(1);
    $line = fgets($control, 256); // "Opening TYPE mode data connect."

    if (substr($line, 0, 3) != 150) {
        return FALSE;
    }

    // Creating resource to $local file
    $fp = fopen($local, 'r'. $windows[$mode]);
    if (!is_resource($fp)) {
        $fp = null;
        return FALSE;
    }

    // Loop throu that file and echo it to the data socket
    $i = 0;
    switch ($GLOBALS['_NET_FTP']['USE_PASSIVE']) {
    case FALSE:
        $data = &socket_accept($data);
        while (!feof($fp)) {
            $i += socket_write($data, fread($fp, 10240), 10240);
        }
        socket_close($data);
        break;

    case TRUE:
        while (!feof($fp)) {
            $i += fputs($data, fread($fp, 10240), 10240);
        }
        
        fclose($data);
        break;
    }

    $data = null;
    do {
        $line = fgets($control, 256);
    } while (substr($line, 0, 4) != "226 ");
    return TRUE;
}

/**
 * Retrieve a remote file to a local file
 * Returns TRUE on success or FALSE on failure
 *
 * @param integer &$control Stream ID
 * @param string  $local    Local filename
 * @param string  $remote   Remote filename
 * @param integer $mode     Transfer mode (FTP_ASCII or FTP_BINARY)
 * @param integer $resume   Resume the file transfer or not
 *
 * @access public
 * @return boolean
 */
function ftp_get(&$control, $local, $remote, $mode, $resume = 0)
{
    if (!is_resource($control) || !is_writable(dirname($local)) ||
            !is_integer($mode) || !is_integer($resume)) {
        return FALSE;
    }
    $types   = array (
            0 => 'A',
            1 => 'I'
    );
    $windows = array (
            0 => 't',
            1 => 'b'
    );

    if (!isset($GLOBALS['_NET_FTP']['DATA']) ||
            !is_resource($GLOBALS['_NET_FTP'][ 'DATA'])) {
        ftp_pasv($control, $GLOBALS['_NET_FTP']['USE_PASSIVE']);
    }
    $data = &$GLOBALS['NET_FTP']['DATA'];

    fputs($control, 'TYPE '.$types[$mode]."\r\n");
    $line = fgets($control, 256);
    if (substr($line, 0, 3) != 200) {
        return FALSE;
    }

    $fp = fopen($local, 'w'.$windows[$mode]);
    if (!is_resource($fp)) {
        $fp = null;
        return FALSE;
    }
}

/**
 * Changes to the parent directory
 * Returns TRUE on success or FALSE on failure
 *
 * @param integer &$control Stream ID
 *
 * @access public
 * @return boolean
 */
function ftp_cdup(&$control)
{
    fputs($control, 'CDUP'."\r\n");
    $line = fgets($control, 256);

    if (substr($line, 0, 3) != 250) {
        return FALSE;
    }

    return TRUE;
}

/**
 * Set permissions on a file via FTP
 * Returns the new file permission on success or FALSE on error
 *
 * NOTE: This command is *not* supported by the standard
 * NOTE: This command not ready!
 *
 * @param integer &$control Stream ID
 * @param integer $mode     Octal value
 * @param string  $file     File to change permissions on
 *
 * @todo Figure out a way to chmod files via FTP
 * @access public
 * @return integer
 */
function ftp_chmod(&$control, $mode, $file)
{
    if (!is_resource($control) || !is_integer($mode) || !is_string($file)) {
        return FALSE;
    }

    // chmod not in the standard, proftpd doesn't recognize it
    // use SITE CHMOD?
    fputs($control, 'SITE CHMOD '.$mode. ' ' .$file."\r\n");
    $line = fgets($control, 256);

    if (substr($line, 0, 3) == 200) {
        return $mode;
    }

    trigger_error('ftp_chmod() [<a
            href="function.ftp-chmod">function.ftp-chmod</a>]: ' .
            rtrim($line), E_USER_WARNING);
    return FALSE;
}

/**
 * Deletes a file on the FTP server
 * Returns TRUE on success or FALSE on failure
 *
 * @param integer &$control Stream ID
 * @param string  $path     File to delete
 *
 * @access public
 * @return boolean
 */
function ftp_delete(&$control, $path)
{
    if (!is_resource($control) || !is_string($path)) {
        return FALSE;
    }

    fputs($control, 'DELE '.$path."\r\n");
    $line = fgets($control, 256);

    if (substr($line, 0, 3) == 250) {
        return TRUE;
    }

    return FALSE;
}

/**
 * Requests execution of a program on the FTP server
 * NOTE; SITE EXEC is *not* supported by the standart
 * Returns TRUE on success or FALSE on error
 *
 * @param integer &$control Stream ID
 * @param string  $cmd      Command to send
 *
 * @access public
 * @todo Look a littlebit better into this
 * @return boolean
 */
function ftp_exec(&$control, $cmd)
{
    if (!is_resource($control) || !is_string($cmd)) {
        return FALSE;
    }
    // Command not defined in the standart
    // proftpd doesn't recognize SITE EXEC (only help,chgrp,chmod and ratio)
    fputs($control, 'SITE EXEC '.$cmd."\r\n");
    $line = fgets($control, 256);

    // php.net/ftp_exec uses respons code 200 to verify if command was sent
    // successfully or not, so we'll just do the same
    if (substr($line, 0, 3) == 200) {
        return TRUE;
    }

    return FALSE;
}
?>
