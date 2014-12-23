<?php namespace Generator;
/* Generate an html table 
 * @author Steve King
 */

include_once('HTMLElement.php');

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

	protected function header()
	{
		$tbl = '<thead>';
		foreach($this->columns as $col) {
			if ($col instanceof TableColumn)
				$col_name = $col->get_display_name();
			else
				$col_name = $col;
			$hdr = '<th>' . $col_name . '</th>';
			$tbl = $this->nest_str($hdr, $tbl);
		}
		$hdr = '<th></th>' . "\n" . '<th></th>';
		$tbl = $this->nest_str($hdr, $tbl);
		$tbl .= "\n" . '</thead>';

		return $tbl;
	}

	/* output the table */
	public function generate()
	{
		$tbl = $this->start();
		if ($this->columns)
			$tbl = $this->nest_str($this->header(), $tbl);
		$tbl = $this->nest_str($this->body(), $tbl);
		$tbl .= "\n" . $this->end();

		return $tbl;
	}
	
}

?>