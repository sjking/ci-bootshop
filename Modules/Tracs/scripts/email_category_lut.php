<?php namespace Generator;
/* 
 * Sorting Example - Vegetable Fans
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracsLUT_sorting.php');

$name = 'email_category';
$table = 'email_category';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('category_id', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('ID');
$cols[] = $col;
$col = new TableColumn('category', array('class' => 'col-lg-8 col-md-8 col-sm-8 col-xs-8'));
$col->set_display_name('Category');
$cols[] = $col;
$params = array('id' => $name . '-table',
				'class' => 'list table table-striped table-hover');
$table_model = new TableModel($name, $table, $cols, 'category_id', $params);

/* Detail View Data */
$fields = array();

$field = new FormFieldModel('category', 'input',
	array('class' => 'form-control', 'id' => 'category-input'));
$field->set_label_name('Category');
$fields[] = $field;

$radio = new RadioFormFieldModel('status', 'radio', array('id' => 'status-radio'));
$status = array(
				'Active' => 'Active',
				'Delete' => 'Delete'
				);
$radio->set_enum_array($status);
$radio->set_label_name('Status');
$fields[] = $radio;

$id = 'category_id';
$label_params = array('class' => 'control-label col-md-2');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'email_category-form', 'class' => 'form-horizontal', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('category'); // table column used for title of page

$generator = new GeneratorTracsLUT_sorting($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Email Categories Management',
			  'HEADER' => 'Email Categories',
			  'PORTAL_LINK_NAME' => 'Email Categories',
			  'PORTAL_LINK_DESC' => 'Manage Email Categories',
			  'PORTAL_LINK' => '/tracs/lut/email_category'
			  );

$generator->init($data);
$generator->generate();
$generator->output();