<?
/** A small but powerfull class to generating dynamic websites.
  * =============================================================================
  * The greatest advantage of this class is its very, very simple syntax.
  * Evereyone - who has worked about 5 hours at all with php - learns really fast
  * to use LBTemplate, really! Try itself!
  *
  * Some features of LBTemplate:
  * - strict OOP
  * - caching
  * - easy to use
  * - very fast
  *
  * @author LOGABIT NetServices, Stephan Niedermeier, s.niedermeier@logabit.com
  * @version $Revision$, $Date$
  *
  * This library is free software; you can redistribute it and/or
  * modify it under the terms of the GNU Lesser General Public
  * License as published by the Free Software Foundation; either
  * version 2.1 of the License, or (at your option) any later version.
  *
  * This library is distributed in the hope that it will be useful,
  * but WITHOUT ANY WARRANTY; without even the implied warranty of
  * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
  * Lesser General Public License for more details.
  *
  * You should have received a copy of the GNU Lesser General Public
  * License along with this library; if not, write to the Free Software
  * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  *
  *	Shortest example:
  * =============================================================================
  * 1. Copy the whole folder lbtemplate into your DOCUMENT_ROOT.
  * 2. Set the explicite path to the dir in which the templates reside.
  *    (Or use the function setTemplatePath("<path_to_template_folder>")).
  *	   If you wont set this path, you have to set the path at instanciation
  *    time of the class: new LBTemplate("<path_to_template>");
  * 3. Create a mainfile named by index.php and store it into 
  *    the folder 'examples'. The file should contain the following lines:
  *
  *    include("lbtemplate.class.php");
  *    $myxmpl = new LBTemplate("index.tpl.html");
  *    $myxmpl->replace("HEADER", "This is an example!");
  *    $myxmpl->add("TEXT", "Hello ");
  *    $myxmpl->add("TEXT", "World!");
  *    $myxmpl->show();
  *
  * 4. Create a template named index.tpl.html nd store it in the 
  *    templatepath like the following:
  *
  *    <HTML>
  *    <TITLE>{%HEADER%}</TITLE>
  *    <BODY>
  *    {%TEXT%}
  *    </BODY>
  *    </HTML>
  *
  * 5. Then, call: http://<YOUR_SERVER>/lbtemplate/examples/index.php
  * =============================================================================
  */

class LBTemplate {
	
	var $TEMPLATEPATH; // Configuration see above...
	var $cachefile; // Filename of the cached file.
	var $content; // This array holds all variables from the template.
	var $templatefile; // The filename of the template;
	var $template_parsed; // The string with the parsed template;
	
	var $logger;
	
	function LBTemplate($templatefile) {
		
		// CONFIGURATION //
		// Path in which the templates reside.
		// This path can be absolute like /usr/local/httpd/htdocs... or
		// relative like ./templates... Note: The root of relative mounting
		// is the calling script not this class!
		$this->TEMPLATEPATH = PATH_TO_TEMPLATEDIR;
		// DO NOT CHANGE ANYTHING PASS THIS LINE ! //
		
		include_once(dirname(__FILE__)."/lblogger.class.php");
		$this->logger = new LBLogger("lbtemplate.class.php");
		
		$this->templatefile = $templatefile;
	}
	
	/** Set the path to the templates new.
	  * @param string Path in which the templates reside.
	  * @return boolean true if and only if the path was successfully setted.
	  */
	function setTemplatePath($path) {
		$this->logger->debug("LBTemplate.setTemplatePath($path)", __FILE__, __LINE__);
		
		if(empty($path)) {
			echo "Null or empty path! <br>\n";
			return false;
		}
		
		$this->TEMPLATEPATH = $path;
		return true;
	}
	
	/* Set whether the generated templated should be cached or not.
	 * @param string $filename Filename of the cached file.
	 */
	function setCache($filename) {
		$this->logger->debug("LBTemplate.setCache($filename)", __FILE__, __LINE__);
		
		$this->cachefile = $this->trimCacheFilename($filename);
		return true;
	}
	
