<?php namespace Generator;
/* Adds buttons to table for edit/delete
 * @author Steve King
 */

include_once('Table.php');

class TracsTable_sorting extends Table
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
			$anchor = '<a href="<?php echo $sort_link; ?>/' . $col->get_name() . '">' . $col_name . '&nbsp;';
			$span = '<span class="glyphicon glyphicon-sort"></span>';
			$hdr = '<th>';
			$anchor = $this->nest_str($span, $anchor) . "\n" . "</a>";
			$hdr = $this->nest_str($anchor, $hdr) . "\n" . '</th>';
			$tbl = $this->nest_str($hdr, $tbl);
		}
		$hdr = '<th></th>' . "\n" . '<th></th>';
		$tbl = $this->nest_str($hdr, $tbl);
		$tbl .= "\n" . '</thead>';

		return $tbl;
	}
	
}

?>