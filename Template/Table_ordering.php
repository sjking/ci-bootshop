<?php namespace Generator;
/* Adds buttons to table for edit/delete
 * @author Steve King
 */

include_once('Table.php');

class Table_ordering extends Table
{
	
	function __construct($name, $columns, $params = null)
	{
		parent::__construct($name, $columns, $params);
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
		$hdr = '<th></th>' . "\n" . '<th></th>' . "\n" . '<th></th>';
		$tbl = $this->nest_str($hdr, $tbl);
		$tbl .= "\n" . '</thead>';

		return $tbl;
	}
	
}

?>