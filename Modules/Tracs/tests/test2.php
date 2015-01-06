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
$cols = array('category_id', 'question');
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new Model($name, $table, $cols, 'question_id', $params);

// set the detail view data
$fields = array();

$fields[] = new FormFieldModel('question', 'input',
	array('class' => 'form-control', 'id' => 'question-input'));
$fields[] = new FormFieldModel('answer', 'textarea',
	array('class' => 'form-control', 'id' => 'answer-textarea', 'rows' =>'5'));
// $radio = new RadioFormFieldModel('html', 'radio',
// 	array('id' => 'html-radio'));
// $radio->set_enum_array(array(false => 'No', true => 'Yes'));
// $fields[] = $radio;

$radio = new RadioFormFieldModel('status', 'radio',
	array('id' => 'status-radio'));
$radio->set_enum_array(array('Active' => 'Active', 'Cancelled' => 'Cancelled'));
$fields[] = $radio;

$dropdown = new DropdownFormFieldModel('category_id', 'dropdown', 
	array('class' => 'form-control', 'id' => 'category-dropdown'));
$dropdown->set_table_col('faq_categories', 'category_id', 'name');
$fields[] = $dropdown;


$id = 'question_id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'countries-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('question');

$generator = new GeneratorTracsLUT($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => 'GradApp',
			  'PAGE_TITLE' => 'Graduate Application FAQ',
			  'HEADER' => 'Graduate Application FAQ'
			  );

$generator->init($data);
$generator->generate();