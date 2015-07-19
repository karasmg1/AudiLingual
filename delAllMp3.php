<?php
foreach (glob("*.mp3") as $filename) {
   //echo "$filename size " . filesize($filename) . "\n";
   unlink($filename);
}
?> 