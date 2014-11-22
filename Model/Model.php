<?php namespace Generator;

class Model 
{
	protected $name; // model name
	protected $table; // name of table in db
	protected $columns; // array of field names from the table in db
	protected $id; // name of primary key id for table

	function __construct($name, $table, $cols, $id)
	{
		$this->name = $name;
		$this->columns = $cols;
		$this->table = $table;
		$this->id = $id;
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_columns()
	{
		return $this->columns;
	}

	public function get_table_name()
	{
		return $this->table;
	}

	public function get_id()
	{
		return $this->id;
	}
}

?>