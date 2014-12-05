<?php namespace Generator;

include_once("Template.php");

class JavascriptTemplate extends Template
{
	/* create a new view template
	 * @param $config config object
	 * @param $template the template file (optional)
	 */
	function __construct($config, $template = null)
	{
		$this->config = $config;
		$this->suffix = $this->config->get('JAVASCRIPT', 'SUFFIX');

		if ($template) {
			$template_path = $this->config->get('JAVASCRIPT', 'TEMPLATE_DIR') . '/' . 
				$template;
			$this->set_template($template_path);
		}
	}

	/* get the name
	 */
	public function get_name()
	{
		return $this->name;
	}

	/* get the name link for the controller, since it might be in 
	 * subdirectories 
	 */
	public function get_link() 
	{
		$name = strtolower($this->get_name());
		return $this->_name . '/' . $name . '.js';
	}

	/* set an extra folder depth for js when setting the name
	 * @param $name project name
	 * @param $suffix extra stuff to append to project name
	 */
	public function set_name($name, $suffix = '')
	{
		$project_name = $name;
		
		if ($suffix)
			$name .= '_' . $suffix;
		
		parent::set_name($name);
		
		$this->_name = $project_name;

		$this->set_path();
	}

	protected function set_path()
	{
		$name = strtolower($this->get_name());

		$base_dir = $this->config->get('JAVASCRIPT', 'BASE_DIR') . '/' . $this->_name;
		$this->set_base_dir($base_dir);
	}

	/* get the full path for this controller in the project */
	public function get_path()
	{
		$name = strtolower($this->get_name());
		return $this->get_base_dir() . '/' . $name . '.js';
	}
}