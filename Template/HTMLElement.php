<?php namespace Generator;

/* Generic html element: <content>...</content> */
abstract class HTMLElement
{
	const NEST_SEP = '  ';
	protected $element; // name of element
	protected $body;
	protected $params = null;

	function __construct($element, $params = null)
	{
		$this->element = $element;
		$this->params = $params;
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

	/* nest each line of $child string to the end of $parent string 
	 * (concatenation), while appending $sep at the beginning of each line of
	 * $child string. This is used to nest html elements. */
	protected function nest_str($child, $parent, $sep = self::NEST_SEP)
	{
		foreach(preg_split("/\n/", $child) as $line){
			$parent .= "\n" . $sep . $line;
		} 
		return $parent;
	}

	/* output the full html element */
	abstract public function generate();

}