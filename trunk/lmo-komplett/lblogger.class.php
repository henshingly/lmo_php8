<?

/** * This class is for debugging and logging of infos and errors.
    * Please have a look into the folder ./examples.
	*
	* You may use this code without any guarantee and only if the following
  	* copyright and text is left untouched:
  	*
    * @author Stephan Niedermeier, LOGABIT NetServices
    * Email: dev@logabit.com
    * Web: http://www.logabit.com/products/dbwrapper/
    * Copyright by: Stephan Niedermeier.
    * @version $Revision$
    * Date: $Date$
  	*
  	* THIS SOFTWARE IS PROVIDED ``AS IS'' AND ANY EXPRESSED OR IMPLIED
  	* WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES
 	* OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
  	* DISCLAIMED.  IN NO EVENT SHALL LOGABIT BE LIABLE FOR ANY DIRECT, 
 	* INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES 
	* (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR 
 	* SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) 
 	* HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, 
	* STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING 
	* IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
	* POSSIBILITY OF SUCH DAMAGE.
**/

class LBLogger {
	
	/** Path to the configfile. Use the constructor
	  * to set this.
	  */
	var $configpath = null;
	
	/** Holds the name of the selected class
	  */
	var $name = null; 
	
	/** The handler array
	  */
	var $handler = null; 
	
	/** The settings array
	  */
	var $settings = null;
	
	/** True if the handle name exists
	  */
	var $handleExists = null; 
	
	/** Set it to true to log the logger ;-)
	  */
	var $verbose = false; 
	
	/** The constructor
	  * @param string name of the hanlder.
	  * @param string path to the configfile. Overrides the default setting.
	  */
	function LBLogger($name, $configpath="") {
		
		if($this->verbose)
			echo "LBLogger:LBLogger name = $name<br>";
		
		if(empty($name)) {
		
			echo "Null or empty name in __FILE__, line __LINE__!";
			return;
		}
		
		if(!empty($configpath))
			$this->configpath = $configpath;
		else
			$this->configpath = dirname(__FILE__)."/configs/main.conf.php";
			
		$this->name = $name;
		$this->initialize();
	}
	
	/** Reads the setted config file and other settings. 
	  */
	function initialize() {
		
		if($this->verbose) 
			echo "LBLogger:initialize configpath = $this->configpath<br>";
		
		include($this->configpath);
		
		if($this->verbose) {
			echo "LBLogger:initialize handler = $__lbl_handler<br>";
			echo "LBLogger:initialize settings = $__lbl_settings<br>";
		}
		
		// Validate the config before use it
		$this->handleExists($__lbl_handler, $this->name);
		$this->validateHandler($__lbl_handler);
		$this->validateSettings($__lbl_settings);
		
		// Use the settings
		$this->handler = $__lbl_handler;
		$this->settings = $__lbl_settings;
	}

	/** Returns the path to the config-file. Note: It is possible to use for each
	  * logged file its own config file. But does it make sense? Its your choice ;-)
	  * @return string The path to the config file.
	  */
	function getConfigPath() {
	
		return $this->configpath;
	}
	
	/** Returns the name of the handle to use. See config file.
	  * @return The name of the handle.
	  */
	function getHandleName() {
	
		return $this->name;
	}
	
	/** Returns true if the handler for the current file is set to "DEBUG".
	  * @return boolean true if the handler is set to "DEBUG".
	  * If this handler is not registered, the default level would be checked.
	  * If no handler of name is given, false would be returned.
	  * If the default level in this case is "DEBUG" true would be returned.
	  */
	function isDebugEnabled() {
		
		return $this->isLevelEnabled("DEBUG");
	}
	
	/** Returns true if the handler for the current file is set to "INFO".
	  * @return boolean true if the handler is set to "INFO".
	  * If this handler is not registered, the default level would be checked.
	  * If no handler of name is given, false would be returned.
	  * If the default level in this case is "INFO" true would be returned.
	  */
	function isInfoEnabled() {
	
		return $this->isLevelEnabled("INFO");
	}
	
	/** Returns true if the handler for the current file is set to "WARN".
	  * @return boolean true if the handler is set to "WARN".
	  * If this handler is not registered, the default level would be checked.
	  * If no handler of name is given, false would be returned.
	  * If the default level in this case is "WARN" true would be returned.
	  */
	function isWarnEnabled() {
		
		return $this->isLevelEnabled("WARN");
	}
	
