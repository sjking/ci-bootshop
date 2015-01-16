<?php namespace Generator;
/* bus_committee_lut - manage business committees
 * special considerations:
 * 	- the DateModified field is updated with current date on a creation/update
 *  - Order field: Modify in CI model so entries are ordered by Category Name,
 *    and ordering only works within a category
 *  - Description field (I think eliminated since its been unused)
 *  - ListChairOnContract (turned into enum: Yes/No)
 *  - Pad view should have the PAD | Name, so we will need a special CONCAT
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracsLUT_ordering.php');

$name = 'bus_committee';
$table = 'bus_committee_lut';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('bus_committee_category_id', array('class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Category');
$cols[] = $col;
$col = new TableColumn('Name', array('class' => 'col-lg-6 col-md-6 col-sm-5 col-xs-5'));
$col->set_display_name('Name');
$cols[] = $col;
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new TableModel($name, $table, $cols, 'committee_id', $params);
$table_model->set_order_column('Order');

/* Detail View Data */
$fields = array();

$field = new FormFieldModel('Name', 'input',
	array('class' => 'form-control', 'id' => 'Name-input'));
$field->set_label_name('Name');
$fields[] = $field;

$dropdown = new DropdownFormFieldModel('bus_committee_category_id', 'dropdown', 
	array('class' => 'form-control', 'id' => 'Category-dropdown'));
$dropdown->set_table_col('bus_committee_category', 'bus_committee_category_id', 'category');
$dropdown->set_label_name('Category');
$fields[] = $dropdown;

$field = new FormFieldModel('EmailAddress', 'input',
	array('class' => 'form-control', 'id' => 'EmailAddress-input'));
$field->set_label_name('Email Address');
$fields[] = $field;

$radio = new RadioFormFieldModel('Status', 'radio', array('id' => 'Status-radio'));
$radio->set_enum_array(array('Active' => 'Active', 'Delete' => 'Delete'));
$fields[] = $radio;

$dropdown = new DropdownFormFieldModel('Pad_Id', 'dropdown', 
	array('class' => 'form-control', 'id' => 'Pad-dropdown'));
$dropdown->set_table_col('bus_pad_lut', 'pad_id', 'Name');
$dropdown->set_label_name('PAD');
$fields[] = $dropdown;

// change to enum
$field = new FormFieldModel('ListChairOnContract', 'input',
	array('class' => 'form-control', 'id' => 'ListChairOnContract-input'));
$field->set_label_name('List Chair on Contract? (Yes or No)');
$fields[] = $field;

$id = 'committee_id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'bus_committee_lut-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('Name');

$generator = new GeneratorTracsLUT_ordering($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Business Committees',
			  'HEADER' => 'Business Committees',
			  'PORTAL_LINK_NAME' => 'Business Committees',
			  'PORTAL_LINK_DESC' => 'Manage the Business Committees',
			  'PORTAL_LINK' => '/tracs/lut/bus_committee'
			  );

$generator->init($data);
$generator->generate();