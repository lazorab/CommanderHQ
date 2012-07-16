<?php
  header('Content-Type: text/cache-manifest');
  echo "CACHE MANIFEST\n";

  $hashes = "";

    //images:
    $Directory = new RecursiveDirectoryIterator('/home/bemobile/public_html/content/images/53');
    $Iterator = new RecursiveIteratorIterator($Directory);
    foreach ($Iterator as $file) {
        if ($file->IsFile())
        {
            echo $file."\n";
            $hashes .= md5_file($file);
        }
    }
    
    //videos:
    
  //local files:
    
  $dir = new RecursiveDirectoryIterator(".");
  foreach (new RecursiveIteratorIterator($dir) as $file) {
      if ($file->IsFile() &&
          $file != "manifest.php" &&
          (substr($file->getFilename(), -3, 3) == ".js" || substr($file->getFilename(), -4, 4) == ".css"))
      {
          echo $file."\n";
          $hashes .= md5_file($file);
      }
  }
     
  echo "# Hash: ".md5($hashes)."\n";
?>