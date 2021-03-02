<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="../head.js" type="text/javascript">
  </script>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <title>Possible unaswered emails on users mailing list</title>
</head>
<body id="index">
  <header>
    <script src="../menu.js" type="text/javascript"></script>
  </header>
  <div class="container">
  <h3>Possible unanswered emails younger than 1 month</h3>
  <?php passthru('/usr/bin/perl 2>&1 ./unanswered.pl'); ?>
  <p>Threads already marked as
  <a href="https://docs.einsteintoolkit.org/et-docs/Answered_emails">answered</a>
  in the wiki are not shown.</p>
  </div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <script src="../footer/footer.js" type="text/javascript"></script>
      </div>
    </div>
  </div>
</body>
</html>

