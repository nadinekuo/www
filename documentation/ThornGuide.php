<!DOCTYPE html>
<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="../head.js" type="text/javascript">
  </script>
  <title>Thorn Documentation</title>
</head>
<body>
  <header>
    <script src="../menu.js" type="text/javascript">
    </script>
  </header>
  <div class="container">
   <div class="row">
   <div class="col-xs-12">
    <h1> Einstein Toolkit Thorn Documentation</h1>
   </div>
<?php
function dirContent($dir) {
  $dd = opendir($dir);
  $content = array();
  while ($entry = readdir($dd)) {
    if ($entry != "." and $entry != "..") {
      $content[] = $entry;
    }
  }
  asort($content);
  closedir($dd);
  return $content;
}

$docdir = "../../documentation/ThornDoc/";
foreach (dirContent($docdir) as $arrangement) {
  $arrCount = 0;
  foreach (dirContent($docdir.$arrangement) as $thorn) {
    if (file_exists($docdir.$arrangement."/".$thorn."/documentation.html")) {
      if ($arrCount == 0) {
        echo " <div class=\"col-xs-6 col-sm-4 col-md-3 col-lg-2\">".$arrangement."<ul>\n";
      }
      $arrCount += 1;
      echo " <li><a href=\"../thornguide/".$arrangement."/".$thorn."/documentation.html\">".
           $thorn."</a>\n";
    }
  }
  if ($arrCount > 0) {
    echo " </div>\n";
  }
}
?>

</div></div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <script src="../footer/footer.js" type="text/javascript">
        </script>
      </div>
    </div>
  </div>
</body>
</html>

