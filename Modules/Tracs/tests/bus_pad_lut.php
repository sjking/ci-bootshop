<?php namespace Generator;
/* bus_pad_lut - lookup table for managing business program-area-department
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracsLUT.php');

$name = 'bus_pad';
$table = 'bus_pad_lut';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
$cols = array('NameAbb', 'Name');
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new Model($name, $table, $cols, 'pad_id', $params);

/* Detail View Data */
$fields = array();

$fields[] = new FormFieldModel('NameAbb', 'input',
	array('class' => 'form-control', 'id' => 'NameAbb-input'));

$fields[] = new FormFieldModel('Name', 'input',
	array('class' => 'form-control', 'id' => 'Name-input'));
$dropdown = new DropdownFormFieldModel('ACAD_PROG', 'dropdown', 
	array('class' => 'form-control', 'id' => 'ACAD_PROG-dropdown'));
$dropdown->set_table_col('sims_code_lut', 'code', 'code');
$fields[] = $dropdown;

$fields[] = new FormFieldModel('School', 'input',
	array('class' => 'form-control', 'id' => 'School-input'));

$fields[] = new FormFieldModel('ProgramAreaDepartment', 'input',
	array('class' => 'form-control', 'id' => 'ProgramAreaDepartment-input'));

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
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('FacultyProfiles', 'checkbox', array('id' => 'FacultyProfiles-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('SixSemesterPlan', 'checkbox', array('id' => 'SixSemesterPlan-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('AoL', 'checkbox', array('id' => 'AoL-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$fields[] = $checkbox;

$checkbox = new CheckboxFormFieldModel('RecordStatus', 'checkbox', array('id' => 'RecordStatus-checkbox'));
$checkbox->set_checked_value('Yes');
$checkbox->set_default_value('No');
$fields[] = $checkbox;

$fields[] = new FormFieldModel('Notes', 'textarea',
	array('class' => 'form-control', 'id' => 'Notes-textarea', 'rows' =>'2'));

$fields[] = new FormFieldModel('UndergraduateConcentration', 'input',
	array('class' => 'form-control', 'id' => 'UndergraduateConcentration-input'));

$id = 'pad_id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'bus_pad_lut-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('Name');

$generator = new GeneratorTracsLUT($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Business Program Area Department',
			  'HEADER' => 'Business Program Area Department'
			  );

$generator->init($data);
$generator->generate();