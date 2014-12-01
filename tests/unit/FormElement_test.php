<?php namespace Generator;

include_once(dirname(dirname(__DIR__)) . '/Template/FormElement.php');

$name = 'foobar';
$test;
$val = 'foo';

echo "Testing input form element:\n";
echo "Testing creating new input element: ";
try {
	$test = FormElementFactory::create($name, 'input', $val);
}
catch (Exception $e) {
	echo "Failed.\n";
}
echo "OK.\n";
echo "Testing output: ";

// echo "\toutput: " . $test->output() . "\n";
$out = '<?php echo $' . $val . '; ?>';
if ($test->output() !== $out) {
	echo " Failed.\n";
}
else {
 	echo " OK.\n";
}

echo "Testing dropdown form element:\n";
echo "Testing creating new dropdown element: ";
try {
	$test = FormElementFactory::create($name, 'dropdown', $val);
}
catch (Exception $e) {
	echo "Failed.\n";
}
echo "OK.\n";
echo "Testing output: ";
$out = '<?phpforeach($fooas$name=>$val){?><optionvalue="<?phpecho$val;?>"<?phpecho$val==$foo_selected?"selected":null?>><?phpecho$name;?></option><?php}?>';
$actual = preg_replace('/\s+/', '', $test->output());
if ($actual != $out) {
	echo "Failed.\n";
}
else {
 	echo "OK.\n";
}

// Negative test
echo "Negative test: ";
$pass = false;
try {
	$test = FormElementFactory::create($name, '#$#!@$#@%DSD', $val);
}
catch (FormElementException $e) {
	$pass = true;
}
echo $pass ? "OK.\n" : "Failed.\n";


?>