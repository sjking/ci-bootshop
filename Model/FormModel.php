<?php namespace Generator;

include_once(dirname(__DIR__) . '/Template/FormElement.php');

/* encapsulate the data model for a form field */
class FormFieldModel
{
	protected $name;
	protected $type; // input, dropdown, hidden, etc.
	protected $params; // associative array of params and values
					   // ex: {'class' => 'form-control', id => 'id-input' }

	function __construct($name, $type, $params = null) 
	{
		$this->name = $name;
		$this->type = $type;
		$this->params = $params;
		$this->label_params = $label_params;
	}

	public function name() 
	{
		return $this->name;
	}

	public function type() 
	{
		return $this->type;
	}

	public function params() 
	{
		return $this->params;
	}

}

class FormModel 
{
	protected $name; // model name
	protected $table; // name of table in db
	protected $fields;
	protected $cols;
	protected $id; // name of primary key id for table
	protected $params; // associative array of params and values
					   // ex: {'class' => 'form-control', id => 'id-input' }
	protected $label_params; // the parameters for form labels

	/* create a new form
	 * @param $name used for the model file/class name
	 * @param $table db table to use
	 * @param $fields form fields, array of FormFieldModel objects
	 * @param $id the primary key of the db table
	 * @param $params optional parameters
	 */
	function __construct($name, $table, array $fields, $id, $params = null, 
		$label_params = null)
	{
		$this->name = $name;
		$this->table = $table;
		$this->id = $id;
		$this->fields = $fields;
		$this->init_cols($fields);
		$this->params = $params;
		$this->label_params = $label_params;
	}

	private function init_cols(array $fields)
	{
		$cols = array();

		foreach($fields as $field) {
			$cols[] = $field->name();
		}
		$this->cols = $cols;
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

	public function get_params()
	{
		return $this->params;
	}

	public function get_label_params()
	{
		return $this->label_params;
	}
}

?>