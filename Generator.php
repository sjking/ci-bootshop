<?php namespace Generator;
/*
 * Extend this class to implement custom template generators
 * @author Steve King
 */


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

abstract class Generator
{
	protected $name;
	protected $data; // template data for compiling 
	protected $model;
	protected $config;
	protected $compiler;
	protected $files; // read/write files

	/* create a new generator
	 * @param $name the naming of files and classnames in project
	 * @param $config configuration data
	 * @param $model 
	 */
	function __construct($name, GeneratorConfig $config, Model $model)
	{
		$this->config = $config;
		$this->model = $model;
		$this->name = $name;
		$this->compiler = new TemplateCompiler();
		$this->files = new Files();
	}

	/* generates the boilerplate in the project directory */
	abstract public function generate();

	/* initialize the data for the template compilation
	 * @param $data associative array of compilation replacements
	 *
	 * This data should look something like this:
	 * {'HEADER' => 'Foobar', 'PAGE_TITLE' => 'Bash'}
	 */
	abstract public function init($data);

	/* remove all files created with generate */
	abstract public function destroy();

}

?>