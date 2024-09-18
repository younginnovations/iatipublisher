<?php


$childInfo = [
    'child1' => 38,
    'child2' => 25
];

$parentLength = 65;
$errorLines = [7, 8, 16];

$mappedErrors = mapErrorLinesToChildren($childInfo, $errorLines);

print_r($mappedErrors);

?>
