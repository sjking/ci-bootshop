<?php namespace King\Generator;

use King\Generator\Compiler\TemplateCompiler;
include 'Compiler/TemplateCompiler.php';

$data = array('QUICK' => 'quick', 'lazy' => 'lazy', 'panama_Canal' => 'Panama');

$template = file_get_contents('./test.txt', true);
echo 'Original Template:';
echo "\n";
echo $template;
echo "\n";

$compiler = new TemplateCompiler();
$template = $compiler->compile($template, $data);

echo 'Modified Template:\n';
echo "\n";
echo $template;
echo "\n";

?>