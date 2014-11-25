<?php namespace Generator;

class Files
{
	/*
	 * write the $data to file at $filename path
	 * @param $filename full path of file to write 
	 * @param $data the contents of the file
	 */
	public function write($filename, $data)
	{
		// check if the directory we are writing to exists, and if not then 
		// create the directory
		$dir = dirname($filename);
		if (!is_dir($dir)) {
			if (!mkdir($dir)) {
				return false;
			}
		}
		
		return file_put_contents($filename, $data);
	}

	/* reads a file from the path and returns the data */
	public function read($filename)
	{
		$data = file_get_contents($filename);
		return $data;
	}

	/* delete a file at $filepath 
	 * @param $filepath
	 */
	public function delete($filepath)
	{
		return unlink($filepath);
	}
}

?>