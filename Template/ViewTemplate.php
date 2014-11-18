<?php namespace Generator;

include_once("Template.php");

class ViewTemplate extends Template
{
	function __construct()
	{
		$this->suffix = Config::VIEW_SUFFIX;
		$this->set_base_dir(Config::VIEW_BASE_DIR);
		$this->set_template(Config::VIEW_TEMPLATE);
	}

	/* set the name
	 * @param $name
	 */
	public function set_name($name)
	{
		$name = ucfirst(strtolower($name));

		if ($this->suffix != '') {
			$this->name = $name + '_' + $this->suffix;
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