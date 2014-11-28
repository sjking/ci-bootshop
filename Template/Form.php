<?php namespace Generator;

include_once('HTMLElement.php');
include_once('FormElement.php');
include_once(dirname(__DIR__) . '/Model/FormModel.php');


/* Generate an html table */
class Form extends HTMLElement
{	
	// associative array of FormElement objects,
	// ex:
	// 		elements = array(
	//			FormElement{'name' => 'id',
    //						'type' => 'input',
    //						'value' => 'name_id'},
	//			FormElement{'name' => 'status',
	//						'type' => 'dropdown',
	//						'value' => 'status_dropdown'});
	//
	// The above example uses a JSON-like notation to illustrate the structure
	// of the elements property. The values are the FormElement
	// objects for each of those variables. 'value' represents the name of the
	// $php variable used in the controller and views: here we use a convention
	// of concatenating the 'name' and 'type' between an underscore.
	protected $elements;

	/* Instantiate new html form with $fields
	 * The choice of creating a wrapper class for an associative array is to 
	 * enforce the type.
	 * @param $fields array of fields from FormModel
	 */
	function __construct(FormFieldsModel $fields)
	{
		parent::__construct('form');

		$elements = array();
		$this->set_elements($fields);
		$this->fields();
	}

	private function set_elements(FormFieldsModel $fields)
	{
		foreach ($fields->get_fields() as $name => $type) {
			// echo 'name: ' . $name . ', type: ' . $type . "\n";
			$var = $name . '_' . $type;
			$this->elements[] = FormElementFactory::create($name, $type, $var);
		}
	}

	/* generate the form fields */
	protected function fields()
	{
		$fields = '';

		foreach($this->elements as $element) {
			$func = 'form_' . $element->get_type(); // variable function call
			$fields .= $this->$func($element);
		}

		$this->body = $fields;
	}

	/* generate an input form element */
	protected function form_input($e)
	{	
		$input = '<input ';
		$input .= 'name="' . $e->get_name() . '" ';
		$input .= 'id="' . $e->get_name() . '-input" ';
		$input .= 'value="' . $e->output() .'">';

		$label = '<label for="' . $e->get_name() .'" >';
		$label .= $e->get_name() . '</label>';

		return $label . $input;
	}

	/* generate a drop-down form element */
	protected function form_dropdown($e)
	{
		$select = '<select ';
		$select .= 'name="' . $e->get_name() . '" '; 
		$select .= 'id="' . $e->get_name() . '-select">';

		$options = $e->output();

		return $select . $options . '</select>';
	}

	/* output the table */
	public function generate()
	{
		$form = $this->start();
		$form .= $this->body();
		$form .= $this->end();

		return $form;
	}
	
}

?>