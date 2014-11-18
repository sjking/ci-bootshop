<?php namespace Generator;

abstract class Template 
{
	/* base directory where the template will be created in the project */
	private $base_dir;

	/* template file */
	private $template;

	/* template data: key => value pairs of replacement */
	// private $data;

	/* name of the template: which is what it will be named as in project */
	private $name;

	/* the suffix for the filename */
	protected $suffix;

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

	/* set the data for replacement
	 * @param $data
	 */
	// public function set_data($data)
	// {
	// 	$this->data = $data;
	// }

	//  get the data for replacement
	 
	// public function get_data()
	// {
	// 	return $this->data;
	// }

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