<?php namespace Generator;

include_once("Template.php");

class ViewTemplate extends Template
{
	protected $header_title; // title in the header
	protected $page_title; // title in the <head> section

	/* create a new view template
	 * @param $config config object
	 * @param $template the template file (optional)
	 */
	function __construct($config, $template = null)
	{
		$this->config = $config;
		$this->suffix = $this->config->get('VIEW', 'SUFFIX');

		$name = strtolower($this->get_name());

		$base_dir = $name . '/' . $this->config->get('VIEW', 'BASE_DIR');
		$this->set_base_dir($base_dir);
		if ($template) {
			$template_path = $this->config->get('VIEW', 'TEMPLATE_DIR') . '/' . 
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
		return $this->_name . '/' . $this->name;
	}

	/* set an extra folder depth for models when setting the name
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

		$base_dir = $this->config->get('VIEW', 'BASE_DIR') . '/' . $this->_name;
		$this->set_base_dir($base_dir);
	}

	/* set the page header 
	 * @param $name
	 */
	public function set_header($name)
	{
		$this->header_title = $name;
	}

	/* get the header for the page title */
	public function get_header()
	{
		return $this->header_title;
	}

	/* set the page title 
	 * @param $title
	 */
	public function set_page_title($title)
	{
		$this->page_title = $title;
	}

	/* get the title for the head section */
	public function get_page_title()
	{
		return $this->page_title;
	}

	/* get the full path for this controller in the project */
	public function get_path()
	{
		$name = strtolower($this->get_name());
		return $this->get_base_dir() . '/' . $name . '.php';
	}
}