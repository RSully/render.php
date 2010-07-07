<?php
$input = dirname(__FILE__) . '/FRO/';
$output = dirname(__FILE__) . '/TO/';
function out($msg, $o = "Debug", $h = '', $r = "\n") { echo "[$o]" . ($h ? "[$h]" : '') . ' ' . $msg . $r; }

function renderFile($f) {
	global $input, $output;
	if(is_string($f) === true)
		$f = pathinfo($input . $f);
	$fp = $input . $f['basename'];
	exec("php '$fp'", $op);
	file_put_contents($output . $f['filename'] . '.html', $op);
}

function renderFileName($fN) {
	global $input;
	$f = pathinfo($input . $fN);
	out($f['basename'], "Rendered", "Rendering", "\r");
	renderFile($args[1]);
	out($f['basename'] . ' as ' . $f['filename'] . '.html', "Rendered");
}

$args = $_SERVER['argv'];

if(isset($args[1]) && file_exists($input . $args[1])) {
	renderFileName($args[1]);
	exit;
}

$dh = opendir($input);
out("Opened directory handle", "Dir");

while( ($file = readdir($dh)) !== false)
{
	if($file{0} == "." || $file{0} == "_") continue;	
	renderFileName($file);
}
closedir($dh);
?>
