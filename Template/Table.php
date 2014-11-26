<?php namespace Generator;

/* Generate an html table */
class Table
{
	protected $name;
	protected $columns; // the column names for the table header
	protected $body;
	private $params = null;

	function __construct($name, $columns)
	{
		$this->name = $name;
		$this->columns = $columns;
	}

	/* set the body of the table
	 * @param $body
	 */
	public function set_body($body)
	{
		$this->body = $body;
	}

	/* set parameters for the table, such as class, 
	 * @param params associative array of parameters and values
	 */
	public function set_params($params)
	{
		$this->params = $params;
	}

	/* return the table opening tag with  */
	private function start()
	{
		$tbl = '<table ';

		if ($this->params) {
			foreach($this->params as $param => $val) {
				$tbl .= $param . '="' . $val . '" ';
			}
		}
		$tbl = rtrim($tbl, ' ');
		$tbl .= '>';

		return $tbl;
	}

	private function end()
	{
		$tbl = '</table>';

		return $tbl;
	}

	protected function header()
	{
		$tbl = '<thead>';
		foreach($this->columns as $col) {
			$tbl .= '<th>' . $col . '</th>';
		}
		$tbl .= '</thead>';

		return $tbl;
	}

	private function body()
	{
		return $this->body;
	}

	/* output the table */
	public function generate()
	{
		$tbl = $this->start();
		$tbl .= $this->header();
		$tbl .= $this->body();
		$tbl .= $this->end();

		return $tbl;
	}
	
}

?>