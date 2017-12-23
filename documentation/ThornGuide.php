<!DOCTYPE html>
<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="../head.js" type="text/javascript">
  </script>
  <title>Thorn Documentation</title>
 <style TYPE="text/css">
  <!--
  .column {
  /* the proper rules ready for future */
  column-gap: 2em;
  column-count: auto;
  column-width: 15em;
  /* Moz/Firefox rules */
  -moz-column-gap: 2em;
  -moz-column-count: auto;
  -moz-column-width: 15em;
  /* Safari & Chrome rules */
  -webkit-column-gap: 2em;
  -webkit-column-count: auto;
  -webkit-column-width: 15em;
  }
  .nobreak {
  /*display: table;*/
  /*display: inline-block;*/
  overflow: hidden; /* fix for Firefox */
  page-break-inside: avoid; /* Firefox */
  break-inside: avoid; /* IE 10+ */
  break-inside: avoid-column;
  -webkit-column-break-inside: avoid;
  }
  -->
  </style>
</head>
<body>
  <header>
    <script src="../menu.js" type="text/javascript">
    </script>
  </header>
  <div class="container">
   <div class="row">
    <h1> Einstein Toolkit Thorn Documentation</h1>
   <div class="column">
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
$arrCount = 0;
$colCount = array(
  "xs" => 6,
  "sm" => 4,
  "md" => 3,
  "lg" => 2, );
foreach (dirContent($docdir) as $arrangement) {
  $arrThornCount = 0;
  foreach (dirContent($docdir.$arrangement) as $thorn) {
    if (file_exists($docdir.$arrangement."/".$thorn."/documentation.html")) {
      if ($arrThornCount == 0) {
        echo "<div class='nobreak'>".$arrangement."<ul>\n";
      }
      $arrThornCount += 1;
      echo " <li><a href=\"../thornguide/".$arrangement."/".$thorn."/documentation.html\">".
           $thorn."</a></li>\n";
    }
  }
  if ($arrThornCount > 0) {
    echo " </ul></div>\n";
  }
}
?>
   </div> <!-- class=column -->

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

