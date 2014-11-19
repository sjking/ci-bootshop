<?php namespace Generator;

class Model 
{
	protected $table_name; // name of table in db
	protected $columns; // array of field names from the table in db

	function __construct($name, $cols)
	{
		$this->table_name = $name;
		$this->columns = $cols;
	}

	public function get_name()
	{
		return $this->table_name;
	}

	public function get_columns()
	{
		return $this->columns;
	}
}

?>