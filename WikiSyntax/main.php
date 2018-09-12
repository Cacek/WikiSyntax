<?php

require_once("WikiSyntax.php");

$wiki = new WikiSyntax();

$input = file_get_contents("input.wiki");

echo $output = $wiki->parser($input);
$file = 'output.html';
file_put_contents($file, $output);

?>