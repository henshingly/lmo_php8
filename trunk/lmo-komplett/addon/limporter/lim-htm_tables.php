<?
include("htmlparser/common.inc");
include("htmlparser/htmlparser.inc");
/*
if( isset($HTTP_POST_VARS)) {
  	reset ($HTTP_POST_VARS);
  	foreach ($HTTP_POST_VARS as $k=>$elem) {
		echo "\n<BR>$k =".$elem;
	}
}
*/
$tCount = 0;
$countBool = 0;
$inTable = 0;
$tCount=0;
$parseBegin="LIMPORTER-PARSE_BEGIN";
$parseEnd="LIMPORTER-PARSE_END";

//$tables = array();
$p=new HtmlParser($file,unserialize(Read_File("htmlgrammar.cmp")),"",1);
$p->Parse();
$src="";
tablePointer(&$p->content);
//markTable(&$p->content);
GetPageSrcWithButton(&$p->content,&$src);

if (isset($impTable)) {
	$srcArray=split($parseBegin,$src);
	$mysrc = $srcArray[1];
	$srcArray=split($parseEnd,$srcArray[1]);
	$mysrc = $srcArray[0];
	echo "<BR>\nFolgende Tabelleninhalte werden importiert:<BR>\n";
	print $mysrc;
}
else print $src;
?>