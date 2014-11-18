<?php namespace Generator;

use \Exception;

/* define the required fields for configuration of program */
class GeneratorConfig
{
	protected $settings; // associative array of configurations
	
	function __construct($file = "config.ini", $base_dir = null)
	{
		$path = $base_dir ? $base_dir . '/' . $file : $file;

		if (!$settings = parse_ini_file($path, TRUE)) 
			throw new Exception('Unable to open ' . $file . '.');

		$this->settings = $settings;
	}

	/* returns the value of a configuration for a class
	 * @param $class 
	 * @param $var
	 */
	public function get($class, $var)
	{
		if (isset($this->settings[$class][$var]))
			return $this->settings[$class][$var];
		else {
			$msg = "Configuration variable with class: $class, and value: $var" .
				" does not exist.";
			throw new Exception('Generator: ' . $msg);
		}
	}
}

?>