<?php namespace Generator;

/* Generate an html table */
class Table
{
	protected $name;
	protected $columns; // the column names for the table header
	protected $body;

	function __construct($name, $columns)
	{
		$this->name = $name;
		$this->columns = $columns;
	}

	/* set the body of the table
	 * @param $body
	 */
	function set_body($body)
	{
		$this->body = $body;
	}

	/* return the table opening tag with  */
	private function start()
	{
		$tbl = '<table name="' . $this->name . '">';

		return $tbl;
	}

	private function end()
	{
		$tbl = '</table>';

		return $tbl;
	}

	private function header()
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