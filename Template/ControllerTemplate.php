<?php namespace Generator;

include_once("Template.php");

class ControllerTemplate extends Template
{

	/* create a new controller template
	 * @param $config config object
	 * @param $template the template file
	 */
	function __construct($config, $template)
	{
		$this->config = $config;
		$this->suffix = $this->config->get('CONTROLLER', 'SUFFIX');
		$this->set_base_dir($this->config->get('CONTROLLER', 'BASE_DIR'));
		$template_path = $this->config->get('CONTROLLER', 'TEMPLATE_DIR') . '/' . 
			$template;
		$this->set_template($template_path);
	}

	/* get the name
	 */
	public function get_name()
	{
		return $this->name;
	}

	/* get the full path for this controller in the project */
	public function get_path()
	{
		$name = strtolower($this->get_name());
		return $this->get_base_dir() . '/' . $name . '.php';
	}

	protected function set_path()
	{
		$name = strtolower($this->get_name());

		$base_dir = $this->config->get('CONTROLLER', 'BASE_DIR');
		$this->set_base_dir($base_dir);
	}

}

?>