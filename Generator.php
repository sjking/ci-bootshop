<?php namespace Generator;

use \Exception;

define('APP', __DIR__);

include_once(APP . "/GeneratorConfig.php");
include_once(APP . "/Compiler/TemplateCompiler.php");
include_once(APP . "/Template/ControllerTemplate.php");
include_once(APP . "/Template/ViewTemplate.php");
include_once(APP . "/Template/ModelTemplate.php");
include_once(APP . "/Template/Table.php");
include_once(APP . "/Files/Files.php");
include_once(APP . "/Model/Model.php");

class Generator
{
	protected $controllerTemplate;
	protected $viewTemplate;
	protected $tableTemplate;
	protected $modelTemplate;
	protected $files; // read/write files
	protected $compiler;
	protected $data; // template data for compiling 
	protected $model;

	private $init = false; // flag if the initialization has happened yet
	private $config;

	/* create a new generator, at the least we need a name for the class names
	 * @param $name
	 * @param $config
	 * @param $model
	 */
	function __construct($name, GeneratorConfig $config, Model $model)
	{
		$this->config = $config;
		$this->model = $model;
		
		// table view template
		$this->tableTemplate = new ViewTemplate($this->config, 
			'tbody.php.template');
		$this->tableTemplate->set_name($name . '_table');
		
		$this->controllerTemplate = new ControllerTemplate($this->config, 
			'controller.php.template');
		$this->controllerTemplate->set_name($name);
		
		$this->viewTemplate = new ViewTemplate($this->config, 
			'view.php.template');
		$this->viewTemplate->set_name($name);

		$this->modelTemplate = new ModelTemplate($this->config, 
			'model.php.template');
		$this->modelTemplate->set_name($name);
		$this->modelTemplate->set_vars($model->get_columns());

		$this->files = new Files();
		$this->compiler = new TemplateCompiler();
		$this->data = $this->_init();
	}

	/* generates the boilerplate in the project directory */
	public function generate()
	{
		if ($this->init == false)
			throw new Exception('Generator Error: Data must be initialized.');
		
		// table view
		$table = new Table($this->model->get_name(), $this->model->get_columns());
		$template = $this->files->read($this->tableTemplate->get_template());
		$table->set_body($template);
		$tbl = $table->generate();
		$table_view = $this->compiler->compile($tbl, $this->data);
		$table_view_path = $this->tableTemplate->get_path();
		$this->files->write($table_view_path, $table_view);

		// controller
		$template = $this->files->read($this->controllerTemplate->get_template());
		$controller = $this->compiler->compile($template, $this->data);
		$controller_path = $this->controllerTemplate->get_path();
		$this->files->write($controller_path, $controller);

		// main view
		$template = $this->files->read($this->viewTemplate->get_template());
		$view = $this->compiler->compile($template, $this->data);
		$view_path = $this->viewTemplate->get_path();
		$this->files->write($view_path, $view);

		// model
		$template = $this->files->read($this->modelTemplate->get_template());
		$model = $this->compiler->compile($template, $this->data);
		$model_path = $this->modelTemplate->get_path();
		$this->files->write($model_path, $model);
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

	/* initialize the known data */
	private function _init()
	{
		$data = array();
		$data['CONTROLLER_NAME'] = $this->controllerTemplate->get_name();
		$data['VIEW_NAME'] = $this->viewTemplate->get_name();
		$data['MODEL_NAME'] = $this->modelTemplate->get_name();
		$data['TABLE_VIEW'] = $this->tableTemplate->get_name();
		$data['DB_TABLE_NAME'] = $this->model->get_table_name();
		$data['MODEL_INSTANCE_VARIABLES'] = $this->modelTemplate->get_vars();

		return $data;
	}

}

?>