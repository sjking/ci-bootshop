<?php namespace Generator;

class FormModel 
{
	protected $name; // model name
	protected $table; // name of table in db
	// fields is associative array of fieldnames and form input element
	//   ex: {'firstName' => 'input', 'status' => 'dropdown', 
	//        'personId' => 'hidden'}
	protected $fields; 
	protected $cols;
	protected $id; // name of primary key id for table

	function __construct($name, $table, $fields, $id)
	{
		$this->name = $name;
		$this->fields = $fields;
		$this->table = $table;
		$this->id = $id;
		$this->cols = array_keys($fields);
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_fields()
	{
		return $this->fields;
	}

	public function get_columns()
	{
		return $this->cols;
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