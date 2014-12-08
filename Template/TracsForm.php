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
			$str .= '<div class="col-md-10">';
		}
		else {
			$str .= '<div class="form-group">';
		}
		$str = $this->nest_str($content, $str) . "\n" .'</div>';
		
		return $str;
	}

	protected function submit_btn()
	{
		$str = '<div class="form-group">';
		$label = $this->form_label();
		$btn = parent::submit_btn();
		$btn = $this->form_group($btn, true);
		$str = $this->nest_str($label, $str);
		$str = $this->nest_str($btn, $str);

		return $str . "\n" . '</div>';
	}
	
}

?>