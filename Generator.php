<?php namespace Generator;

use \Exception;

// define('ROOT', dirname(__DIR__));
define('APP', __DIR__);
// include_once(APP . "/Config.php");
include_once(APP . "/GeneratorConfig.php");
include_once(APP . "/Compiler/TemplateCompiler.php");
include_once(APP . "/Template/ControllerTemplate.php");
include_once(APP . "/Template/ViewTemplate.php");
include_once(APP . "/Files/Files.php");

global $config; // global config object

class Generator
{
	protected $controllerTemplate;
	protected $viewTemplate;
	protected $files; // read/write files
	protected $compiler;
	protected $data; // template data for compiling 

	private $init = false; // flag if the initialization has happened yet
	private $config;

	/* create a new generator, at the least we need a name for the class names
	 * @param $name
	 * @param $config
	 */
	function __construct($name, GeneratorConfig $config)
	{
		$this->config = $config;
		$this->controllerTemplate = new ControllerTemplate($this->config);
		$this->controllerTemplate->set_name($name);
		$this->viewTemplate = new ViewTemplate($this->config);
		$this->viewTemplate->set_name($name);
		$this->files = new Files();
		$this->compiler = new TemplateCompiler();
		$this->data = $this->_init();
	}

	/* generates the boilerplate in the project directory */
	public function generate()
	{
		if ($this->init == false)
			throw new Exception('Generator Error: Data must be initialized.');
		
		// compile the templates
		$template = $this->files->read($this->controllerTemplate->get_template());
		$controller = $this->compiler->compile($template, $this->data);

		$template = $this->files->read($this->viewTemplate->get_template());
		$view = $this->compiler->compile($template, $this->data);
		
		// echo 'controller: ' . $controller;
		// echo 'data: ' . print_r($this->data);

		// write the template to the project
		$controller_path = $this->controllerTemplate->get_path();
		// echo 'path: ' . $controller_path;
		$this->files->write($controller_path, $controller);

		$view_path = $this->viewTemplate->get_path();
		$this->files->write($view_path, $view);
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

		return $data;
	}

}

?>