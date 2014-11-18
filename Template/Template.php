<?php namespace Generator;

abstract class Template 
{
	/* base directory where the template will be created in the project */
	private $base_dir;

	/* template file */
	private $template;

	/* name of the template: which is what it will be named as in project */
	protected $name;

	/* the suffix for the filename */
	protected $suffix;

	/* configuration object */
	protected $config;

	/* set the base directory
	 * @param $path
	 */
	protected function set_base_dir($path)
	{
		$this->base_dir = $path;
	}

	/* get the base directory
	 */
	protected function get_base_dir()
	{
		return $this->base_dir;
	}

	/* set the template path
	 * @param $path
	 */
	protected function set_template($path)
	{
		$this->template = $path;
	}

	/* get the template path
	 */
	public function get_template()
	{
		return $this->template;
	}

	/* set the name
	 * @param $name
	 */
	abstract public function set_name($name);

	/* get the name
	 */
	abstract public function get_name();

	/* get the path where this file is created in the project */
	abstract public function get_path();

}

?>