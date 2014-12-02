<?php namespace Generator;

include_once('HTMLElement.php');
include_once('FormElement.php');
include_once(dirname(__DIR__) . '/Model/FormModel.php');


/* Generate an html table */
class Form extends HTMLElement
{	
	protected $elements; // array of FormElement template objects
	protected $label_params; // associative array
	protected $submit_btn;
	protected $button_params;

	/* Instantiate new html form with $fields
	 * @param $fields array of FormFieldModel objects
	 */
	// function __construct(array $fields, $params = null)
	function __construct(FormModel $model)
	{
		parent::__construct('form', $model->get_params());

		$this->set_elements($model->get_fields(), $model->get_row());
		if ($model->get_label_params())
			$this->set_label_params($model->get_label_params());
		if ($model->get_button_params())
			$this->set_button_params($model->get_button_params());
		$this->submit_btn = 'Submit';
		$this->fields();
	}

	private function set_elements(array $fields, $row)
	{
		$elements = array();

		foreach ($fields as $field) {
			// $var = $row . "['" . $field->name() . "']";
			// $var = $field->name();
			$this->elements[] = FormElementFactory::create($field);
		}
	}

	private function set_label_params(array $params)
	{
		$this->label_params = $params;
	}

	private function set_button_params(array $params)
	{
		$this->button_params = $params;
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

	/* generate an input form element 
	 * @param $e form element
	 */
	protected function form_input(FormElement $e)
	{	
		$input = '<input ';
		$input .= 'name="' . $e->name() . '" ';
		$input .= 'value="' . $e->output() .'"';
		if ($e->params()) {
			$input .= $this->params_str($e->params());
		}
		$input .= '>';

		$label = $this->form_label($e->name());

		return $label . "\n" . $input;
	}

	/* generate a drop-down form element 
	 * @param $e form element
	 */
	protected function form_dropdown(FormElement $e)
	{
		$select = '<select ';
		$select .= 'name="' . $e->name() . '"'; 
		if ($e->params()) {
			$select .= $this->params_str($e->params());
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
		$form = $this->nest_str($this->submit_btn(), $form);
		$form .= "\n" . $this->end();

		return $form;
	}

	/* set the text of the submit button
	 * @param $text
	 */
	public function set_submit_button($text)
	{
		$this->submit_btn = $text;
	}

	protected function submit_btn()
	{
		$submit = '<button type="submit"'; 
		if ($this->button_params) {
			$submit .= $this->params_str($this->button_params);
		}
		$submit .= '>' . $this->submit_btn . '</button>';
		return $submit;
	}

	/* return a form label 
	 * @param $for should be the same as the elements id
	 * @param $params array of optional params
	 */
	protected function form_label($for, $params = null) 
	{
		$label = '<label for="' . $for .'"';
		
		if ($this->label_params) {
			$label .= $this->params_str($this->label_params);
		}
		$label .= '>' . $for . '</label>';
		
		return $label;
	}
	
}

?>