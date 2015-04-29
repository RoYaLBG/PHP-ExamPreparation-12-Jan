<?php

$numbers = <<<KUF
Angel$(*^#029661234!@#Pesho ,.' +3592/9653241;'":{},.
Ivan 0888 123 456 John-=_555.123.4567	Stoian!@#$#@	Gosho )=_*	Steven #$(*&+1-(800)-555-2468
KUF;

$pattern = '/(\b[A-Z][a-zA-Z]*)[^a-zA-Z0-9\+]*?(\+?[0-9]+[0-9()\/\-.\s]*[0-9]+)/';

preg_match_all($pattern, $numbers, $matches);

if (empty($matches[0])) {
    echo "<p>No matches!</p>";
} else {
    echo "<ol>";
    foreach ($matches[2] as $k => $phone) {
        $name = htmlspecialchars(trim($matches[1][$k]));
        $phone = preg_replace("/[^+0-9]*/", "", $phone);
        echo "<li><b>{$name}:</b> $phone</li>";
    }
    echo "</ol>";
}




