<?php namespace Generator;

// use King\Generator\Config;
// include_once(__DIR__ . "/../Config.php");
include_once("Template.php");

class ControllerTemplate extends Template
{
	/* the suffix for the filename */
	private $suffix;

	function __construct()
	{
		$suffix = Config::CONTROLLER_SUFFIX;
		$this->set_base_dir(Config::CONTROLLER_BASE_DIR);
		$this->set_template(Config::CONTROLLER_TEMPLATE);
	}

	/* set the name
	 * @param $name
	 */
	public function set_name($name)
	{
		if ($suffix != '') {
			$this->name = $name + '_' + $suffix;
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

}

?>