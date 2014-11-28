<?php namespace Generator;

include_once(dirname(__DIR__) . '/Template/FormElement.php');

/* encapsulate the data model for form fields */
class FormFieldsModel
{
	protected $fields; // associative array

	/* create new form fields model
	 * @param $fields associative array of fieldnames and form input element
	 *   ex: {'firstName' => 'input', 'status' => 'dropdown', 
	 *        'personId' => 'hidden'}
	 */
	function __construct($fields) 
	{
		$this->fields = $fields;
	}

	/* returns the array of fields */
	public function get_fields() 
	{
		return $this->fields;
	}
}

class FormModel 
{
	protected $name; // model name
	protected $table; // name of table in db
	protected $fields; // associative array
	protected $cols;
	protected $id; // name of primary key id for table

	// fields is associative array of fieldnames and form input element
	//   ex: {'firstName' => 'input', 'status' => 'dropdown', 
	//        'personId' => 'hidden'}
	function __construct($name, $table, array $fields, $id)
	{
		$this->name = $name;
		$this->table = $table;
		$this->id = $id;
		$this->fields = new FormFieldsModel($fields);
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