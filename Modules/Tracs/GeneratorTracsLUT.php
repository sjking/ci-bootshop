<?php namespace Generator;

use \Exception;

include_once(dirname(dirname(__DIR__)) . "/Generator.php");
include_once(dirname(dirname(__DIR__)) . "/Template/TracsTable.php");
include_once(dirname(dirname(__DIR__)) . "/Template/Form.php");
include_once(dirname(dirname(__DIR__)) . "/Model/FormModel.php");

class GeneratorTracsLUT extends Generator
{
	protected $controllerTemplate;
	protected $viewTemplate;
	
	// table view templates
	protected $tableTemplate;
	protected $modelTemplate;

	// detail form view templates
	protected $detailViewTemplate;
	protected $detailModelTemplate;
	
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
		FormModel $detail_model)
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
		$this->modelTemplate->set_name($this->model->get_name());
		$this->modelTemplate->set_vars($this->model->get_columns());
		$this->modelTemplate->set_columns($this->model->get_columns());

		// detail form view template
		$this->detailModelTemplate = new ModelTemplate($this->config,
			'tracs_detail_model.php.tmpl');
		$this->detailModelTemplate->set_name($this->detail_model->get_name());
		$this->detailModelTemplate->set_vars(null);
		$this->detailModelTemplate->set_columns($this->detail_model->get_columns());

		$this->detailViewTemplate = new ViewTemplate($this->config,
			'tracs_form.php.tmpl');
		$this->detailViewTemplate->set_name($name, 'detail');

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

		// detail view 
		$form = new Form($this->detail_model->get_fields());
		$template = $this->files->read($this->detailViewTemplate->get_template());
		$params = array('id' => $this->name . '-form', 
						'class' => 'form-horizontal',
						'method' => 'post',
						'role' => 'form');
		$form->set_params($params);
		$this->data['FORM_DATA'] = $form->generate();

		$form_view = $this->compiler->compile($template, $this->data);
		$form_view_path = $this->detailViewTemplate->get_path();
		if ($this->files->write($form_view_path, $form_view))
			$this->filenames[] = $form_view_path;

		// detail model
		$template = $this->files->read($this->detailModelTemplate->get_template());
		$model = $this->compiler->compile($template, $this->data);
		$model_path = $this->detailModelTemplate->get_path();
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

	/* initialize the replacements data */
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

		// detail view
		$data['DETAIL_MODEL_NAME'] = $this->detailModelTemplate->get_name();
		$data['DETAIL_VIEW_LINK'] = 'admin/' . $this->detailViewTemplate->get_link();
		$data['DETAIL_MODEL_INSTANCE_VARIABLES'] = $this->detailModelTemplate->get_vars();
		$data['DETAIL_MODEL_SELECT_COLUMNS'] = $this->detailModelTemplate->get_columns();
		$data['DETAIL_MODEL_TABLE_ID_COL'] = $this->detail_model->get_id();

		return $data;
	}

}

?>