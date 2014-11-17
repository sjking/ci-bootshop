<?php namespace Generator;

include "Compiler.php";

class TemplateCompiler extends Compiler 
{
	/*
	 * Uses data as key => value pairs to replace each occurence of key 
	 * wildcard in template with associated value in data array
	 * 
	 * @param $delim delimiter to use if specified (must be escaped for use 
	 * in double-quoted regex strings)
	 */
	function __construct($delim = null)
	{
		$this->delim = ($delim ? $delim : $this->delim);
	}

	/* compile the template 
	 * @param $template
	 * @param $data
	 */
	public function compile($template, $data)
	{
		$delim = $this->delim;

		foreach($data as $pattern => $replacement) {
			$template = 
				preg_replace("/$delim$pattern$delim/i", $replacement, $template);
		}

		return $template;
	}
}

?>