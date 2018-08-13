<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="head.js" type="text/javascript">
  </script>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <title>Possible unaswered emails on users mailing list</title>
</head>
<body id="index">
  <header>
    <script src="menu.js" type="text/javascript"></script>
  </header>
  <div class="container">
<?php
$title='Possible unaswered emails on users mailing list';
$hide_path=1;
$category='internal';

echo '<h3>Possible unanswered emails</h3>';
passthru('pwd');
passthru('./unanswered.pl');
?>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <script src="footer/footer.js" type="text/javascript"></script>
      </div>
    </div>
  </div>
</body>
</html>