	/** Returns true if the handler for the current file is set to "ERROR".
	  * @return boolean true if the handler is set to "ERROR".
	  * If this handler is not registered, the default level would be checked.
	  * If no handler of name is given, false would be returned.
	  * If the default level in this case is "ERROR" true would be returned.
	  */
	function isErrorEnabled() {
		
		return $this->isLevelEnabled("ERROR");
	}
	
	/** Returns true if the handler for the current file is set to "FATAL".
	  * @return boolean true if the handler is set to "FATAL".
	  * If this handler is not registered, the default level would be checked.
	  * If no handler of name is given, false would be returned.
	  * If the default level in this case is "FATAL" true would be returned.
	  */
	function isFatalEnabled() {
		
		return $this->isLevelEnabled("FATAL");
	}
	
	/** Returns true if the handler for the current file is set to $level.
	  * Note: The following levels are enabled, too! Example:
	  * WARN = enabled => ERROR and FATAL enabled, too! But DEBUG and INFO
	  * are disabled. The range is: DEBUG->INFO->WARN->ERROR->FATAL.
	  * @return boolean true if the handler is set to $level.
	  * If this handler is not registered, the default level would be checked.
	  * If no handler of name is given, false would be returned.
	  * If the default level in this case is $level true would be returned.
	  */
	function isLevelEnabled($level) {

		// Retrun false, if the handle doesn't exist
		if(! $this->handleExists)
			return false;

		$setted_level = $this->handler[$this->name];
		
		if($setted_level == "DEFAULT")
			$setted_level = $this->settings["default_level"];
			
		$levelord["DEBUG"] = 0;
		$levelord["INFO"] = 1;
		$levelord["WARN"] = 2;
		$levelord["ERROR"] = 3;
		$levelord["FATAL"] = 4;
		
		if($levelord[$level] >= $levelord[$setted_level])
			return true;
		else
			return false;
	}
	
	/** Validates the settings. Checks, whether the array contains possible values.
	 * @param array The setting array to validate.
	 * @return boolean true if the settings are all valid.
	 */
	function validateSettings($settings) {
		
		if($this->verbose)
				echo "LBLogger:validateSettings settings = $settings<br>";
		
		$config = $this->configpath;
		
		// Is a valid level is set?
		$level = $settings["default_level"];

		if($level != "DEBUG" 
			&& $level != "INFO" 
			&& $level != "WARN"
			&& $level != "ERROR"
			&& $level != "FATAL") {
		
			echo "LBLogger: The 'default_level' of settings must be one of 
			DEBUG, INFO, WARN, ERROR or FATAL in '$config'. Not '$level'. Please correct it!";
			return false;
		}
		
		// Validate the email adresses
		$mailsize = sizeof($settings["mail"]);
		
		for($a=0; $a<$mailsize; $a++) {
			$email = $settings["mail"][$a];
			if(! eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$email)) {
				echo "LBLogger: Email '$email' is not valid in '$config'. Please correct it!";
				return false;
			}
		}
		
		$logfilepath = $settings["logfile"]["path"];
		// Check given path for the logfile
		if(!is_dir(dirname($logfilepath))) {
			echo "LBLogger: Path '$logfilepath' for logfile does not exist or is not a dir! Please correct it in '$config'!";
			
			return false;
		}
		
		// Here writeable and readable test has to be implemented
		
		// Check whether the size is a number
		$logfilesize = $settings["logfile"]["maxsize"];
		if(!is_numeric($logfilesize)) {
			echo "LBLogger: Filesize of logfile is not a number: '$logfilesize'. Please correct it in '$config'!";
			return false;
		}
		
		// Check whether settings for "sizereached" are valid.
		$sizereached = $settings["logfile"]["sizereached"];
		if($sizereached != "DELETE") {
		
			if($sizereached != "ROLL") {
				echo "LBLogger: Setting 'sizereached' for logfile must be one of 'DELETE' or 'ROLL'. Please correct it in '$config'!";
				return false;
			}
		}
		
		// Checks whether the appenders are correct setted.
		if(!$this->checkAppender($settings["appender"]["print"], "print"))
			return false;
			
		if(!$this->checkAppender($settings["appender"]["log"], "log"))
			return false;
			
		if(!$this->checkAppender($settings["appender"]["mail"], "mail"))
			return false;
			
		if(!$this->checkAppender($settings["appender"]["exit"], "exit"))
			return false;
			
