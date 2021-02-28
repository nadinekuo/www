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

$thdocdir = "../../documentation/ThornDoc/";
$ardocdir = "../../documentation/ArrangementDoc/";
$colCount = array(
  "xs" => 6,
  "sm" => 4,
  "md" => 3,
  "lg" => 2, );
$arrangements = array_unique(array_merge(dirContent($thdocdir), dirContent($ardocdir)));
asort($arrangements);
foreach ($arrangements as $arrangement) {
  # if there is an arrangement doc. output a link to it as the header,
  # if there is none, wait until we actually see a thorndoc
  $arrHeader = false;
  if (file_exists($ardocdir.$arrangement."/documentation.html")) {
    echo "<div class='nobreak'>\n";
    echo "<a href=\"../arrangementguide/".$arrangement."/documentation.html\">".
         $arrangement."</a>\n";
    echo "<ul>\n";
    $arrHeader = true;
  }

  $arrThornCount = 0;
  foreach (dirContent($thdocdir.$arrangement) as $thorn) {
    if (file_exists($thdocdir.$arrangement."/".$thorn."/documentation.html")) {
      if ($arrThornCount == 0) {
        if (!$arrHeader) {
          echo "<div class='nobreak'>\n";
          echo "$arrangement\n";
          echo "<ul>\n";
          $arrHeader = true;
        }
      }
      $arrThornCount += 1;
      echo " <li><a href=\"../thornguide/".$arrangement."/".$thorn."/documentation.html\">".
           $thorn."</a></li>\n";
    }
  }

  if ($arrHeader) {
    echo " </ul>\n";
    echo " </div>\n";
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

