#!/usr/bin/env php
<?php

// USAGE: declare -f | php alf_function_search.php 'search query'
// TODO: Convert this into a bash script?

$functionsBlob = stream_get_contents(STDIN);

preg_match_all('/^[^{]*.*(?:[\r\n][^}].*)*[\r\n]\}/m', $functionsBlob, $matches);

$functions = $matches[0];
$query = $argv[1];

$matchingFunctions = [];

foreach ($functions as $function) {
    if (preg_match("/$query/i", $function)) {
        $matchingFunctions[] = preg_replace("/($query)/i", "\e[0;31m$1\e[0m", $function);
    }
}

if ($matchingFunctions) {
    echo implode("\n", $matchingFunctions) . PHP_EOL;
}
