<?php namespace Generator;

include_once(dirname(dirname(__DIR__)) . '/Template/TracsForm.php');
include_once(dirname(dirname(__DIR__)) . '/Model/FormModel.php');

$name = 'foobar';
$table = 'foobar_table';
$expected = file_get_contents('Form_test.out');

$fields = array();
$fields[] = new FormFieldModel('id', 'input', 
	array('class' => 'form-control', 'id' => 'id-input'));
$fields[] = new FormFieldModel('name', 'input', 
	array('class' => 'form-control', 'id' => 'name-input'));
$fields[] = new FormFieldModel('status', 'dropdown',
	array('class' => 'form-control', 'id' => 'status-select'));
$label_params = array('class' => 'control-label');
$button_params = array('class' => 'btn btn-primary');

$id = 'id';

$params = array('id' => 'foobar-form', 'class' => 'form-horizontal', 'method' => 'post');

$form_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);

$form = new Form($form_model);




// $output = $form->generate();

// echo "output:\n" . $output . "\n";
// echo $output;
// echo "Form Test:\n";
// if ($output != $expected) {
// 	echo "\t" . '[Error]: Expected output does not match actual output.' . "\n";
// }
// else {
// 	echo "\t" . "OK.\n";
// }

?>