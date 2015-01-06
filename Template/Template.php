<?php namespace Generator;
/* Generic template class, extend to represent a template file
 * @author Steve King
 */

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

	protected $_name; // unmodified name

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
	public function set_name($name)
	{
		$this->_name = $name;

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
	abstract public function get_name();

	/* get the path where this file is created in the project */
	abstract public function get_path();

	/* set the full path of the file in project */
	abstract protected function set_path();

}

?>