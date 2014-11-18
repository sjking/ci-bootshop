<?php namespace Generator;
/* test the creation of basic controller and view */

include_once(dirname(__DIR__) . "/Generator.php");

$conf = new GeneratorConfig('basic_config.ini', __DIR__);
$generator = new Generator('foobar', $conf);
$data = array('CONTROLLER_NAME' => 'Foobar',
			  'PAGE_TITLE' => 'Foobar Portal',
			  'HEADER' => 'Foobar Management');
$generator->init($data);
$generator->generate();

?>