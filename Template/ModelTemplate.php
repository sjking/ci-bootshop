<?php namespace Generator;

include_once("Template.php");

class ModelTemplate extends Template
{
	protected $vars = ''; // instance variables
	protected $columns = ''; // columns to select in select queries

	/* create a new controller template
	 * @param $config config object
	 * @param $template the template file
	 */
	function __construct($config, $template)
	{
		$this->config = $config;
		$this->suffix = $this->config->get('MODEL', 'SUFFIX');
		$this->set_base_dir($this->config->get('MODEL', 'BASE_DIR'));
		$template_path = $this->config->get('MODEL', 'TEMPLATE_DIR') . '/' . 
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

	/* get the full path for this controller in the project */
	public function get_path()
	{
		$name = strtolower($this->get_name());
		return $this->get_base_dir() . '/' . $name . '.php';
	}

	/* sets the instance variables for the model 
	 * @param $cols
	 */
	public function set_vars($cols)
	{
		$vars = '';

		foreach($cols as $col)
		{
			$vars .= "\t" . 'var $' . $col . ';' . "\n";
		}
		$vars = rtrim($vars, "\n");

		$this->vars = $vars;
	}

	/* sets the columns that are selected from get queries
	 * @param $cols array of column names
	 */
	public function set_columns($cols)
	{
		$columns = '';
		foreach($cols as $col)
		{
			$columns .= $col . ', ';
		}
		$columns = substr($columns, 0, strlen($columns) - 2);

		$this->columns = $columns;
	}

	/* returns a string list of columns for select queries */
	public function get_columns()
	{
		return $this->columns;
	}

	public function get_vars()
	{
		return $this->vars;
	}

}

?>