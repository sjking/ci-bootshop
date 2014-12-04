<?php namespace Generator;

include_once('Form.php');

/* Generate an html table */
class TracsForm extends Form
{	
	/* override the form fields output */
	protected function fields()
	{
		$fields = '';

		foreach($this->elements as $element) {
			$func = 'form_' . $element->type(); // variable function call
			// enclose in a form-group div
			$fields .= $this->form_group($this->$func($element)) . "\n";
		}
		$fields = rtrim($fields, "\n");

		$this->body = $fields;
	}

	protected function form_group($content, $type = null)
	{
		$str = '';

		if ($type) {
			$str = '<div class="col-md-10">' . $content . '</div>';
		}
		else {
			$str = '<div class="form-group">' . $content . '</div>';
		}
		
		return $str;
	}
	
}

?>