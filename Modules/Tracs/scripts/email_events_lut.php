<?php namespace Generator;
/* 
 * Sorting Example - Vegetable Fans
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracsLUT_sorting.php');

$name = 'email_event';
$table = 'email_event';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('event_id', array('class' => 'col-lg-2 col-md-2 col-sm-3 col-xs-3'));
$col->set_display_name('Event ID');
$cols[] = $col;
$col = new TableColumn('name', array('class' => 'col-lg-8 col-md-8 col-sm-6 col-xs-6'));
$col->set_display_name('Name');
$cols[] = $col;
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new TableModel($name, $table, $cols, 'event_id', $params);

/* Detail View Data */
$fields = array();

$field = new FormFieldModel('event_id', 'input',
	array('class' => 'form-control', 'id' => 'event_id-input', 'disabled' => 'disabled'));
$field->set_label_name('Event ID');
$fields[] = $field;

$field = new FormFieldModel('name', 'input',
	array('class' => 'form-control', 'id' => 'name-input'));
$field->set_label_name('Name');
$fields[] = $field;

$dropdown = new DropdownFormFieldModel('category', 'dropdown', 
	array('class' => 'form-control', 'id' => 'category-dropdown'));
$dropdown->set_table_col('email_category', 'category', 'category');
$dropdown->set_label_name('Category');
$fields[] = $dropdown;

$checkbox = new CheckboxFormFieldModel('active', 'checkbox', array('id' => 'active-checkbox'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('0');
$checkbox->set_label_name('Active');
$fields[] = $checkbox;

$radio = new RadioFormFieldModel('status', 'radio', array('id' => 'status-radio'));
$status = array(
				'Active' => 'Active',
				'Delete' => 'Delete'
				);
$radio->set_enum_array($status);
$radio->set_label_name('Status');
$fields[] = $radio;

$field = new FormFieldModel('description', 'textarea',
	array('class' => 'form-control', 'id' => 'description-textarea', 'rows' =>'5'));
$field->set_label_name('Description');
$fields[] = $field;

$id = 'event_id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'email_event-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('name'); // table column used for title of page

$generator = new GeneratorTracsLUT_sorting($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Email Events Management',
			  'HEADER' => 'Email Events',
			  'PORTAL_LINK_NAME' => 'Email Events',
			  'PORTAL_LINK_DESC' => 'Manage Email Events',
			  'PORTAL_LINK' => '/tracs/lut/email_event'
			  );

$generator->init($data);
$generator->generate();
$generator->output();