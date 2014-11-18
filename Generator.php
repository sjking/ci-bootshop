<?php namespace Generator;

// define('ROOT', dirname(__DIR__));
define('APP', __DIR__);
include_once(APP . "/Config.php");
include_once(APP . "/Compiler/TemplateCompiler.php");
include_once(APP . "/Template/ControllerTemplate.php");
include_once(APP . "/Template/ViewTemplate.php");
include_once(APP . "/Files/Files.php");

class Generator
{
	private $controllerTemplate;
	private $files; // read/write files
	private $compiler;
	private $data;

	function __construct($name)
	{
		$this->controllerTemplate = new ControllerTemplate();
		$this->controllerTemplate->set_name($name);
		$this->files = new Files();
		$this->compiler = new TemplateCompiler();
		$this->data = $this->init();
	}

	/* generates the boilerplate in the project directory */
	public function generate()
	{
		// compile the templates
		$template = $this->files->read($this->controllerTemplate->get_template());
		$controller = $this->compiler->compile($template, $this->data);
		echo 'controller: ' . $controller;

		// write the template to the project
		$controller_path = $this->controllerTemplate->get_path();
		echo 'path: ' . $controller_path;
		$this->files->write($controller_path, $this->data);
	}

	/* initialize all of the preliminary known data, such as class names etc.
	 */
	private function init()
	{
		$data = array();
		$data['CONTROLLER_NAME'] = $this->controllerTemplate->get_name();

		return $data;
	}

	/* sets the data for generation of boilerplate 
	 * @param $data
	 */
	// public function set_data($data)
	// {
	// 	$this->data = $data;
	// }
}

?>