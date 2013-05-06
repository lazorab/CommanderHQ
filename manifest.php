<?php
  header('Content-Type: text/cache-manifest');
  echo "CACHE MANIFEST\n";

  $hashes = "";

  $dir = new RecursiveDirectoryIterator(".");
  foreach (new RecursiveIteratorIterator($dir) as $file) {
      if ($file->IsFile() &&
            $file != "./manifest.php" &&
            $file != "./PopulateBenchmarks.php" &&
            $file != "./PopulateExercises.php" &&
            $file != "./PopulateSkills.php" &&
            $file != "./gplus_login.php" &&
            $file != "./login-twitter.php" &&
            $file != "./login-facebook.php" &&
            $file != "./getTwitterData.php" &&
            $file->getFilename() != "error_log" &&
          substr($file->getFilename(), 0, 1) != ".")
      {
          echo $file."\n";
          $hashes .= md5_file($file);
      }
  }
  
echo "  
 # Resources that require the user to be online.\n
NETWORK:\n
http://code.jquery.com\n
http://d3js.org\n
http://www.be-mobile.co.za\n";
    
  echo "# Hash: ".md5($hashes)."\n";
?>