<?php namespace Generator;
/* Generate an HTML form
 * @author Steve King
 */

include_once('HTMLElement.php');
include_once('FormElement.php');
include_once(dirname(__DIR__) . '/Model/FormModel.php');

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

	protected function set_elements(array $fields, $row)
	{
		$elements = array();

		foreach ($fields as $field) {
			// $var = $row . "['" . $field->name() . "']";
			// $var = $field->name();
			$this->elements[] = FormElementFactory::create($field);
		}
	}

	protected function set_label_params(array $params)
	{
		$this->label_params = $params;
	}

	protected function set_button_params(array $params)
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

	protected function form_group($content, $type = null)
	{
		return $content;
	}

	/* generate an input form element 
	 * @param $e form element
	 */
	protected function form_input(FormElement $e)
	{	
		$input = '<input type=' . "'text' ";
		$input .= 'name="' . $e->name() . '" ';
		$input .= 'value="' . $e->output() .'"';
		if ($e->params()) {
			$input .= $this->params_str($e->params());
		}
		$input .= '>';

		$label = $this->form_label($e->label_name());

		return $label . "\n" . $this->form_group($input, $e->type());
	}

	/* generate a radio form element
	 * @param $e form element
	 */
	protected function form_radio(FormElement $e)
	{
		// TO-DO: Refactor, this is weird coupling
		$e->set_params_str($this->params_str($e->params()));

		$label = $this->form_label($e->label_name());
		$output = $e->output();

		return $label . "\n" . $this->form_group($output, $e->type());
	}

	/* generate a drop-down form element 
	 * @param $e form element
	 */
	protected function form_dropdown(FormElement $e)
	{
		$select = '<select ';
		$select .= 'name="' . $e->name() . '"'; 
		if ($e->params()) {
			$select .= $this->params_str($e->params(), $e->type());
		}
		$select .= '>';

		$label = $this->form_label($e->label_name());
		$options = $e->output();
		$select = $this->nest_str($options, $select);
		
		return $label . "\n" . $this->form_group($select . "\n" . '</select>', $e->type());
	}

	/* generate a textarea drop-down form element
	 * @param $e form element
	 */
	protected function form_textarea(FormElement $e)
	{
		$txt = '<textarea ';
		$txt .= 'name="' . $e->name() . '"'; 
		if ($e->params()) {
			$txt .= $this->params_str($e->params());
		}
		$txt .= '>';

		$label = $this->form_label($e->label_name());
		$text = $e->output();
		$txt = $this->nest_str($text, $txt);

		return $label . "\n" . $this->form_group($txt . "\n" . '</textarea>', $e->type());
	}

	/* generate checkbox form element
	 * @param $e form element
	 */
	protected function form_checkbox(FormElement $e)
	{
		$check = $e->output();
		if ($e->params()) {
			$check .= $this->params_str($e->params());
		}
		$check .= '>';
		$check = $this->nest_str($check, '<label>');
		$check .= $e->label_name() . "\n" . '</label>';

		$div = '<div class="checkbox">';

		$check = $this->nest_str($check, $div);
		$check .= "\n" . '</div>';

		$label = $this->form_label();

		return $label . "\n" . $this->form_group($check, $e->type());
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
	 */
	protected function form_label($for = null) 
	{
		$label = '<label';
		if ($for)
			$label .= ' for="' . $for .'"';
		
		if ($this->label_params) {
			$label .= $this->params_str($this->label_params);
		}
		$label .= '>' . $for . '</label>';
		
		return $label;
	}
	
}

?>