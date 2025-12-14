<?php
$dir    = '.';
$files1 = scandir($dir);
$files2 = scandir($dir, SCANDIR_SORT_DESCENDING);
$files3 = scandir($dir, SCANDIR_SORT_DESCENDING);
$files4 = scandir($dir, SCANDIR_SORT_DESCENDING);
$files5 = scandir($dir, SCANDIR_SORT_DESCENDING);
$files6 = scandir($dir, SCANDIR_SORT_DESCENDING);
$files7 = scandir($dir, SCANDIR_SORT_DESCENDING);
$files8 = scandir($dir, SCANDIR_SORT_DESCENDING);
$files9 = scandir($dir, SCANDIR_SORT_DESCENDING);
$files10 = scandir($dir, SCANDIR_SORT_DESCENDING);

print_r($files1);
print_r($files2);
print_r($files3);
print_r($files4);
print_r($files5);
print_r($files6);
print_r($files7);
print_r($files8);
print_r($files9);
print_r($files10);

?>
