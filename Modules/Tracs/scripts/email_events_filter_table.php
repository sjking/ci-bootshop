<?php namespace Generator;
/* 
 * Sorting Example - Vegetable Fans
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracs_filter_table.php');

$name = 'email_events'; // the name of the controller
$table = 'email_event'; // the database table name
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('filter_table_config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('event_id', array('class' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2'));
$col->set_display_name('Event ID');
$cols[] = $col;
$col = new TableColumn('name', array('class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Name');
$cols[] = $col;
$col = new TableColumn('category_id', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('Category');
$cols[] = $col;
$col = new TableColumn('description', array('class' => 'col-lg-4 col-md-4 col-sm-4 col-xs-4'));
$col->set_display_name('Description');
$cols[] = $col;
$col = new TableColumn('enable', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('Status');
$cols[] = $col;

$params = array('id' => $name . '-table', 
				'class' => 'list table table-bordered');
$table_model = new TableModel($name, $table, $cols, 'event_id', $params);

/* Filter form Data */
$fields = array();

$field = new FormFieldModel('event_id', 'input',
	array('class' => 'form-control', 'id' => 'event_id-input'));
$field->set_label_name('Event ID');
$fields[] = $field;

$field = new FormFieldModel('name', 'input',
	array('class' => 'form-control', 'id' => 'name-input'));
$field->set_label_name('Name');
$fields[] = $field;

$dropdown = new DropdownFormFieldModel('category_id', 'dropdown', 
	array('class' => 'form-control', 'id' => 'category_id-dropdown'));
$dropdown->set_table_col('email_category', 'category_id', 'category');
$dropdown->set_label_name('Category');
$fields[] = $dropdown;

$checkbox = new CheckboxFormFieldModel('enable', 'checkbox', array('id' => 'enable-checkbox', 'checked' => 'checked'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('0');
$checkbox->set_label_name('Enabled');
$fields[] = $checkbox;

$results_per_page_choices = array('10' => '10',
										  '20' => '20',
										  '50' => '50',
										  '100' => '100',
										  '200' => '200',
										  'all' => 'all');
$dropdown = new DropdownFormFieldModel('results_per_page', 'dropdown', 
	array('class' => 'form-control', 'id' => 'results_per_page-dropdown'));
$dropdown->set_enum_array($results_per_page_choices);
$dropdown->set_label_name('Results Per Page');
$dropdown->set_default_value('20');
$fields[] = $dropdown;

$id = 'event_id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-default');
$params = array('id' => $name. '-form', 'class' => 'form-horizontal filter-table-form img-rounded', 'method' => 'post');

$filter_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$filter_model->set_col_header('name'); // table column used for title of page (OR NOT!)

$generator = new GeneratorTracs_filter_table($name, $conf, $table_model, $filter_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Email Event Management',
			  'HEADER' => 'Email Events',
			  'PORTAL_LINK' => '/tracs/admin/email_event'
			  );

$generator->init($data);
$generator->generate();
$generator->output();
