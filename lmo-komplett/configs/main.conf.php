<?

// Which level should be the default one?
// This is used for definitions with entry of "DEFAULT" 
// or no definition.
// Possible values are:
// "DEBUG", "INFO", "WARN", "ERROR", "FATAL";
$__lbl_settings["default_level"] = "WARN";


// Here you can register all possible recipients of an email
// from the LBLogger:
$__lbl_settings["mail"][0] = "mail@domain.de";

// Here you can add a short message, which would be added to each
// email.
$__lbl_settings["mailmessage"] = "Please note the following information: ";

// Specify the path and name for the logfile.
// Note: The scpecified folder must be readable and writeable!
$__lbl_settings["logfile"]["path"] = PATH_TO_LMO."/debuglog.txt";

// Maximum size of the logfile in KB. If this size is reached
// the action defined as follows would be used...
$__lbl_settings["logfile"]["maxsize"] = 1000;

// What to do with logfile which has reached the maximum size?
// Possible values are:
// "DELETE" = Deletes the old log and creates a new one.
// "ROLL" = Renames the old log to oldname + suffix.
$__lbl_settings["logfile"]["sizereached"] = "ROLL";

// Which string should be appended at the end of the logfile
// after it was "rolled"?
$__lbl_settings["logfile"]["suffix"] = "_".date("Y-m-d_H-i-s").".txt";

// Here you can specify which appender should be used in which level:
$__lbl_settings["appender"]["print"] = array("DEBUG", "INFO", "WARN", "ERROR", "FATAL");
$__lbl_settings["appender"]["log"] = array("DEBUG", "INFO", "WARN", "ERROR", "FATAL");
$__lbl_settings["appender"]["mail"] = array("FATAL");
$__lbl_settings["appender"]["exit"] = array("FATAL");

// If this is set to true, each call of debug(), info(), warn(),
// error(), fatal() would check, wheter this is enabled. Otherwise
// this is set to false, you have to check this for yourself
// with the correspondig is<level>Enabled()-Method.
$__lbl_settings["check_enabled"] = true;

// Here you can register your classes/files for use.
// Example:
// $__lbl_handle["myclass.php"] = "DEBUG";
// Possible values are:
// "DEFAULT", "DEBUG", "INFO", "WARN", "ERROR", "FATAL"
$__lbl_handler["lbtemplate.class.php"] = "DEFAULT";

?>