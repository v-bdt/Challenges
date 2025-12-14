<?php

$repertoire = ".";

$contenu = scandir($repertoire);

foreach ($contenu as $element) {
    if ($element !== "." && $element !== "..") {
        echo $element . "<br>";
    }
}

?>