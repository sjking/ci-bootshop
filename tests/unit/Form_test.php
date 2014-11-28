<?php namespace Generator;

include_once(dirname(dirname(__DIR__)) . '/Template/Form.php');
include_once(dirname(dirname(__DIR__)) . '/Model/FormModel.php');

$name = 'foobar';
$table = 'foobar_table';
$fields = array('id' => 'input',
	 			'name' => 'input',
	 			'status' => 'dropdown'
	 		   );
$id = 'id';

$form_model = new FormModel($name, $table, $fields, $id);

$form = new Form($form_model->get_fields());

$output = $form->generate();

echo "output:\n" . $output . "\n";

?>