<?php namespace Generator;
/* 
 * Ordering Example - Vegetables
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/Generator_ordering.php');

$name = 'vegetable';
$table = 'vegetable';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('name', array('class' => 'col-xs-9'));
$col->set_display_name('Name');
$cols[] = $col;

$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new TableModel($name, $table, $cols, 'id', $params);
$table_model->set_order_column('order');

/* Detail View Data */
$fields = array();

$field = new FormFieldModel('name', 'input',
	array('class' => 'form-control', 'id' => 'name-input'));
$field->set_label_name('Name');
$fields[] = $field;

$id = 'id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'vegetable-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('name');

$generator = new Generator_ordering($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Vegetables',
			  'HEADER' => 'Vegetables',
			  'PORTAL_LINK_NAME' => 'Vegetables',
			  'PORTAL_LINK_DESC' => 'Manage the Vegetable List',
			  'PORTAL_LINK' => '/vegetable'
			  );

$generator->init($data);
$generator->generate();
$generator->output();