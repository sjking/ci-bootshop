<?php namespace Generator;
/* 
 * Email templates management master view
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracs_filter_table_striped.php');

$name = 'email_templates';
$table = 'email_template';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('filter_table_config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('template_id', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('ID');
$cols[] = $col;
$col = new TableColumn('Name', array('class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Name');
$cols[] = $col;
$col = new TableColumn('TemplateDescription', array('class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Description');
$cols[] = $col;
$col = new TableColumn('Category_ID', array('class' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2'));
$col->set_display_name('Category');
$cols[] = $col;
$col = new TableColumn('Status', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('Status');
$cols[] = $col;
$col = new TableColumn('', array('class' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2'));
$col->set_display_name('');
$cols[] = $col;
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover filter-table');
$table_model = new TableModel($name, $table, $cols, 'template_id', $params);

/* Filter form Data */
$fields = array();

$field = new FormFieldModel('Name', 'input',
	array('class' => 'form-control', 'id' => 'Name-input'));
$field->set_label_name('Template Name');
$fields[] = $field;

$dropdown = new DropdownFormFieldModel('Category_ID', 'dropdown', 
	array('class' => 'form-control', 'id' => 'category-dropdown'));
$dropdown->set_table_col('email_category', 'category_id', 'category');
$dropdown->set_label_name('Email Category');
$fields[] = $dropdown;

$radio = new RadioFormFieldModel('Status', 'radio', array('id' => 'Status-radio'));
$status = array(
				'Active' => 'Active',
				'Cancelled' => 'Cancelled',
				);
$radio->set_enum_array($status);
$radio->set_label_name('Status');
$fields[] = $radio;

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

$id = 'template_id';
$label_params = array('class' => 'control-label');
$button_params = array('class' => 'btn btn-default');
$params = array('id' => $name. '-form', 'class' => 'form-inline filter-table-form', 'method' => 'post');

$filter_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$filter_model->set_col_header('Name'); // table column used for title of page (OR NOT!)

$generator = new GeneratorTracs_filter_table_striped($name, $conf, $table_model, $filter_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Email Templates Management',
			  'HEADER' => 'Email Templates Management',
			  'PORTAL_LINK' => '/tracs/admin/email_templates'
			  );

$generator->init($data);
$generator->generate();
$generator->output();
