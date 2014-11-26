<?php namespace Generator;

include_once('GeneratorTracsLUT.php');

$name = 'countries';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', __DIR__);

$cols = array('Iso', 'PrintableName', 'Continent');
$model = new Model($name, $name . '_lut', $cols, 'Iso');

$generator = new GeneratorTracsLUT('countries', $conf, $model);

$data = $data = array('CONTROLLER_NAME' => 'Countries',
			  'PAGE_TITLE' => 'Countries Management',
			  'HEADER' => 'Countries Management');

$generator->init($data);
$generator->generate();