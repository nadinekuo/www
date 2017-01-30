<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="head.js" type="text/javascript">
  </script>
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
  <title>Update</title>
</head>
<body id="index">
  <header>
    <script src="menu.js" type="text/javascript"></script>
  </header>
  <div class="container">
<?php
$title='Website Updates Interface';
$hide_path=1;
$category='internal';

?>

<?php
if(isset($_GET['update']))
{
  echo '<h3>Updating the site...</h3>';
  echo '<p>'.exec('/var/www/einstein/update').'</p>';
  echo '<p>The site is now current.</p><br />';
  echo '<p>&lang; <a href="/x/">back to updates interface</a></p>';
}
else
{
  echo '<br /><br />
<input class="button" type="button" value="Make Recent Changes Live" onclick="window.location.href=\'/x/?update\'" />
<br /><br />This updates changes from all relevant repositories to the live site.
</p>';
}
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

