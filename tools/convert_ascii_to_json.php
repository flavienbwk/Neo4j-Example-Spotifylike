<?php

if (isset($argv[1])) {
   $subject = $argv[1];

   if (file_exists($subject)) {
      $directory_json = "FICHIERS_JSON";

      if (!is_dir($directory_json)) {
	mkdir($directory_json);
      }
      $subject = file_get_contents($subject);

      if (strlen($subject)) {
      	 $step = preg_replace("/(\')((\w|&| |-)+)(\')/", "\"$2\"", $subject);
	 $step = preg_replace("/((\w|\.| |[0-9]|\'|\(|\))+) : ((\w|\.| |[0-9]|\'|\(|\))+)/", "\"$1\" : \"$3\",", $step);
	 $step = preg_replace("/((\w|\.| |\'|\(|\))+) : /", "\"$1\" : ", $step);
	 $step = preg_replace("/\]((,)?){1,}/", "],", $step);

	 if (substr($step, -2, 1) == ",") {
	    $step = substr($step, 0, -2);
	 }
	 $step = "{".$step."}";

	 echo $step;
      }
      else {
      	   echo "Empty file.";
      }
   }
   else {
   	echo "Invalid file.\n";
   }
}
else {
     echo "Please provide the path.\n";
}