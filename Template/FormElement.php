<?php namespace Generator;

/* Representation of a form element in an html view, focussing on the php code
 * that is used to get dynamic data from the controller
 */
abstract class FormElement
{
	protected $name; // name for form element, seen in name attribute of html element
	protected $type = null; // input, dropdown, hidden
	protected $value; // name of variable to communicate between controller and view
	protected $params; // associative array

	/* create a form element that keeps the state of the element for displaying
	 * in the view
	 * @param $name 
	 * @param $value
	 * @params $params
	 */
	function __construct($name, $value, array $params = null)
	{
		$this->name = $name;
		$this->value = $value;
		$this->params = $params;
		$this->_init();
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

	/* initialize the form element data */
	abstract protected function _init();

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

	protected function _init(){} // nothing to do
}

/* dropdown form element. */
class DropdownFormElement extends FormElement
{
	protected $type = 'dropdown';
	private $selected;

	// since a dropdown has multiple options, it has multiple values, so we
	// output the php code to generate all the option tags
	public function output()
	{	
		$out = '<?php foreach($' . $this->value . ' as $name => $val) { ?>';
		$out .= "\n  ";
		$out .= '<option value="<?php echo $val; ?>"';
		$out .= ' <?php echo $val == $' . $this->selected . ' ? "selected" : null ?>>';
		$out .= '<?php echo $name; ?></option>';
		$out .= "\n";
		$out .= '<?php } ?>';
		
		return $out;
	}

	/* return the variable name used in controller and view to access/set the
	 * value of the selected form option */
	public function selected()
	{
		return $this->selected;
	}

	protected function _init()
	{
		$this->selected = $this->value . '_selected';
	}
}

/* factory for creating form elements */
class FormElementFactory
{
	public static function create($name, $type, $value, $params)
	{
		$formElement = 'Generator\\' . ucfirst(strtolower($type)) . 'FormElement';

		if(class_exists($formElement)) {
			return new $formElement($name, $value, $params);
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