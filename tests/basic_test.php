<?php namespace Generator;
/* test the creation of basic controller and view */

include_once(dirname(__DIR__) . "/Modules/Basic/GeneratorBasic.php");

$name = 'foobar';
const BASE_URL = 'codeigniter.busdevw';

$expected = file_get_contents('expect.out');

$conf = new GeneratorConfig('basic_config.ini', __DIR__);

$cols = array('id', 'name', 'title', 'status');
$model = new Model($name, $name . '_lut', $cols, 'id');

$generator = new GeneratorBasic('foobar', $conf, $model);

$data = array('CONTROLLER_NAME' => 'Foobar',
			  'PAGE_TITLE' => 'Foobar Portal',
			  'HEADER' => 'Foobar Management');

$generator->init($data);
$generator->generate();

// use curl to get the page
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, BASE_URL . '/' . $name);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$resp = curl_exec($curl);

// test for expected output
$str = preg_replace('/\s+/', '', $resp);
echo 'Basic Test: Positive Test' . "\n";
if ($str != $expected) {
	echo "\t" . '[Error]: Expected output does not match actual output.' . "\n";
}
else {
	echo "\t" . "OK.\n";
}

// delete the generated pages, test for 404
$generator->destroy();
$resp = curl_exec($curl);
echo 'Basic Test: Negative Test' . "\n";
if (strpos($resp, '404') === false) {
	echo "\t" . '[Error]: Page does not contain 404.' . "\n";
}
else {
	echo "\t" . "OK.\n";
}

curl_close($curl);

?>