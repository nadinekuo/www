<?php header("Content-Type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <script src="head.js" type="text/javascript">
  </script>
  <title>Sending registration...</title>
</head>
<body>
  <header>
    <script src="menu.js" type="text/javascript">
    </script>
  </header>
  <div class="container">
   <div class="row">
   <div class="col-sm-10 col-sm-offset-1">

<?php
/* All form fields are automatically passed to the PHP script through the array $HTTP_POST_VARS. */
$name = htmlentities($_POST['name'], ENT_QUOTES, "UTF-8");
$email = $_POST['email'];
$github = $_POST['github'];
$buechsenwursttest = $_POST['buechsenwursttest'];

$message  = "Einstein Toolkit maintainers\n";
$message .= "\n";
$message .= "$name has submitted a request for a tutorial server account.\n";
$message .= "email: $email\n";
$message .= "github user name: $github\n";

/* PHP form validation: the script checks that the Email field contains a valid
email address and the Subject field isn't empty. preg_match performs a regular
expression match. It's a very powerful PHP function to validate form fields and
other strings - see PHP manual for details. */
if (empty($name)) {
  echo '<h4>Please fill in your name.</h4>';
  echo '<br /><a href="javascript:history.back(1);">Try again</a>';
} elseif (!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $email)) {
  echo '<h4>Please provide a valid email address.</h4>';
  echo '<br />Please <a href="javascript:history.back(1);">try again</a>';
} elseif (empty($email)) {
  echo '<h4>Please provide a valid email address.</h4>';
  echo '<br /><a href="javascript:history.back(1);">Try again</a>';
} elseif (empty($buechsenwursttest) || ($buechsenwursttest != "Einstein")) {
  echo '<h4>You did not spell \'Einstein\' correctly. Go away, spam bot, or </h4>';
  echo '<br /><a href="javascript:history.back(1);">try again</a>';
} elseif (mail('maintainers@einsteintoolkit.org',
	       'New Einstein Toolkit tutorial account request received',
	       $message,'From: RegistrationBot@einsteintoolkit.org')) {
/* Sends the mail and outputs the "Thank you" string if the mail is successfully sent, or the error string otherwise. */
  echo '<h4>Your account request has been successfully submitted.</h4>';
  echo '<br />Thank you for trying out the Einstein Toolkit.';
  echo '<br />Please allow for one business day for your account to be created.';
  echo '<br /><a href="/">Home</a>';
} else {
  echo '<h4>Unfortunately, there was a problem registering.</h4>';
  echo 'Go back to <a href="javascript:history.back(1);">try again</a>?';
}
?>

</div></div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <script src="footer/footer.js" type="text/javascript">
        </script>
      </div>
    </div>
  </div>
</body>
</html>

