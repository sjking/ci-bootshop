<?php namespace Generator;
/* Adds buttons to table for edit/delete
 * @author Steve King
 */

include_once('Table.php');

class FilterTable extends Table
{
	
	function __construct($name, $columns, $params = null)
	{
		parent::__construct($name, $columns, $params);
	}

	protected function header()
	{
		$tbl = '<thead id="sorting-header">';
		foreach($this->columns as $col) {
			if ($col instanceof TableColumn)
				$col_name = $col->get_display_name();
			else
				$col_name = $col;
			$anchor = '<a href="<?php echo $sort_link; ?>/' . $col->get_name() . '">' . $col_name . '&nbsp;';
			$sort_class = '$sort[' . "'" . $col->get_name() . "'" . ']';
			$span = '<div class="pull-right"><span class="<?php echo ' . $sort_class . '; ?>"></span></div>';
			$hdr = '<th>';
			$anchor = $anchor . $span . '</a>';//$this->nest_str($span, $anchor) . "\n" . "</a>";
			$hdr = $this->nest_str($anchor, $hdr) . "\n" . '</th>';
			$tbl = $this->nest_str($hdr, $tbl);
		}
		// $hdr = '<th></th>' . "\n" . '<th></th>';
		// $tbl = $this->nest_str($hdr, $tbl);
		$tbl .= "\n" . '</thead>';

		return $tbl;
	}
	
}

?>