	/** Returns true if the file is already cached and exists.
	  * @return true if the file is already cached and exists.
	  */
	function isCached($filename) {
		$this->logger->debug("LBTemplate.isCached($filename)", __FILE__, __LINE__);
		
		if(empty($filename)) {
			echo "Null or empty filename! <br>\n";
			return false;
		}
		
		$filename = $this->trimCacheFilename($filename);
		
		if(file_exists($filename))
			return true;
		else
			return false;
	}
	
	/** If a cachefile is given, this file would be returned otherwise parse() would be called.
	  * @param string The parsed template as big string.
	  */
	function cache() {
		$this->logger->debug("LBTemplate.cache()", __FILE__, __LINE__);
		
		$filename = $this->cachefile;
		
		if(! empty($filename)) {

			if(! file_exists($filename)) {
				$content = $this->parse();
				$this->stringToFile($content, $filename);
				return $content;
			}
			else
				return $this->fileToString($filename);
		}
		
		return $this->parse();
		
	}
	
	/* An alias of cache("")
	 */
	function noCaching($filename) {
		$this->logger->debug("LBTemplate.noCashing()", __FILE__, __LINE__);
		
		$this->cache = "";
		return true;
	}
	
	/* Removes the cached file.
	 * @param name of the cached file.
	 * @return true if the file was successfully removed.
	 */
	function removeCachedFile($filename = "") {
		$this->logger->debug("LBTemplate.removeCachedFile($filename)", __FILE__, __LINE__);
		
		if($filename == "")
			$filename = $this->cachefile;
		else
			$filename = $this->trimCacheFile($filename);
		
		if(! file_exists($filename)) {
			echo "Cached file $filename doesn't exist!";
			return false;
		}
		
		if(! unlink($filename)) {
			echo "Couldn't delete cached file $filename!";
			return false;
		}

		return true;
		
	}
	
	/** Prints out the given file if it was cached.
	  * @param string Name of the cached file to print out.
	  * @return true if and only if the file exists.
	  */
	function printCachedFile($filename) {
		$this->logger->debug("LBTemplate.printCachedFile($filename)", __FILE__, __LINE__);
		
		if(empty($filename)) {
			echo "Null or empty filename! <br>\n";
			return false;
		}
		
		$filename = $this->trimCacheFilename($filename);
		
		if(file_exists($filename)) {
			echo $this->fileToString($filename);
			return true;
		}
		else
			return false;
		
	}
	
	/** Returns the given file if it was cached.
	  * @param string Name of the cached file to print out.
	  * @return true if and only if the file exists.
	  */
	function getCachedFile($filename) {
		$this->logger->debug("LBTemplate.getCachedFile($filename)", __FILE__, __LINE__);
		
		if(empty($filename)) {
			echo "Null or empty filename! <br>\n";
			return false;
		}
		
		$filename = $this->trimCacheFilename($filename);
		
		if(file_exists($filename))
			return $this->fileToString($filename);
		else
			return false;
		
	}
	
	/* Replaces the content of the varname in array content with content.
	 * @param string $varname Name of the placeholder.
	 * @param string or object For replacing the content in the array.
	 */
	function replace($varname, $content) {
		$this->logger->debug("LBTemplate.replace($varname, $content)", __FILE__, __LINE__);
		
		if(empty($varname)) {
			echo "Null or empty varname!";
			return false;
		}
		
		if (!preg_match("/^[a-zA-Z0-9_]+$/", $varname)) {
			echo "Only the characters A-Z, a-z, 0-9 and _ are allowed in varname! (Varname: $varname)<br>\n";
			return false;
		}

		if(get_class($content) == "lbtemplate")
			$content = $content->toString();
		
		$this->content["$varname"] = "".$content;
		return true;
	}
	
	/** Adds the content of param $content on the specified place in the array content.
	 * @param string $varname Name of the placeholder.
	 * @param string or object For adding $content to the content of the array content.
	 */
	function add($varname, $content) {
		$this->logger->debug("LBTemplate.add($varname, $content)", __FILE__, __LINE__);
		
		if(empty($varname)) {
			echo "Null or empty varname!";
			return false;
		}
		
		if (!preg_match("/^[a-zA-Z0-9_]+$/", $varname)) {
			echo "Only the characters A-Z, a-z, 0-9 and _ are allowed in varname! (Varname: $varname)<br>\n";
			return false;
		}
		
		if(get_class($content) == "lbtemplate")
			$content = $content->toString();
		
		if (isset($this->content["$varname"])) {
      $this->content["$varname"] .= "".$content;
    }else{
      $this->content["$varname"] = "".$content;
    }
		return true;
	}
	
