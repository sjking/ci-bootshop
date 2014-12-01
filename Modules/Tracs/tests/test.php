<?php namespace Generator;

// define('APP', dirname(dirname(dirname(__DIR__))));
define('MODULE_DIR', dirname(__DIR__));

// echo 'APP: ' . APP . "\n"; 
// echo 'MODULE_DIR: ' . MODULE_DIR . "\n"; exit();
include_once(MODULE_DIR . '/GeneratorTracsLUT.php');

$name = 'countries';
$table = 'countries_lut';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

// set the main list view data
$cols = array('Iso', 'PrintableName', 'Continent');
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new Model($name, $table, $cols, 'Iso', $params);

// set the detail view data
$fields = array();
$fields[] = new FormFieldModel('Iso', 'input', 
	array('class' => 'form-control', 'id' => 'Iso-input'));
$fields[] = new FormFieldModel('PrintableName', 'input',
	array('class' => 'form-control', 'id' => 'PrintableName-input'));
$fields[] = new FormFieldModel('Iso3', 'input',
	array('class' => 'form-control', 'id' => 'Iso3-input'));
$fields[] = new FormFieldModel('NumCode', 'input',
	array('class' => 'form-control', 'id' => 'NumCode-input'));
$fields[] = new FormFieldModel('Continent', 'input',
	array('class' => 'form-control', 'id' => 'Continent-input'));
$fields[] = new FormFieldModel('International', 'input',
	array('class' => 'form-control', 'id' => 'International-input'));

$id = 'Iso';
$label_params = array('class' => 'control-label');
$params = array('id' => 'countries-form', 'class' => 'form-horizontal');

$detail_model = new FormModel($name . '_detail', $table, $fields, $id, $params, $label_params);

$generator = new GeneratorTracsLUT($name, $conf, $table_model, $detail_model);

$data = $data = array('CONTROLLER_NAME' => 'Countries',
			  'PAGE_TITLE' => 'Countries Management',
			  'HEADER' => 'Countries Management');

$generator->init($data);
$generator->generate();