		// Checks whether the check_enabled value is valid
		if(!is_bool($settings["check_enabled"])) {
		
			echo "LBLogger: The paramter 'check_enabled' may only be true or false. Please correct it in '$config'!";
			return false;
		}
		
		if($this->verbose)
			echo "LBLogger:validateSettings return = true<br>";
		
		return true;
	}
	
	/** Checks the levels of the given appender.
	  * @param array The used levels.
	  * @param string The name of the appender.
	  * @return true if the settings are valid.
	  */
	function checkAppender($levels, $name) {
		
		if($this->verbose)
			echo "LBLogger:checkAppender levels = $levels, name = $name<br>";
		
		$config = $this->configpath;
		$size = sizeof($levels);
		
		if($this->verbose)
			echo "... size = $size<br>";
		
		for($a=0; $a<$size; $a++) {
		
			if($this->verbose)
				echo "... levels $a = $levels[$a]<br>";
				
			$level = $levels[$a];
			
			if($level != "DEBUG" 
				&& $level != "INFO" 
				&& $level != "WARN"
				&& $level != "ERROR"
				&& $level != "FATAL") {
							
				echo "LBLogger: The appender '$name' must be setted to one of 
				DEBUG, INFO, WARN, ERROR, or FATAL in '$config'. Please correct it!";
				return false;
			}
		}
		
		if($this->verbose)
			echo "LBLogger:checkAppender return = true<br>";
		
		return true;
	}
	
	/** Validates the handler. Checks, whether the array contains possible values.
	  * @param array The handler array to validate.
	  * @return boolean true if the handlers are all valid.
	  */
	function validateHandler($handlers) {
		
		if($this->verbose)
			echo "LBLogger:validateHandler handlers = $handlers<br>";
		
		$config = $this->configpath;
		
		// Nothing to do but valid, if handle not exists
		if(! $this->handleExists)
			return true;
		
		$name = $this->name;
		$level = $handlers[$name];
		
		if($level != "DEBUG" 
			&& $level != "INFO" 
			&& $level != "WARN"
			&& $level != "ERROR"
			&& $level != "FATAL"
			&& $level != "DEFAULT") {
				
			echo "LBLogger: The handler '$name' must be setted to one of 
			DEBUG, INFO, WARN, FATAL or DEFAULT in '$config'. Please correct it!";
			return false;
		}
		
		if($this->verbose)
			echo "LBLogger:validateHandler return = true<br>";
		
		return true;
	}
	
	/** Checks whether the given handler exists. The status would be set into
	  * var $this->handleExists.
	  * @return boolean true if the handler with name exists
	  */
	function handleExists($handler, $name) {
		
		if($this->verbose)
			echo "LBLogger:handleExists handler = $handler, name = $name<br>";
		
		if($handler[$name] == null) {
			$this->handleExists = false;
			
			if($this->verbose)
				echo "... LBLogger:handleExists return = false<br>";
			
			return false;
		} else {
			$this->handleExists = true;
			
			if($this->verbose)
				echo "... LBLogger:handleExists return = true<br>";
			
			return true;
		}
	}
	
	/** Checks whether the appender is active for the given level.
	  * @param string name of the appender.
	  * @param string name of the level.
	  * @return boolean true if the handler is active in given level.
	  */
	function isAppenderActive($name, $level) {
		
		if($this->verbose)
			echo "LBLogger:isAppenderActive name = $name, level = $level<br>";
		
		$levels = $this->settings["appender"][$name];
		$size = sizeof($levels);
		
		for($a=0; $a<$size; $a++) {
		
			if($levels[$a] == $level)
				return true;
		}  
		
		return false;
	}
	
	/** Adds a message for level "DEBUG".
	  * If this method should check
	  * automatically wether this level is set,
	  * set $_lbl_settings["check_enabled"] = true
	  * in the confug file.
	  * @param string The text to add.
	  * @param string The filename.
	  * @param string The linenumber.
	  * @return boolean true if the message was added.
	  */
	function debug($text, $file, $line) {
		
		if($this->verbose)
			echo "LBLogger:debug text = $text, file = $file, line = $line<br>";
		
		if($this->settings["check_enabled"]) {
		
			if(!$this->isDebugEnabled()) {
			
				if($this->verbose)
					echo "... LBLogger:debug return = false<br>";
				
				return false;
			}
		}
		
		if($this->isAppenderActive("print", "DEBUG"))
			$this->makePrint("DEBUG", $text, $file, $line);
			
		if($this->isAppenderActive("log", "DEBUG"))
			$this->makeLog("DEBUG", $text, $file, $line);
		
		if($this->isAppenderActive("mail", "DEBUG"))
			$this->makeMail("DEBUG", $text, $file, $line);
		
		if($this->isAppenderActive("exit", "DEBUG"))
			$this->makeExit();
	}
	
	/** Adds a message for level "INFO".
	  * If this method should check
	  * automatically wether this level is set,
	  * set $_lbl_settings["check_enabled"] = true
	  * in the confug file.
	  * @param string The text to add.
	  * @param string The filename.
	  * @param string The linenumber.
	  */
	function info($text, $file, $line) {
		
		if($this->verbose)
			echo "LBLogger:info text = $text, file = $file, line = $line<br>";
		
		if($this->settings["check_enabled"]) {
		
			if(!$this->isInfoEnabled()) {
				
				if($this->verbose)
					echo "... LBLogger:info return = false<br>";
				
				return false;
			}
		}
		
		if($this->isAppenderActive("print", "INFO"))
			$this->makePrint("INFO", $text, $file, $line);
			
		if($this->isAppenderActive("log", "INFO"))
			$this->makeLog("INFO", $text, $file, $line);
		
		if($this->isAppenderActive("mail", "INFO"))
			$this->makeMail("INFO", $text, $file, $line);
		
		if($this->isAppenderActive("exit", "INFO"))
			$this->makeExit();
	}
	
	/** Adds a message for level "WARN".
	  * If this method should check
	  * automatically wether this level is set,
	  * set $_lbl_settings["check_enabled"] = true
	  * in the confug file.
	  * @param string The text to add.
	  * @param string The filename.
	  * @param string The linenumber.
	  */
	function warn($text, $file, $line) {
	
		if($this->verbose)
			echo "LBLogger:warn text = $text, file = $file, line = $line<br>";
	
		if($this->settings["check_enabled"]) {
		
			if(!$this->isWarnEnabled()) {
				
				if($this->verbose)
					echo "... LBLogger:warn return = false<br>";
				
				return false;
			}
		}
		
		if($this->isAppenderActive("print", "WARN"))
			$this->makePrint("WARN", $text, $file, $line);
			
		if($this->isAppenderActive("log", "WARN"))
			$this->makeLog("WARN", $text, $file, $line);
		
		if($this->isAppenderActive("mail", "WARN"))
			$this->makeMail("WARN", $text, $file, $line);
		
		if($this->isAppenderActive("exit", "WARN"))
			$this->makeExit();
	}
	
	/** Adds a message for level "ERROR".
	  * If this method should check
	  * automatically wether this level is set,
	  * set $_lbl_settings["check_enabled"] = true
	  * in the confug file.
	  * @param string The text to add.
	  * @param string The filename.
	  * @param string The linenumber.
	  */
	function error($text, $file, $line) {
	
		if($this->verbose)
			echo "LBLogger:error text = $text, file = $file, line = $line<br>";
	
		if($this->settings["check_enabled"]) {
		
			if(!$this->isErrorEnabled()) {
				
				if($this->verbose)
					echo "... LBLogger:error return = false<br>";
				
				return false;
			}
		}
		
		if($this->isAppenderActive("print", "ERROR"))
			$this->makePrint("ERROR", $text, $file, $line);
			
		if($this->isAppenderActive("log", "ERROR"))
			$this->makeLog("ERROR", $text, $file, $line);
		
		if($this->isAppenderActive("mail", "ERROR"))
			$this->makeMail("ERROR", $text, $file, $line);
		
		if($this->isAppenderActive("exit", "ERROR"))
			$this->makeExit();
	}
	
	/** Adds a message for level "FATAL".
	  * If this method should check
	  * automatically wether this level is set,
	  * set $_lbl_settings["check_enabled"] = true
	  * in the confug file.
	  * @param string The text to add.
	  * @param string The filename.
	  * @param string The linenumber.
	  */
	function fatal($text, $file, $line) {
		
		if($this->verbose)
			echo "LBLogger:fatal text = $text, file = $file, line = $line<br>";
		
		if($this->settings["check_enabled"]) {
		
			if(!$this->isFatalEnabled()) {
			
				if($this->verbose)
					echo "... LBLogger:fatal return = false<br>";
			
				return false;
			}
		}
		
		if($this->isAppenderActive("print", "FATAL"))
			$this->makePrint("FATAL", $text, $file, $line);
			
		if($this->isAppenderActive("log", "FATAL"))
			$this->makeLog("FATAL", $text, $file, $line);
		
		if($this->isAppenderActive("mail", "FATAL"))
			$this->makeMail("FATAL", $text, $file, $line);
		
		if($this->isAppenderActive("exit", "FATAL"))
			$this->makeExit();
	}
	
	/** Prints out the given values.
	  * @param string The level.
	  * @param string The text to print out.
	  * @param string The path of the file.
	  * @param string The linenumber of method call.
	  */
	function makePrint($level, $text, $file, $line) {
		
		if($this->verbose)
			echo "LBLogger:makePrint level = $level, text = $text, file = $file, line = $line<br>";
		
		echo ("<b>$level:</b> $text (File: $file, Line: $line)<br>");
	}
	
	/** Logs the given values int the logfile.
	  * @param string The level.
	  * @param string The text to print out.
	  * @param string The path of the file.
	  * @param string The linenumber of method call.
	  */
	function makeLog($level, $text, $file, $line) {
		
		if($this->verbose)
			echo "LBLogger:makeLog level = $level, text = $text, file = $file, line = $line<br>";
		
		$path = $this->settings["logfile"]["path"];
		
		// Get the date
		$date = date("d.m.Y, H:i:s");
		
		// Generate the log message
		$line = "[".$date."] [".$level."] ".$text." (File: ".$file.", Line: ".$line.") \r\n";
		
		$this->manageLogfile();
		
		// Write the log
		error_log($line, 3 , $path);
	}
	
	/** Send a email with given values to the recipients.
	  * @param string The level.
	  * @param string The text to print out.
	  * @param string The path of the file.
	  * @param string The linenumber of method call.
	  */
	function makeMail($level, $text, $file, $line) {
		
		if($this->verbose)
			echo "LBLogger:debug level = $level, text = $text, file = $file, line = $line<br>";
		
		// Get the date
		$date = date("d.m.Y, H:i:s");
		
		// Generate the message
		$line = "[".$date."] [".$level."] ".$text." (File: ".$file.", Line: ".$line.") \r\n";
		
		// Send the mails
		$size = sizeof($this->settings["mailrecipients"]);
		
		$message = $this->settings["mailmessage"]."\r\n".$line;
		$message = $message."\r\n \r\n---\r\nNOTE: You have received this email, because you are listed in the LBLogger System as recipient. If you wont receive automatic messages in future, remove your email adress from 'main.conf.php'.";
		
		for($a=0; $a<$size; $a++) {
			mail($this->settings["mailrecipients"][$a], "System message: $level", $message, "From: LBLogger");
		}
	}
	
	/** Stops the whole process.
	  */
	function makeExit() {
		
		if($this->verbose)
			echo "LBLogger:makeExit<br>";
		
		exit;
	}
	
	/** Checks whether the logfile should be deleted or roll backed
	  * if the maximum size is reached.
	  */
	function manageLogfile() {
		
		if($this->verbose)
			echo "LBLogger:manageLogfile<br>";
		
		$path = $this->settings["logfile"]["path"];
		$maxsize = $this->settings["logfile"]["maxsize"];
		$sizereached = $this->settings["logfile"]["sizereached"];
		$suffix = $this->settings["logfile"]["suffix"];
		
		if(file_exists($path)) {
			
			$filesize_real = filesize($path)/1000;
			
			if(!$filesize_real) {
		
				echo "LBLogger: An error occures during read the filesize of '$path'! No message logged.
					Check whether the path is valid and read permission is set! Then try again.";
				return;
			}
		}
		
		if($this->verbose) {
				echo "LBLogger:manageLogfile filesize_real = $filesize_real<br>";
				echo "LBLogger:manageLogfile maxsize = $maxsize<br>";
		}
		
		if($filesize_real > $maxsize) {
		
			switch($sizereached){
			
				case "DELETE":
					unlink($path);
					break;
				
				case "ROLL":

					$basename = basename($path);
					
					if($this->verbose) 
						echo "LBLogger:manageLogfile basename = $basename<br>";
					
					$newname = str_replace(".", "_", $basename).$suffix;
					$newname = dirname($path)."/".$newname;
					
					if($this->verbose) 
						echo "LBLogger:manageLogfile newname = $newname<br>";
					
					if(!copy($path, $newname)) {
					
						echo "LBLogger: An error occures during rename the file from '$path' to '$newname'!
							Check whether the path is valid and read permission is set! Then try again.";
						return;
					}
					
					unlink($path);
					
					break;
			}
		}
	}
}

?>