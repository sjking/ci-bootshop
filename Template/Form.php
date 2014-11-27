<?php namespace Generator;

include_once('HTMLElement.php');

/* Generate an html table */
class Form extends HTMLElement
{	
	// fields is associative array of fieldnames and form input element
	//   ex: {'firstName' => 'input', 'status' => 'dropdown', 
	//        'personId' => 'hidden'}
	protected $fields; 

	function __construct($fields)
	{
		parent::__construct('form');

		$this->fields = $fields;
	}

	/* generate the form fields */
	private function fields()
	{
		$fields = '';

		foreach($this->fields as $name => $type) {
			switch($type) {
				case 'input':
					$fields .= $this->form_input($name, $type);
					break;
				case 'dropdown':
					// $fields .= form_dropdown($name, $type);
					break;
				case 'hidden':
					// $fields .= form_hidden($name, $type);
					break;
				default:
					throw new Exception('Generator Error: Form element "' . 
						$type . '" is not recognized.');
			}
		}

		return $fields;
	}

	/* generate an input form element */
	private function form_input($name, $type)
	{	
		$input = '<input ';
		$input .= 'name="' . $name . '" id="' . $name . '">';

		$label = '<label for="' . $name .'" >' . $name . '</label>';

		return $label . $input;
	}

	/* output the table */
	public function generate()
	{
		$form = $this->start();
		$form .= $this->fields();
		$form .= $this->end();

		return $form;
	}
	
}

?>