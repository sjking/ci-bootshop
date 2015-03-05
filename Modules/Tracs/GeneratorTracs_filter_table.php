<?php namespace Generator;
/* Master detail interface template. There is a master view of all data in a 
 * table, and a detail edit view for each table entry
 * @author Steve King
 */

use \Exception;

include_once(dirname(dirname(__DIR__)) . "/Generator.php");
include_once(dirname(dirname(__DIR__)) . "/Template/FilterTable.php");
include_once(dirname(dirname(__DIR__)) . "/Template/TracsForm.php");
include_once(dirname(dirname(__DIR__)) . "/Template/JavascriptTemplate.php");
include_once(dirname(dirname(__DIR__)) . "/Model/FormModel.php");
include_once(dirname(dirname(__DIR__)) . "/Model/TableModel.php");

class GeneratorTracs_filter_table extends Generator
{
	protected $controllerTemplate;
	protected $viewTemplate;
	
	// table view templates
	protected $tableTemplate;
	protected $modelTemplate;

	protected $filter_model;

	// create form 
	protected $createViewTemplate;
	protected $createViewHeader;
	
	private $init; // flag to see if data is initialized
	private $filenames; // array of filename paths that were created

	private $javascriptTableTemplate;

	private $panelHeaderTemplate;
	private $panelFooterTemplate;
	private $filterPanelTemplate;

	/* Create a new generator
	 * @param $name the naming of files and classnames in project
	 * @param $config configuration data
	 * @param $table_model model with selected fields for table view
	 * @param $detail_model selected fields for detailed form edit view
	 */
	function __construct($name, GeneratorConfig $config, TableModel $table_model, FormModel $filter_model)
	{
		parent::__construct($name, $config, $table_model);
		$this->filter_model = $filter_model;

		// table view template
		$this->tableTemplate = new ViewTemplate($this->config, 
			'filter_table_body.php.tmpl');
		$this->tableTemplate->set_name($name, 'table');
		
		$this->controllerTemplate = new ControllerTemplate($this->config, 
			'filter_table_controller.php.tmpl');
		$this->controllerTemplate->set_name($name);
		
		$this->viewTemplate = new ViewTemplate($this->config, 
			'filter_table_view_header.php.tmpl');
		$this->viewTemplate->set_name($name);

		$this->modelTemplate = new ModelTemplate($this->config, 
			'filter_table_model.php.tmpl');
		$this->modelTemplate->set_name($this->model->get_name());
		$this->modelTemplate->set_vars(null);
		$this->modelTemplate->set_columns($this->model->get_columns());

		// javascript
		// $this->javascriptTableTemplate = new JavascriptTemplate($this->config, 
		// 	'table_sorting.js.tmpl');
		// $this->javascriptTableTemplate->set_name($name, 'table');

		// panel
		$this->panelHeaderTemplate = new ViewTemplate($this->config,
			'tracs_panel_header.php.tmpl');
		$this->panelHeaderTemplate->set_name($name, 'panel_header');
		$this->panelFooterTemplate = new ViewTemplate($this->config,
			'tracs_panel_footer.php.tmpl');
		$this->panelFooterTemplate->set_name($name, 'panel_footer');

		// filter panel
		$this->filterPanelTemplate = new ViewTemplate($this->config);
		$this->filterPanelTemplate->set_name($name, 'filter_panel');

		$this->data = $this->_init();
	}

	/* generates the boilerplate in the project directory */
	public function generate()
	{
		if ($this->init == false)
			throw new Exception('Generator Error: Data must be initialized.');
		
		// table view
		$table = new FilterTable($this->model->get_name(), 
								$this->model->get_columns(),
								$this->model->get_params());
		$template = $this->files->read($this->tableTemplate->get_template());
		$table->set_body($template);

		$tbl = $table->generate();
		$table_view = $this->compiler->compile($tbl, $this->data);
		$table_view_path = $this->tableTemplate->get_path();
		if ($this->files->write($table_view_path, $table_view))
			$this->filenames[] = $table_view_path;

		// compile the panel view, which contains the table
		$panel_footer_template = $this->files->read($this->panelFooterTemplate->get_template());
		$panel_footer_view = $this->compiler->compile($panel_footer_template, $this->data);
		$panel_footer_path = $this->panelFooterTemplate->get_path();
		if ($this->files->write($panel_footer_path, $panel_footer_view))
			$this->filenames[] = $panel_footer_path;
		$panel_header_template = $this->files->read($this->panelHeaderTemplate->get_template());
		$panel_header_view = $this->compiler->compile($panel_header_template, $this->data);
		$panel_header_path = $this->panelHeaderTemplate->get_path();
		if ($this->files->write($panel_header_path, $panel_header_view))
			$this->filenames[] = $panel_header_path;

		// filter panel
		$form = new TracsForm($this->filter_model);
		$form->set_submit_button('<span class="glyphicon glyphicon-filter"></span>&nbsp;Filter');
		$form_view = $form->generate();
		$form_view = $this->compiler->compile($form_view, $this->data);
		$form_view_path = $this->filterPanelTemplate->get_path();
		// $filter_panel_view = $this->compiler->compile($filter_panel_template, $this->data);
		// $filter_panel_path = $this->filterPanelTemplate->get_path();
		if ($this->files->write($form_view_path, $form_view))
			$this->filenames[] = $form_view_path;

		// controller
		$template = $this->files->read($this->controllerTemplate->get_template());
		$controller = $this->compiler->compile($template, $this->data);
		$controller_path = $this->controllerTemplate->get_path();
		if ($this->files->write($controller_path, $controller))
			$this->filenames[] = $controller_path;

		// main view
		$template = $this->files->read($this->viewTemplate->get_template());
		$view = $this->compiler->compile($template, $this->data);
		$view_path = $this->viewTemplate->get_path();
		if ($this->files->write($view_path, $view))
			$this->filenames[] = $view_path;

		// model
		$template = $this->files->read($this->modelTemplate->get_template());
		$model = $this->compiler->compile($template, $this->data);
		$model_path = $this->modelTemplate->get_path();
		if ($this->files->write($model_path, $model))
			$this->filenames[] = $model_path;

		// javascript
		// $template = $this->files->read($this->javascriptTableTemplate->get_template());
		// $js = $this->compiler->compile($template, $this->data);
		// $js_path = $this->javascriptTableTemplate->get_path();
		// if ($this->files->write($js_path, $js))
		// 	$this->filenames[] = $js_path;
	}

