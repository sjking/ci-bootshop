<?php namespace Generator;

include_once('HTMLElement.php');

/* Generate an html table */
class Table extends HTMLElement
{
	protected $name;
	protected $columns = null; // the column names for the table header

	function __construct($name, $columns, $params = null)
	{
		parent::__construct('table', $params);

		$this->name = $name;
		$this->columns = $columns;
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

	/* output the table */
	public function generate()
	{
		$tbl = $this->start();
		if ($this->columns)
			$tbl .= $this->header();
		$tbl .= $this->body();
		$tbl .= $this->end();

		return $tbl;
	}
	
}

?>