<?php namespace Generator;
/* 
 * Sorting Example - Vegetable Fans
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracs_filter_table.php');

$name = 'vegetable_filter';
$table = 'vegetable_fans';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('filter_table_config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('name', array('class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Name');
$cols[] = $col;
$col = new TableColumn('occupation', array('class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Occupation');
$cols[] = $col;
$col = new TableColumn('vegetable_id', array('class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Favorite Vegetable');
$cols[] = $col;
$col = new TableColumn('vegetable_status', array('class' => 'col-lg-3 col-md-3 col-sm-3 col-xs-3'));
$col->set_display_name('Vegetable State');
$cols[] = $col;

$params = array('id' => $name . '-table', 
				'class' => 'list table table-bordered');
$table_model = new TableModel($name, $table, $cols, 'id', $params);

/* Filter form Data */
$fields = array();

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

$id = 'id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'vegetable_fans-form', 'class' => 'form-inline', 'method' => 'post');

$filter_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$filter_model->set_col_header('name'); // table column used for title of page (OR NOT!)

$generator = new GeneratorTracs_filter_table($name, $conf, $table_model, $filter_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Vegetable Fans',
			  'HEADER' => 'Vegetable Fans',
			  'PORTAL_LINK' => '/tracs/admin/vegetable_filter'
			  );

$generator->init($data);
$generator->generate();