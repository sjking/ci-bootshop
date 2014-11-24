<?php namespace Generator;
/* test the creation of basic controller and view */

include_once(dirname(__DIR__) . "/Generator.php");
include_once(dirname(__DIR__) . "/Model/Model.php");

$conf = new GeneratorConfig('basic_config.ini', __DIR__);

$cols = array('id', 'name', 'title', 'status');
$model = new Model('foobar', 'foobar_lut', $cols, 'id');

$generator = new Generator('foobar', $conf, $model);

$data = array('CONTROLLER_NAME' => 'Foobar',
			  'PAGE_TITLE' => 'Foobar Portal',
			  'HEADER' => 'Foobar Management');

$generator->init($data);
$generator->generate();

?>