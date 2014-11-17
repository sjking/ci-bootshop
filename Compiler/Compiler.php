<?php namespace Generator;

abstract class Compiler 
{
	/* delimeter used at beginning and end of wildcard strings */
	protected $delim = "\\$";

	/**
	 * Compile the template using
	 * the given data
	 *
	 * @param $template
	 * @param $data
	 */
	abstract public function compile($template, $data);
} 

?>