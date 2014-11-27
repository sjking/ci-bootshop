<?php namespace Generator;

include_once('GeneratorTracsLUT.php');

$name = 'countries';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', __DIR__);

$cols = array('Iso', 'PrintableName', 'Continent');
$table_model = new Model($name, $name . '_lut', $cols, 'Iso');

$fields = array('Iso' => 'input',
	 			'PrintableName' => 'input',
	 			'Iso3' => 'input',
	 			'NumCode' => 'input',
	 			'Continent' => 'input',
	 			'International' => 'input'
	 		   );

$detail_model = new FormModel($name . '_detail', $name . '_lut', $fields, 'Iso');

$generator = new GeneratorTracsLUT('countries', $conf, $table_model, 
								   $detail_model);

$data = $data = array('CONTROLLER_NAME' => 'Countries',
			  'PAGE_TITLE' => 'Countries Management',
			  'HEADER' => 'Countries Management');

$generator->init($data);
$generator->generate();