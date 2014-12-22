<?php namespace Generator;
/* define the required fields for configuration of program 
 * @author Steve King
 */

use \Exception;


class GeneratorConfig
{
	protected $settings; // associative array of configurations
	
	/* create a new configuration object
	 * $file name of config file
	 * $base_dir full path where config file is stored
	 */
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