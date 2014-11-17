<?php namespace Generator;

// define('ROOT', dirname(__DIR__));
define('APP', __DIR__);
include_once(APP . "/Config.php");
include_once(APP . "/Compiler/TemplateCompiler.php");
include_once(APP . "/Template/ControllerTemplate.php");

class Generator
{
	private $controllerTemplate;
	private $files; // create new files

	function __construct($name)
	{
		$controllerTemplate = new ControllerTemplate();
		$controllerTemplate->set_name($name);
	}

	public function generate()
	{

	}

	/* sets the data for generation of boilerplate 
	 * @param $data
	 */
	public function set_data($data)
	{
		$this->data = $data;
	}
}

?>