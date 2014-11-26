<?php namespace Generator;

/* Generic html element: <content>...</content> */
abstract class HTMLElement
{
	protected $element; // name of element
	protected $body;
	protected $params = null;

	function __construct($element)
	{
		$this->element = $element;
	}

	/* set the body of the element
	 * @param $body
	 */
	public function set_body($body)
	{
		$this->body = $body;
	}

	/* set parameters for the element, such as class, id, etc. 
	 * @param params associative array of parameters and values
	 */
	public function set_params($params)
	{
		$this->params = $params;
	}

	/* return the element opening tag */
	protected function start()
	{
		$element = '<' . $this->element . ' ';

		if ($this->params) {
			foreach($this->params as $param => $val) {
				$element .= $param . '="' . $val . '" ';
			}
		}
		$element = rtrim($element, ' ');
		$element .= '>';

		return $element;
	}

	/* return the closing element tag */
	protected function end()
	{
		$element = '</' . $this->element . '>';
		return $element;
	}

	/* return the content (body) within the element tags */
	protected function body()
	{
		return $this->body;
	}

	/* output the full html element */
	abstract public function generate();

}