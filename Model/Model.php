<?php namespace Generator;
/* generic data model for a template
 * @author Steve King
 */

class Model 
{
	protected $name; // model name
	protected $table; // name of table in db
	protected $columns; // array of field names from the table in db
	protected $id; // name of primary key id for table

	function __construct($name, $table, $cols, $id, $params = null)
	{
		$this->name = $name;
		$this->columns = $cols;
		$this->table = $table;
		$this->id = $id;
		$this->params = $params;
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

	public function get_params()
	{
		return $this->params;
	}
}

?>