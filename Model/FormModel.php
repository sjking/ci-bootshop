<?php namespace Generator;

include_once(dirname(__DIR__) . '/Template/FormElement.php');

/* encapsulate the data model for a form field */
class FormFieldModel
{
	protected $name;
	protected $type; // input, dropdown, hidden, etc.
	protected $params; // associative array of params and values
					   // ex: {'class' => 'form-control', id => 'id-input' }
	protected $update_form = true; // if true, then the form will populate the
								   // fields with its data, otherwise its an 
	 							   // empty form.

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

	public function empty_form()
	{
		$this->update_form = false;
	}

	public function update_form()
	{
		$this->update_form = true;
	}

	public function variable_name()
	{
		if ($this->update_form)
			return $this->name();
		else
			return null;
	}

}

/* dropdown has extra information about the data of its options; this is
 * only to represent the dropdown values, but not the value itself */
class DropdownFormFieldModel extends FormFieldModel
{
	// look-up table
	protected $table = null; // table where to get the data
	protected $table_id = null; // the column primary key in the table
	protected $table_col = null; // the name of the row to display to user

	// enum
	protected $enum_array = null; // an array of pre-set enums

	function __construct($name, $type, $params = null) 
	{
		parent::__construct($name, $type, $params);
		$this->method_name = 'get_' . $this->name . '_dropdown';
	}

	/* set the pre-set values of the dropdown
	 * @param $vals
	 */
	public function set_enum_array(array $vals)
	{
		$this->enum_array = $vals;
		$this->table = null;
		$this->col = null;
	}

	/* return the method name used in codeigniter model */
	public function get_method_name()
	{
		return $this->method_name;
	}

	/* return the controller variable used in controller and view */
	public function get_controller_dropdown_variable()
	{
		$str = $this->name . '_dropdown';
		return $str;
	}

	/* set table and column name from database for populating dropdown
	 * @param $table
	 * @param $col
	 */
	public function set_table_col($table, $id, $col)
	{
		$this->table = $table;
		$this->table_id = $id;
		$this->table_col = $col;
		$this->enum_array = null;
	}

	private function is_enum()
	{
		return $this->enum_array;
	}

	private function is_lookup_table()
	{
		return $this->table && $this->table_id && $this->table_col;
	}

	/* returns the code for the method to compile into the php codeigniter 
	 * model
	 */
	public function get_model_method()
	{
		$str = 'function get_' . $this->name . '_dropdown()' . "\n";
		$str .= "\t" . '{' . "\n";
		$str .= "\t\t" . $this->get_values();
		$str .= "\n\t" . '}';

		return $str;
	}

	/* returns the data to put in the codeigniter model method that returns the
	 * associative array of dropdown values */
	private function get_values()
	{
		if ($this->is_lookup_table()) {
			return $this->lookup_table_vals();
		}
		else if ($this->is_enum()) {
			return $this->enum_vals();
		}
		else {
			return $this->empty_method();
		}
	}

	private function lookup_table_vals()
	{
		$str = '$this->db->select(' . "'" . $this->table_id . ', ' 
			. $this->table_col . "'" . ');' . "\n";
		$str .= "\t" . '$this->db->from(' . "'" . $this->table . "'" . ');' 
			. "\n";
		$str .= "\t" . '$query = $this->db->get();' . "\n";
		$str .= "\t" . '$vals = array();' . "\n";
		$str .= "\t" . 'foreach($query->result_array() as $row)' . "\n";
		$str .= "\t\t" . '$vals[$row[' . "'" . $this->table_id . "'" . 
			'] = $row[' . "'" . $this->table_col . "'" . '];' . "\n";
		$str .= "\t" . 'return $vals;'; 

		return $str;
	}

	private function enum_vals()
	{
		$str = '$enums = array(' . "\n";
		foreach($this->enum_array as $val) {
			$str .= "\t\t\t" . "'" . $val . "'" . ' => ' . "'" . $val . "',\n";
		}
		$str = rtrim($str, ",\n");
		$str .= ');' . "\n";
		$str .= "\t\t" . 'return $enums;';

		return $str;
	}

	private function empty_method()
	{
		$str = '// TO-DO' . "\n\t" . 'return null;';
		return $str;
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
	protected $update_form = true; // if true, then the form will populate the
								   // fields with its data, otherwise its an 
	 							   // empty form.

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

	function __clone()
	{	
		$fields = array();

		foreach($this->fields as $f) {
			$fields[] = clone $f;
		}

		$this->fields = $fields;
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

	public function set_name($name)
	{
		$this->name = $name;
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

	public function empty_form()
	{
		$this->update_form = false;
		foreach($this->fields as $field) {
			$field->empty_form();
		}
	}

	public function update_form()
	{
		$this->update_form = true;
		foreach($this->fields as $field) {
			$field->update_form();
		}
	}
}

?>