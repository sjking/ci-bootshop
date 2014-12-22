<?php namespace Generator;
/* data model for an html table
 * @author Steve King
 */

include_once('Model.php');

class TableModel extends Model
{
	/* create new table model
	 * @param $name
	 * @param $table 
	 * @param $cols array of TableColumn objects
	 * @param $id
	 * @param $params
	 */
	function __construct($name, $table, array $cols, $id, $params = null)
	{
		$this->name = $name;
		$this->columns = array();
		foreach($cols as $col) {
			if ($col instanceof TableColumn) {
				$this->columns[] = $col;
			}
			else {
				throw new \Exception('TableModel: column must be instance of TableColumn');
			}
		}
		$this->table = $table;
		$this->id = $id;
		$this->params = $params;
	}

}

class TableColumn
{
	protected $name;
	protected $display_name = null;
	protected $params;

	function __construct($name, array $params)
	{
		$this->name = $name;
		$this->params = $params;
	}

	public function set_display_name($display_name)
	{
		$this->display_name = $display_name;
	}

	public function get_display_name()
	{
		return $this->display_name;
	}

	public function get_name()
	{
		return $this->name;
	}

	public function get_params()
	{
		return $this->params;
	}
}