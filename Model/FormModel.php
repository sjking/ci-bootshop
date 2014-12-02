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

/* dropdown has extra information about the data of its options */
class DropDownFormFieldModel extends FormFieldModel
{
	protected $table = null; // table where to get the data
	protected $col = null; // the column in the table
	protected $enum_array = null; // an array of pre-set enums

	function set_enum_array(array $enums)
	{
		$this->enum_array = $enum;
		$this->table = null;
		$this->col = null;
	}

	/* set table and column name from database for populating dropdown
	 * @param $table
	 * @param $col
	 */
	function set_table_col($table, $col)
	{
		$this->table = $table;
		$this->col = $col;
		$this->enum_array = null;
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
	protected $col_header; // what is the column to use for the title/header of
						   // each row?

	/* create a new form
	 * @param $name used for the model file/class name
	 * @param $table db table to use
	 * @param $fields form fields, array of FormFieldModel objects
	 * @param $id the primary key of the db table
	 * @param $params optional parameters
	 * @param $label_params
	 * @param $button_params
	 */
	function __construct($name, $table, array $fields, $id, $params = null, 
		$label_params = null, $button_params = null)
	{
		$this->name = $name;
		$this->table = $table;
		$this->id = $id;
		$this->fields = $fields;
		$this->init_cols($fields);
		$this->params = $params;
		$this->label_params = $label_params;
		$this->button_params = $button_params;
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

	public function get_button_params()
	{
		return $this->button_params;
	}

	/* return the variable name used for the row data */
	public function get_row() 
	{
		$row = $this->name . '_row';
		return $row;
	}

	public function set_col_header($col)
	{
		$this->col_header = $col;
	}

	public function get_col_header()
	{
		return $this->col_header;
	}
}

?>