<?php namespace Generator;

include_once("Template.php");

class ViewTemplate extends Template
{
	protected $header_title; // title in the header
	protected $page_title; // title in the <head> section

	/* create a new view template
	 * @param $config config object
	 * @param $template the template file
	 */
	function __construct($config, $template)
	{
		$this->config = $config;
		$this->suffix = $this->config->get('VIEW', 'SUFFIX');

		$this->set_base_dir($this->config->get('VIEW', 'BASE_DIR'));
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