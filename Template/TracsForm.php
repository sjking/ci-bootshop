<?php namespace Generator;

include_once('Form.php');

/* Generate an html table */
class TracsForm extends Form
{	

	function __construct($fields)
	{
		parent::__construct($fields);
	}

	/* generate an input form element, override the Form class to include
	 * bootstrap stuff
	 */
	protected function form_input($name, $type)
	{	$container = '<div class="col-md-10">';
		$input = '<input ';
		$input .= 'name="' . $name . '" id="' . $name . '" ';
		$input .= 'class="form-control" type="text">'; 
		$input = $container . $input . '</div>';

		$label = '<label for="' . $name .'" class="col-md-2 control-label">';
		$label .= $name . '</label>';

		return '<div class="form-group">' . $label . $input . '</div>';
	}
	
}

?>