<?php namespace Generator;

use \Exception;

include_once(dirname(dirname(__DIR__)) . "/Generator.php");
include_once(dirname(dirname(__DIR__)) . "/Template/TracsTable.php");

class GeneratorTracsLUT extends Generator
{
	protected $controllerTemplate;
	protected $viewTemplate;
	
	// table view templates
	protected $tableTemplate;
	protected $modelTemplate;

	// detail form view templates
	protected $formTemplate;
	protected $formModelTemplate;
	
	private $init; // flag to see if data is initialized
	private $filenames; // array of filename paths that were created

	private $detail_model;

	/* create a new generator
	 * @param $name the naming of files and classnames in project
	 * @param $config configuration data
	 * @param $table_model model with selected fields for table view
	 * @param $detail_model selected fields for detailed form edit view
	 */
	function __construct($name, GeneratorConfig $config, Model $table_model,
		Model $detail_model)
	{
		parent::__construct($name, $config, $table_model);
		$this->detail_model = $detail_model;

		// table view template
		$this->tableTemplate = new ViewTemplate($this->config, 
			'tracs_tbody.php.tmpl');
		$this->tableTemplate->set_name($name, 'table');
		
		$this->controllerTemplate = new ControllerTemplate($this->config, 
			'tracs_controller.php.tmpl');
		$this->controllerTemplate->set_name($name);
		
		$this->viewTemplate = new ViewTemplate($this->config, 
			'view_header.php.tmpl');
		$this->viewTemplate->set_name($name);

		$this->modelTemplate = new ModelTemplate($this->config, 
			'tracs_model.php.tmpl');
		$this->modelTemplate->set_name($name);
		$this->modelTemplate->set_vars($this->model->get_columns());
		$this->modelTemplate->set_columns($this->model->get_columns());

		// detail form view template
		// $this->formTemplate = new ViewTemplate($this->config,
		// 	'tracs_form.php.tmpl');

		$this->data = $this->_init();
	}

	/* generates the boilerplate in the project directory */
	public function generate()
	{
		if ($this->init == false)
			throw new Exception('Generator Error: Data must be initialized.');
		
		// table view
		$table = new TracsTable($this->model->get_name(), 
								$this->model->get_columns());
		$template = $this->files->read($this->tableTemplate->get_template());
		$table->set_body($template);
		$params = array('id' => $this->name . '-table', 
						'class' => 'list table table-striped table-hover');
		$table->set_params($params);
		$tbl = $table->generate();
		$table_view = $this->compiler->compile($tbl, $this->data);
		$table_view_path = $this->tableTemplate->get_path();
		if ($this->files->write($table_view_path, $table_view))
			$this->filenames[] = $table_view_path;

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

	/* initialize the known data */
	private function _init()
	{
		$data = array();
		$data['CONTROLLER_NAME'] = $this->controllerTemplate->get_name();
		$data['VIEW_NAME'] = $this->viewTemplate->get_name();
		$data['VIEW_NAME_LINK'] = 'admin/' . $this->viewTemplate->get_link();
		$data['MODEL_NAME'] = $this->modelTemplate->get_name();
		$data['TABLE_VIEW'] = $this->tableTemplate->get_name();
		$data['TABLE_VIEW_LINK'] = 'admin/' . $this->tableTemplate->get_link();
		$data['DB_TABLE_NAME'] = $this->model->get_table_name();
		$data['MODEL_INSTANCE_VARIABLES'] = $this->modelTemplate->get_vars();
		$data['MODEL_SELECT_COLUMNS'] = $this->modelTemplate->get_columns();
		$data['MODEL_TABLE_ID_COL'] = $this->model->get_id();

		return $data;
	}

}

?>