	/** Initializes the specified position in the array content.
	  * @param string $varname.
	  */
	function clearVar($varname) {
		$this->logger->debug("LBTemplate.clearVar($varname)", __FILE__, __LINE__);
		
		if(empty($varname)) {
			echo "Null or empty varname!";
			return false;
		}
		
		$this->content["$varname"] = "";
		return true;
	}
	
	/** Initializes the whole array content.
	  */
	function clearAll() {
		$this->logger->debug("LBTemplate.clearAll()", __FILE__, __LINE__);

		unset($this->content);

		return true;
	}
	
	/** Replaces all placeholders with the according pieces of the array content.
	  */
	function parse() {
		$this->logger->debug("LBTemplate.parse()", __FILE__, __LINE__);
			
		if(! file_exists($this->TEMPLATEPATH."/".$this->templatefile)) {
			echo "Template doesn't exist: ".$this->TEMPLATEPATH."/".$this->templatefile."<br>\n";
			return false;
		}
		
		// Get the whole template in one big string
		$template = $this->fileToString($this->TEMPLATEPATH."/".$this->templatefile);
		
		if(!empty($this->content))
			$array_keys = array_keys($this->content);
		
		for($a=0; $a<sizeof($this->content); $a++) {
			$array_key = $array_keys[$a];
			$varkey = "|"."<!--".$array_key."-->"."|";
        	$template = preg_replace($varkey, $this->content[$array_key], $template);
		}
		
		return $template;
	}
	
	/** Displays the parsed template.
	  * If $cahcefile is set, the cached file would be displayed if exists. 
	  * @return boolean True if the parsed template was successfully printed out.
	  */
	function show() {
		$this->logger->debug("LBTemplate.show()", __FILE__, __LINE__);
		
		echo $this->cache();
		return true;
	}
	
	/** Returns the whole, parsed template.
	  * @return string The parsed template in one big string.
	  */
	function toString() {
		$this->logger->debug("LBTemplate.toString()", __FILE__, __LINE__);
		
		return $this->cache();
	}
	
	/** Converts the given file in one big string.
	  * @param string $filename Path to the file to convert.
	  * @return string The content of the file in one big string.
	  */
	function fileToString($filename) {
		$this->logger->debug("LBTemplate.fileToString($filename)", __FILE__, __LINE__);
			
		if(! $template = implode("",(file($filename)))) {
			echo "Error while reading Template: ".$this->TEMPLATEPATH."/".$this->templatefile."<br>\n";
		}
		return $template;
	}
	
	/** Writes the given string in the given file overwriting a file with the same name.
	  * @param string $text Text to write in the file.
	  * @param string $filename Name of the file to create.
	  */
	function stringToFile($text, $filename) {
		$this->logger->debug("LBTemplate.stringToFile(<xmp>$text</xmp>, $filename)", __FILE__, __LINE__);
		
		if(! $file = fopen($filename, "w")) {
			echo "Error while creating file $filename! Please set write rights to $directory.<br>\n";
			return false;
		}
		
		if(! fwrite($file, $text)) {
			echo "Error while writing in file $filename!<br>\n";
			return false;
		}
		
		if(! fclose($file)) {
			echo "Error while closing file $filename!<br>\n";
			return false;
		}	
	}
	
	/** Removes path-slashes and suffixes and adds the suffix .html.
	  * @param string Name of the file to trim.
	  * @return string The trimmed filename.
	  */
	function trimCacheFilename($filename) {
		$this->logger->debug("LBTemplate.trimCacheFilename($filename)", __FILE__, __LINE__);
			
		$filename = basename($filename);
		$pointnum = strpos($filename, ".");
		
		if(! $pointnum)
			$pointnum = strlen($filename);
		
		$filename = substr($filename, 0, $pointnum);
		return $filename.".html";
	}

}

?>