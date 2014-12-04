<?php namespace Generator;

use \Exception;

include_once(dirname(dirname(__DIR__)) . "/Generator.php");
include_once(dirname(dirname(__DIR__)) . "/Template/TracsTable.php");
include_once(dirname(dirname(__DIR__)) . "/Template/TracsForm.php");
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
	protected $detailViewHeader;

	// create form 
	protected $createViewTemplate;
	protected $createViewHeader;
	
	private $init; // flag to see if data is initialized
	private $filenames; // array of filename paths that were created

	private $detail_model;
	private $create_model;

	/* Create a new generator
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
		$this->modelTemplate->set_vars(null);
		$this->modelTemplate->set_columns($this->model->get_columns());

		// detail form view template
		$this->detailModelTemplate = new ModelTemplate($this->config);
		$this->detailModelTemplate->set_name($this->detail_model->get_name());
		$this->detailModelTemplate->set_vars(null);
		$this->detailModelTemplate->set_columns($this->detail_model->get_columns());

		$this->detailViewTemplate = new ViewTemplate($this->config);
		$this->detailViewTemplate->set_name($name, 'detail');

		$this->detailViewHeader = new ViewTemplate($this->config, 
			'detail_view_header.php.tmpl');
		$this->detailViewHeader->set_name($name, 'detail_header');

		// create form view
		$create_model = clone $this->detail_model; // almost same as update form
		$create_model->empty_form();
		$create_model->set_name($name . '_create');
		$this->create_model = $create_model;

		$this->createModelTemplate = new ModelTemplate($this->config);
		$this->createModelTemplate->set_name($this->create_model->get_name());
		$this->createModelTemplate->set_vars(null);
		$this->createModelTemplate->set_columns($this->create_model->get_columns());

		$this->createViewTemplate = new ViewTemplate($this->config);
		$this->createViewTemplate->set_name($name, 'create');
		
		$this->createViewHeader = new ViewTemplate($this->config, 
			'create_view_header.php.tmpl');
		$this->createViewHeader->set_name($name, 'create_header');

		$this->data = $this->_init();
	}

	/* generates the boilerplate in the project directory */
	public function generate()
	{
		if ($this->init == false)
			throw new Exception('Generator Error: Data must be initialized.');
		
		// table view
		$table = new TracsTable($this->model->get_name(), 
								$this->model->get_columns(),
								$this->model->get_params());
		$template = $this->files->read($this->tableTemplate->get_template());
		$table->set_body($template);

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

		// detail view (for editing)
		$form = new Form($this->detail_model);
		$form->set_submit_button('Update');
		$form_view = $form->generate();
		$form_view = $this->compiler->compile($form_view, $this->data);
		$form_view_path = $this->detailViewTemplate->get_path();
		if ($this->files->write($form_view_path, $form_view))
			$this->filenames[] = $form_view_path;

		$template = $this->files->read($this->detailViewHeader->get_template());
		$detail_header = $this->compiler->compile($template, $this->data);
		$detail_header_path = $this->detailViewHeader->get_path();
		if ($this->files->write($detail_header_path, $detail_header))
			$this->filenames[] = $detail_header_path;

		// create view
		$form = new Form($this->create_model);
		$form->set_submit_button('Create');
		$form_view = $form->generate();
		$form_view = $this->compiler->compile($form_view, $this->data);
		$form_view_path = $this->createViewTemplate->get_path();
		if ($this->files->write($form_view_path, $form_view))
			$this->filenames[] = $form_view_path;

		$template = $this->files->read($this->createViewHeader->get_template());
		$create_header = $this->compiler->compile($template, $this->data);
		$create_header_path = $this->createViewHeader->get_path();
		if ($this->files->write($create_header_path, $create_header))
			$this->filenames[] = $create_header_path;

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

	/* initialize the replacements data */
	private function _init()
	{
		$data = array();
		$data['CONTROLLER_NAME'] = $this->controllerTemplate->get_name();
		$data['NAME'] = strtolower($data['CONTROLLER_NAME']);
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
		$data['DETAIL_VIEW_LINK'] = 'admin/' . $this->detailViewTemplate->get_link();
		$data['DETAIL_MODEL_SELECT_COLUMNS'] = $this->detailModelTemplate->get_columns();
		$data['DETAIL_ROW'] = $this->detail_model->get_row();
		$data['DETAIL_HEADER'] = $this->detail_model->get_col_header();
		$data['DETAIL_VIEW_HEADER_LINK'] = 'admin/' . $this->detailViewHeader->get_link();
		$data['DETAIL_MODEL_DROPDOWN_METHODS'] = $this->get_array_methods($this->detail_model);
		$data['DETAIL_MODEL_DROPDOWN_CONTROLLER_VARIABLES'] = $this->get_array_controller_variables($this->detail_model);

		// create view
		$data['CREATE_VIEW_LINK'] = 'admin/' . $this->createViewTemplate->get_link();
		$data['CREATE_VIEW_HEADER_LINK'] = 'admin/' . $this->createViewHeader->get_link();

		return $data;
	}

}

?>