<?php namespace Generator;
/* 
 * Email Templates TRACS module
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracs_sorting.php');

$name = 'email_templates';
$table = 'email_template';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('template_id', array('class' => 'col-lg-1 col-md-1 col-sm-1 col-xs-1'));
$col->set_display_name('ID');
$cols[] = $col;
$col = new TableColumn('Name', array('class' => 'col-lg-5 col-md-5 col-sm-5 col-xs-5'));
$col->set_display_name('Name');
$cols[] = $col;
$col = new TableColumn('Category_ID', array('class' => 'col-lg-2 col-md-2 col-sm-2 col-xs-2'));
$col->set_display_name('Category');
$cols[] = $col;
$col = new TableColumn('description', array('class' => ''));
$col->set_display_name('Description');
$cols[] = $col;
$params = array('id' => $name . '-table', 
				'class' => 'list table table-striped table-hover');
$table_model = new TableModel($name, $table, $cols, 'event_id', $params);

/* Detail View Data */
$fields = array();

$field = new FormFieldModel('template', 'input',
	array('class' => 'form-control', 'id' => 'template-input'));
$field->set_label_name('Email Template');
$fields[] = $field;

$field = new FormFieldModel('description', 'input',
	array('class' => 'form-control', 'id' => 'template-input'));
$field->set_label_name('Description');
$fields[] = $field;

$id = 'event_id';
$label_params = array('class' => '');
$button_params = array('class' => 'btn btn-primary');
$params = array('id' => 'email_events-form', 'class' => '', 'method' => 'post');

$detail_model = new FormModel($name, $table, $fields, $id, $params, $label_params, $button_params);
$detail_model->set_col_header('name'); // table column used for title of page

$generator = new GeneratorTracs_sorting($name, $conf, $table_model, $detail_model);

$data = array('CONTROLLER_NAME' => $name,
			  'PAGE_TITLE' => 'Email Events',
			  'HEADER' => 'Email Events',
			  'PORTAL_LINK_NAME' => 'Email Events',
			  'PORTAL_LINK_DESC' => 'Email Events',
			  'PORTAL_LINK' => '/tracs/lut/email_events'
			  );

$generator->init($data);
$generator->generate();