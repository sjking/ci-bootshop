<?php namespace Generator;
/* Adds bootstrap styling to a form
 * @author Steve King
 */

include_once('BootstrapForm.php');

class FilterTableFormInline extends BootstrapForm
{	
	protected $clear_btn;
	protected $container_params;

	public function set_clear_button($text)
	{
		$this->clear_btn = $text;
	}

	public function set_container_params(array $params)
	{
		$this->container_params = $params;
	}

	protected function submit_btn()
	{
		$str = '<div class="form-group">';
		$label = $this->form_label();
		// $btn = parent::submit_btn();
		$btn = $this->submit_buttons();
		$btn = $this->form_group($btn, true);
		$str = $this->nest_str($label, $str);
		$str = $this->nest_str($btn, $str);

		return $str . "\n" . '</div>';
	}

	public function generate()
	{
		$form = '<div';
		if ($this->container_params) {
			$form .= $this->params_str($this->container_params);
		}
		$form .= '>';

		$form = $this->nest_str(parent::generate(), $form);
		$form .= "\n" . '</div>';

		return $form;
	}

	private function submit_buttons()
	{
		$filter_submit = '<button type="submit" name="filter-submit" value="submit"';
		if ($this->button_params) {
			$filter_submit .= $this->params_str($this->button_params);
		}
		$filter_submit .= '>' . $this->submit_btn . '</button>' . "\n";

		$filter_clear = '<button type="submit" name="filter-submit" value="clear"';
		if ($this->button_params) {
			$filter_clear .= $this->params_str($this->button_params);
		}
		$filter_clear .= '>' . $this->clear_btn . '</button>';

		return $filter_submit . $filter_clear;
	}

	protected function form_group($content, $type = null)
	{
		$str = '';

		if (!$type) {
			$str .= '<div class="form-group">';
			$str = $this->nest_str($content, $str) . "\n" .'</div>';
		}
		else {
			$str = $content;
		}
		
		return $str;
	}
	
}

?>