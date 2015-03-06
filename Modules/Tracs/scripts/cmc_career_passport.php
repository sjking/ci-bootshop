<?php namespace Generator;
/* 
 * CMC Career Passport - career_passport
 *
 * All data should be filtered on ACAD_CAREER = 'UGRD'
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracs_filter_table.php');

$name = 'career_passport';
$table = 'sims_acad_records';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('filter_table_config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('EMPLID', array('class' => 'col-lg-4 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Name');
$cols[] = $col;
$col = new TableColumn('UNITS', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('Units');
$cols[] = $col;
$col = new TableColumn('CGPA', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('CGPA');
$cols[] = $col;

// workshop columns
$col = new TableColumn('BCP_INT', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('INT');
$cols[] = $col;
$col = new TableColumn('BCP_JSS', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('JSS');
$cols[] = $col;
$col = new TableColumn('BCP_RES', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('RES');
$cols[] = $col;
$col = new TableColumn('BCP_CL', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('CL');
$cols[] = $col;
$col = new TableColumn('BCP_SA', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('SA');
$cols[] = $col;
$col = new TableColumn('BCP_NBE', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('NBE');
$cols[] = $col;


$params = array('id' => $name . '-table', 
				'class' => 'list table table-bordered');
$table_model = new TableModel($name, $table, $cols, 'EMPLID', $params);

/* Filter form Data */
$fields = array();

$field = new FormFieldModel('UNITS', 'input',
	array('class' => 'form-control', 'id' => 'UNITS-input'));
$field->set_label_name('Units Completed');
$fields[] = $field;

// workshops
$checkbox = new CheckboxFormFieldModel('BCP_INT', 'checkbox', array('id' => 'BCP_INT-checkbox'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('0');
$checkbox->set_label_name('Interview Preparation & Tactics');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('BCP_JSS', 'checkbox', array('id' => 'BCP_JSS-checkbox'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('0');
$checkbox->set_label_name('Job Search Strategies & Career Management');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('BCP_RES', 'checkbox', array('id' => 'BCP_RES-checkbox'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('0');
$checkbox->set_label_name('RES');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('BCP_CL', 'checkbox', array('id' => 'BCP_CL-checkbox'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('0');
$checkbox->set_label_name('Competitive Cover Letters');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('BCP_SA', 'checkbox', array('id' => 'BCP_SA-checkbox'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('0');
$checkbox->set_label_name('Self Assessment & Finding Your Fit');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('BCP_NBE', 'checkbox', array('id' => 'BCP_NBE-checkbox'));
$checkbox->set_checked_value('1');
$checkbox->set_default_value('0');
$checkbox->set_label_name('Networking & Business Etiquette');
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

$id = 'EMPLID';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-default');
$params = array('id' => 'career_passport-form', 'class' => 'form-horizontal filter-table-form img-rounded', 'method' => 'post');

$filter_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$filter_model->set_col_header('EMPLID'); // table column used for title of page (OR NOT!)

$generator = new GeneratorTracs_filter_table($name, $conf, $table_model, $filter_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'CMC Career Passport',
			  'HEADER' => 'CMC Career Passport',
			  'PORTAL_LINK' => '/tracs/admin/career_passport'
			  );

$generator->init($data);
$generator->generate();