<?php namespace Generator;

include_once(dirname(__DIR__) . '/Model/FormModel.php');

/* Representation of a form element in an html view, focussing on the php code
 * that is used to get dynamic data from the controller
 */
abstract class FormElement
{
	protected $model; // FormFieldModel instance

	/* create a form element that keeps the state of the element for displaying
	 * in the view
	 * @param $model
	 */
	function __construct(FormFieldModel $model)
	{
		$this->model = $model;
	}

	public function name()
	{
		return $this->model->name();
	}

	public function type()
	{
		return $this->model->type();
	}

	public function params()
	{
		return $this->model->params();
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
	// this would be output in the value="" section of input element
	public function output()
	{
		$val = $this->model->variable_name();
		$out = '';
		if ($val) // true if its edit form, false if its create form
			$out = '<?php echo $$DETAIL_ROW$[' . "'" . $val . "']" . '; ?>';
		return $out;
	}

}

/* dropdown form element. */
class DropdownFormElement extends FormElement
{
	// since a dropdown has multiple options, it has multiple values, so we
	// output the php code to generate all the option tags
	public function output()
	{	
		$dropdown = $this->model->get_controller_array_variable();
		$selected = $this->model->variable_name();

		$out = '<?php foreach($' . $dropdown . ' as $name => $val) { ?>';
		$out .= "\n  ";
		$out .= '<option value="<?php echo $val; ?>"';
		if ($selected) // true if its edit form, false if its create form
			$out .= ' <?php echo $val == $$DETAIL_ROW$[' . "'" . $selected . "']" . ' ? "selected" : null; ?>';
		$out .= '>';
		$out .= '<?php echo $name; ?></option>';
		$out .= "\n";
		$out .= '<?php } ?>';
		
		return $out;
	}

}

class TextareaFormElement extends FormElement
{
	public function output()
	{
		$val = $this->model->variable_name();
		$out = '';
		if ($val) // true if its edit form, false if its create form
			$out = '<?php echo $$DETAIL_ROW$[' . "'" . $val . "']" . '; ?>';
		return $out;
	}
}

/* radio form element for selecting one from many choices */
class RadioFormElement extends FormElement
{
	private $params_str = null;

	public function output()
	{
		$options = $this->model->get_controller_array_variable();
		$selected = $this->model->variable_name();

		$out = '<?php foreach($' . $options . ' as $name => $val) { ?>';
		$out .= "\n  ";
		$out .= '<div class="radio">';
		$out .= "\n    ";
		$out .= '<label>';
		$out .= "\n      ";
		$out .= '<input type=' . "'radio' " . 'name="' . $this->name() . '" ';
		$out .= 'value="<?php echo $val; ?>"';
		if ($this->params_str) {
			$out .= $this->params_str;
		}
		if ($selected) // true if its edit form, false if its create form
			$out .= ' <?php echo $val == $$DETAIL_ROW$[' . "'" . $selected . "']" . ' ? "checked" : null; ?>';
		$out .= '>';
		$out .= "\n      ";
		$out .= '<?php echo $name; ?>';
		$out .= "\n    ";
		$out .= '</label>';
		$out .= "\n  ";
		$out .= '</div>';
		$out .= "\n";
		$out .= '<?php } ?>';

		return $out;
	}

	public function set_params_str($str)
	{
		$this->params_str = $str;
	}
}

class CheckboxFormElement extends FormElement 
{
	public function output()
	{
		$checked = $this->model->get_checked_value();
		$default = $this->model->get_default_value();
		$selected = $this->model->variable_name();

		$hidden = '<input type=' . "'hidden' ";
		$hidden .= 'name="' . $this->name() . '" ';
		$hidden .= 'value="' . $default .'"' . '>';

		$check = '<input type=' . "'checkbox' ";
		$check .= 'name="' . $this->name() . '" ';
		$check .= 'value="' . $checked .'"';
		if ($selected)
			$check .= ' <?php echo $$DETAIL_ROW$[' . "'" . $selected . "']" . '== "' . $checked . '" ? "checked" : null; ?>';

		return $hidden . "\n" . $check;
	}
}

/* checkbox form element for selecting

/* factory for creating form elements */
class FormElementFactory
{
	/* create a new form element
	 * @param $model
	 */
	public static function create(FormFieldModel $model)
	{
		$formElement = 'Generator\\' . ucfirst(strtolower($model->type())) . 'FormElement';

		if(class_exists($formElement)) {
			return new $formElement($model);
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