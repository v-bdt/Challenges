<?php

$fichier = fopen("index.php", "r");

$contenu = fread($fichier, filesize("index.php"));

fclose($fichier);

echo $contenu;

?>
