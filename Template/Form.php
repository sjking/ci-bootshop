<?php namespace Generator;

include_once('HTMLElement.php');
include_once('FormElement.php');
include_once(dirname(__DIR__) . '/Model/FormModel.php');


/* Generate an html table */
class Form extends HTMLElement
{	
	protected $elements; // array of FormElement template objects

	/* Instantiate new html form with $fields
	 * @param $fields array of FormFieldModel objects
	 */
	function __construct(array $fields, $params = null)
	{
		parent::__construct('form', $params);

		$this->set_elements($fields);
		$this->fields();
	}

	private function set_elements(array $fields)
	{
		$elements = array();

		foreach ($fields as $field) {
			$var = $field->name() . '_' . $field->type();
			$this->elements[] = FormElementFactory::create($field->name(), 
				$field->type(), $var, $field->params());
		}
	}

	/* generate the form fields */
	protected function fields()
	{
		$fields = '';

		foreach($this->elements as $element) {
			$func = 'form_' . $element->type(); // variable function call
			$fields .= $this->$func($element) . "\n";
		}
		$fields = rtrim($fields, "\n");

		$this->body = $fields;
	}

	/* generate an input form element */
	protected function form_input(FormElement $e)
	{	
		$input = '<input ';
		$input .= 'name="' . $e->name() . '" ';
		$input .= 'value="' . $e->output() .'"';
		if ($e->params()) {
			foreach($e->params() as $param => $val) {
				$input .= ' ' . $param . '"' . $val . '"';
			}
		}
		$input .= '>';

		$label = $this->form_label($e->name());

		return $label . "\n" . $input;
	}

	/* generate a drop-down form element */
	protected function form_dropdown(FormElement $e)
	{
		$select = '<select ';
		$select .= 'name="' . $e->name() . '"'; 
		if ($e->params()) {
			foreach($e->params() as $param => $val) {
				$select .= ' ' . $param . '"' . $val . '"';
			}
		}
		$select .= '>';

		$label = $this->form_label($e->name());
		$options = $e->output();
		$select = $this->nest_str($options, $select);
		
		return $label . "\n" . $select . "\n" . '</select>';
	}

	/* output the table */
	public function generate()
	{
		$form = $this->start();
		$form = $this->nest_str($this->body(), $form);
		$form .= "\n" . $this->end();

		return $form;
	}

	/* return a form control label 
	 * @param $for should be the same as the elements id
	 * @param $params array of optional params
	 */
	protected function form_label($for, $params = null) 
	{
		$label = '<label for="' . $for .'"';
		
		if ($params) {
			foreach($params as $param => $val) {
				$label .= ' ' . $param . '"' . $val . '"';
			}
		}
		$label .= '>' . $for . '</label>';
		
		return $label;
	}
	
}

?>