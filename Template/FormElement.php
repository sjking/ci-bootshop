<?php namespace Generator;

/* representation of a form element */
abstract class FormElement
{
	protected $name; // name for form element, seen in name attribute of html element
	protected $type = null; // input, dropdown, hidden
	protected $value; // name of variable to communicate between controller and view

	function __construct($name, $value)
	{
		$this->name = $name;
		$this->value = $value;
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_type()
	{
		return $this->type;
	}

	/* returns a string that represents how the variable will be displayed in
	 * the html page, using php code:
	 * 
	 * ex:
	 *		input elements:
	 *			'<?php echo ' . $this->var . '; ?>'
	 */
	abstract public function output();
}

/* input form element */
class InputFormElement extends FormElement
{
	protected $type = 'input';

	// this would be output in the value="" section of input element
	public function output()
	{
		$out = '<?php echo $' . $this->value . '; ?>';
		return $out;
	}
}

/* dropdown form element. */
class DropdownFormElement extends FormElement
{
	protected $type = 'dropdown';

	// since a dropdown has multiple options, it has multiple values, so we
	// output the php code to generate all the option tags
	public function output()
	{	
		$out = '<?php foreach($' . $this->value . ' as $name => $val) { ?>';
		$out .= '<option value="<?php echo $val; ?>"><?php echo $name; ?></option>';
		$out .= '<?php } ?>';
		return $out;
	}
}

/* factory for creating form elements */
class FormElementFactory
{
	public static function create($name, $type, $value)
	{
		$formElement = 'Generator\\' . ucfirst(strtolower($type)) . 'FormElement';

		if(class_exists($formElement)) {
			return new $formElement($name, $value);
		}
		else {
			throw new FormElementException("invalid form element type '" 
				. $type ."'");
		}
	}
}

class FormElementException extends \Exception {

	public function __toString() {
		return __CLASS__ . ": {$this->message}\n";
	}
}