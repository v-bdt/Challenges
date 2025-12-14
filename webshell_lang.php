<?php

$fichier = fopen("fr_lang.php", "r");

$contenu = fread($fichier, filesize("fr_lang.php"));

fclose($fichier);

echo $contenu;

?>
