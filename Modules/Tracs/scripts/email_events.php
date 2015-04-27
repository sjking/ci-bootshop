<?php namespace Generator;
/* 
 * Sorting Example - Vegetable Fans
 *
 * @author Steve King
 */

define('MODULE_DIR', dirname(__DIR__));

include_once(MODULE_DIR . '/GeneratorTracs_sorting.php');

$name = 'email_events';
$table = 'email_event';
const BASE_URL = 'dev.busdevw/tracs/admin';

$conf = new GeneratorConfig('config.ini', MODULE_DIR);

/* Main List View data */
$cols = array();
$col = new TableColumn('event_id', array('class' => ''));
$col->set_display_name('Event ID');
$cols[] = $col;
$col = new TableColumn('name', array('class' => ''));
$col->set_display_name('Name');
$cols[] = $col;
$col = new TableColumn('category_id', array('class' => ''));
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