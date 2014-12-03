<?php namespace Generator;

// define('APP', dirname(dirname(dirname(__DIR__))));
define('MODULE_DIR', dirname(__DIR__));

// echo 'APP: ' . APP . "\n"; 
// echo 'MODULE_DIR: ' . MODULE_DIR . "\n"; exit();
include_once(MODULE_DIR . '/GeneratorTracsLUT.php');

$name = 'gradApp';
$table = 'faq_questions';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

// set the main list view data
$cols = array('category_id', 'answer');
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new Model($name, $table, $cols, 'question_id', $params);

// set the detail view data
$fields = array();

$fields[] = new FormFieldModel('question', 'input',
	array('class' => 'form-control', 'id' => 'question-input'));
$fields[] = new FormFieldModel('answer', 'textarea',
	array('class' => 'form-control', 'id' => 'answer-textarea', 'rows' =>'5'));
$fields[] = new FormFieldModel('html', 'input',
	array('class' => 'form-control', 'id' => 'html-input'));

$dropdown = new DropdownFormFieldModel('category_id', 'dropdown', 
	array('class' => 'form-control', 'id' => 'category-dropdown'));
$dropdown->set_table_col('faq_categories', 'category_id', 'name');

// $dropdown = new DropdownFormFieldModel('International', 'dropdown',
// 	array('class' => 'form-control', 'id' => 'International-dropdown'));
// $dropdown->set_enum_array(array('Yes', 'No'));
$fields[] = $dropdown;

$id = 'question_id';
$label_params = array('class' => 'control-label');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'countries-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('question');

$generator = new GeneratorTracsLUT($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => 'GradApp',
			  'PAGE_TITLE' => 'Graudate Application FAQ System',
			  'HEADER' => 'Graudate Application FAQ System'
			  );

$generator->init($data);
$generator->generate();