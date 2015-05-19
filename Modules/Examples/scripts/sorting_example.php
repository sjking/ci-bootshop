<?php namespace Generator;
/* 
 * Sorting Example - Vegetable Fans
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/Generator_sorting.php');

$name = 'vegetable_fans';
$table = 'vegetable_fans';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('name', array('class' => 'col-lg-2 col-md-2 col-sm-3 col-xs-3'));
$col->set_display_name('Name');
$cols[] = $col;
$col = new TableColumn('occupation', array('class' => 'col-lg-8 col-md-8 col-sm-6 col-xs-6'));
$col->set_display_name('Occupation');
$cols[] = $col;
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new TableModel($name, $table, $cols, 'id', $params);

/* Detail View Data */
$fields = array();

$field = new FormFieldModel('name', 'input',
	array('class' => 'form-control', 'id' => 'name-input'));
$field->set_label_name('Name');
$fields[] = $field;

$field = new FormFieldModel('occupation', 'input',
	array('class' => 'form-control', 'id' => 'occupation-input'));
$field->set_label_name('Occupation');
$fields[] = $field;

$dropdown = new DropdownFormFieldModel('vegetable_id', 'dropdown', 
	array('class' => 'form-control', 'id' => 'vegetable-dropdown'));
$dropdown->set_table_col('vegetable', 'id', 'name');
$dropdown->set_label_name('Favorite Vegetable');
$fields[] = $dropdown;

$checkbox = new CheckboxFormFieldModel('vegetarian', 'checkbox', array('id' => 'vegetarian-checkbox'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('2');
$checkbox->set_label_name('Vegetarian');
$fields[] = $checkbox;

$radio = new RadioFormFieldModel('vegetable_status', 'radio', array('id' => 'vegetable_status-radio'));
$status = array(
				'Fresh' => 'Fresh',
				'Frozen' => 'Frozen',
				'Canned' => 'Canned',
				'Freeze Dried' => 'Freeze Dried'
				);
$radio->set_enum_array($status);
$radio->set_label_name('Vegetable Status');
$fields[] = $radio;

$field = new FormFieldModel('notes', 'textarea',
	array('class' => 'form-control', 'id' => 'Notes-textarea', 'rows' =>'3'));
$field->set_label_name('Notes');
$fields[] = $field;

$id = 'id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'vegetable_fans-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('name'); // table column used for title of page

$generator = new Generator_sorting($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Vegetable Fans',
			  'HEADER' => 'Vegetable Fans',
			  'PORTAL_LINK_NAME' => 'Vegetable Fans',
			  'PORTAL_LINK_DESC' => 'Manage the vegetable fans',
			  'PORTAL_LINK' => '/vegetable_fans'
			  );

$generator->init($data);
$generator->generate();
$generator->output();