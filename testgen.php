<?php namespace Generator;

include_once(__DIR__ . "/Generator.php");

echo 'Generator Test:';
echo "\n";

$generator = new Generator('foobar');
$controller_data = array("CONTROLLER_TEMPLATE_NAME" => 'foobar');
// $generator->set_controller_data($controller_data);
$generator->generate();

// echo 'APP: ' . APP;
// echo "\n";

?>