	/* initialize the data for the template compilation
	 * @param $data associative array of compilation replacements
	 *
	 * This data should look something like this:
	 * {'HEADER' => 'Foobar', 'PAGE_TITLE' => 'Bash'}
	 */
	public function init($data)
	{
		$this->data = array_merge($this->data, $data);

		$this->init = true;
	}

	public function destroy()
	{
		foreach($this->filenames as $f) {
			if ($this->files->delete($f) == false) {
				throw new Exception("Generator Error: Could not remove file '" . $f . "'.");
			}
		}
	}

	private function get_array_methods($model)
	{
		$str = '';
		$count = 0;

		foreach($model->get_fields() as $field) {
			if ($field->type() == 'dropdown' || $field->type() == 'radio') {
				if ($count > 0)
					$str .= "\n\n\t";
				$str .= $field->get_model_method();
				$count += 1;
			}
		}

		return $str;
	}

	private function get_array_controller_variables($model)
	{
		$str = '';
		$count = 0;

		foreach($model->get_fields() as $field) {
			if ($field->type() == 'dropdown' || $field->type() == 'radio') {
				if ($count > 0)
					$str .= "\n\t\t";
				$str .= '$data[' . "'" . $field->get_controller_array_variable() . "'" . ']';
				$str .= ' = ' . '$this->' . $this->detailModelTemplate->get_name() . '->';
				$str .= $field->get_method_name() . '();';
				$count += 1;
			}
		}

		return $str;
	}

	private function get_table_col_params_array(array $cols)
	{
		$str = 'array(';

		foreach($cols as $col) {
			foreach($col->get_params() as $key => $val) {
				$str .= "'" . $col->get_name() . "'" . ' => ';
				$str .= "'" . $key . '=' .'"' . $val . '"' . "'" . ',';
			}
		}
		$str = rtrim($str, ',') . ')';

		return $str;
	}

	private function get_table_column_display_name_map_array(array $cols)
	{
		$str = 'array(';

		foreach($cols as $col) {
			$str .= "'" . $col->get_name() . "'" . ' => ';
			$str .= "'" . $col->get_display_name() . "'" . ',';
		}
		$str = rtrim($str, ',') . ')';

		return $str;
	}

	/* initialize the replacements data */
	private function _init()
	{
		$data = array();
		$data['CONTROLLER_NAME'] = $this->controllerTemplate->get_name();
		$data['NAME'] = strtolower($data['CONTROLLER_NAME']);
		$data['VIEW_NAME'] = $this->viewTemplate->get_name();
		$data['VIEW_NAME_LINK'] = $this->viewTemplate->get_link();
		$data['MODEL_NAME'] = $this->modelTemplate->get_name();
		$data['TABLE_VIEW'] = $this->tableTemplate->get_name();
		$data['TABLE_VIEW_LINK'] = $this->tableTemplate->get_link();
		$data['DB_TABLE_NAME'] = $this->model->get_table_name();
		$data['MODEL_INSTANCE_VARIABLES'] = $this->modelTemplate->get_vars();
		$data['MODEL_SELECT_COLUMNS'] = $this->modelTemplate->get_columns();
		$data['MODEL_TABLE_ID_COL'] = $this->model->get_id();

		$data['PANEL_HEADER_PATH'] = $this->panelHeaderTemplate->get_link();
		$data['PANEL_FOOTER_PATH'] = $this->panelFooterTemplate->get_link();

		$data['TABLE_COL_PARAMS'] = $this->get_table_col_params_array($this->model->get_columns());

		// filter panel
		$data['FILTER_PANEL_LINK'] = $this->filterPanelTemplate->get_link();
		$data['DETAIL_ROW'] = $this->filter_model->get_row();

		$data['TABLE_COL_DISPLAY_NAME_MAP'] = $this->get_table_column_display_name_map_array($this->model->get_columns());

		// javascript
		$data['JAVASCRIPT_TABLE'] = null;//$this->javascriptTableTemplate->get_link();

		return $data;
	}

}

?>