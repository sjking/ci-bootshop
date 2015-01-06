<?php namespace Generator;

// define('APP', dirname(dirname(dirname(__DIR__))));
define('MODULE_DIR', dirname(__DIR__));

// echo 'APP: ' . APP . "\n"; 
// echo 'MODULE_DIR: ' . MODULE_DIR . "\n"; exit();
include_once(MODULE_DIR . '/GeneratorTracsLUT.php');

$name = 'gradAppCategories';
$table = 'faq_categories';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

// set the main list view data
$cols = array('category_id', 'name');
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new Model($name, $table, $cols, 'category_id', $params);

// set the detail view data
$fields = array();

$fields[] = new FormFieldModel('name', 'input',
	array('class' => 'form-control', 'id' => 'question-input'));


$id = 'category_id';
$label_params = array('class' => 'control-label');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'category-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('name');

$generator = new GeneratorTracsLUT($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Graduate Application FAQ Categories',
			  'HEADER' => 'Graduate Application FAQ Categories'
			  );

$generator->init($data);
$generator->generate();