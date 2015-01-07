<?php namespace Generator;
/* bus_pad_lut - lookup table for managing business program-area-department
 *
 * Programs, Areas and Departments (pad) look up table stores
 *  - academic programs (e.g. Undergraduate Program, Executive Masters of 
 *    Business Administration Program, MSc Finance Program, …)
 *  - areas (e.g. Accounting, Finance, Strategy, …)
 *  - departments (e.g. Dean’s Office, Advancement, Career Management Centre, …)
 * pad look up table is used throughout TRACS to specify area/program/department 
 * information for courses, ranks, stakeholders, .... Then, that pad information 
 * is used to look at courses/ranks/stakeholders in a specific 
 * program/area/department to support decision making.
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracsLUT_sorting.php');

$name = 'bus_pad';
$table = 'bus_pad_lut';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
// $cols = array('NameAbb', 'Name');
$cols = array();
$col = new TableColumn('NameAbb', array('class' => 'col-lg-2 col-md-2 col-sm-3 col-xs-3'));
$col->set_display_name('Abbreviation');
$cols[] = $col;
$col = new TableColumn('Name', array('class' => 'col-lg-8 col-md-8 col-sm-6 col-xs-6'));
$col->set_display_name('Name');
$cols[] = $col;
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new TableModel($name, $table, $cols, 'pad_id', $params);

/* Detail View Data */
$fields = array();

$field = new FormFieldModel('NameAbb', 'input',
	array('class' => 'form-control', 'id' => 'NameAbb-input'));
$field->set_label_name('Name Abbreviation');
$fields[] = $field;

$fields[] = new FormFieldModel('Name', 'input',
	array('class' => 'form-control', 'id' => 'Name-input'));

$dropdown = new DropdownFormFieldModel('ACAD_PROG', 'dropdown', 
	array('class' => 'form-control', 'id' => 'ACAD_PROG-dropdown'));
$dropdown->set_table_col('sims_code_lut', 'code', 'code');
$dropdown->set_label_name('Academic Program');
$fields[] = $dropdown;

$fields[] = new FormFieldModel('School', 'input',
	array('class' => 'form-control', 'id' => 'School-input'));

$field = new FormFieldModel('ProgramAreaDepartment', 'input',
	array('class' => 'form-control', 'id' => 'ProgramAreaDepartment-input'));
$field->set_label_name('Program Area Department');
$fields[] = $field;

$radio = new RadioFormFieldModel('Type', 'radio', array('id' => 'Type-radio'));
$radio->set_enum_array(array('Internal' => 'Internal', 'External' => 'External'));
$fields[] = $radio;

$fields[] = new FormFieldModel('Career', 'input',
	array('class' => 'form-control', 'id' => 'Career-input'));

$checkbox = new CheckboxFormFieldModel('Staff', 'checkbox', array('id' => 'Staff-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('Faculty', 'checkbox', array('id' => 'Faculty-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('Research', 'checkbox', array('id' => 'Research-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('WebDirectory', 'checkbox', array('id' => 'WebDirectory-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$checkbox->set_label_name('Web Directory');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('FacultyProfiles', 'checkbox', array('id' => 'FacultyProfiles-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$checkbox->set_label_name('Faculty Profiles');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('SixSemesterPlan', 'checkbox', array('id' => 'SixSemesterPlan-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$checkbox->set_label_name('Six Semester Plan');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('AoL', 'checkbox', array('id' => 'AoL-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$checkbox->set_label_name('Assurance of Learning');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('RecordStatus', 'checkbox', array('id' => 'RecordStatus-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');

$radio = new RadioFormFieldModel('RecordStatus', 'radio', array('id' => 'RecordStatus-radio'));
$radio->set_enum_array(array('Active' => 'Active', 'Past' => 'Past'));
$radio->set_label_name('Status');
$fields[] = $radio;

$fields[] = new FormFieldModel('Notes', 'textarea',
	array('class' => 'form-control', 'id' => 'Notes-textarea', 'rows' =>'2'));

$field = new FormFieldModel('UndergraduateConcentration', 'input',
	array('class' => 'form-control', 'id' => 'UndergraduateConcentration-input'));
$field->set_label_name('Undergraduate Concentration');
$fields[] = $field;

$id = 'pad_id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'bus_pad_lut-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('Name');

$generator = new GeneratorTracsLUT_sorting($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Business Program Area Department',
			  'HEADER' => 'Business Program Area Department',
			  'PORTAL_LINK_NAME' => 'Business Program Area Department',
			  'PORTAL_LINK_DESC' => 'Manage the Program Area Department',
			  'PORTAL_LINK' => '/tracs/lut/bus_pad'
			  );

$generator->init($data);
$generator->generate();