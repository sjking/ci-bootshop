<?php namespace King\Generator\Template;

include 'Template.php';
include '../Config.php';

class ControllerTemplate extends Template
{
	/* set the name
	 * @param $name
	 */
	public function set_name($name);

	/* get the name
	 */
	public function get_name();

}

?>