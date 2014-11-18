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
		$template_path = $this->config->get('VIEW', 'TEMPLATE_DIR') . '/' . 
			$template;
		$this->set_template($template_path);
	}

	/* set the name
	 * @param $name
	 */
	public function set_name($name)
	{
		$name = ucfirst(strtolower($name));

		if ($this->suffix != '') {
			$this->name = $name . '_' . $this->suffix;
		}
		else {
			$this->name = $name;
		}
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

}

?>