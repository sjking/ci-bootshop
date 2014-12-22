<?php namespace Generator;
/* Adds buttons to table for edit/delete
 * @author Steve King
 */

include_once('Table.php');

class TracsTable extends Table
{
	
	function __construct($name, $columns, $params = null)
	{
		parent::__construct($name, $columns, $params);
	}

	/* overide header function so we can add buttons for tracs edit/delete */
	protected function header()
	{
		$tbl = '<thead>';
		foreach($this->columns as $col) {
			$tbl .= '<th>' . $col . '</th>';
		}

		// buttons
		$buttons = '';
		$buttons .= '<th class="center">Edit</th>';
		$buttons .= '<th class="center">Delete</th>';

		$tbl .= $buttons . '</thead>';

		return $tbl;
	}
	
}

?>