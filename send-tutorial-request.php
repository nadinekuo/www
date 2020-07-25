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
$institution = $_POST['institution'];
$buechsenwursttest = $_POST['buechsenwursttest'];

$message = "Einstein Toolkit maintainers:\n\nNew Tutorial Request:\nName: ".$name."\n".
"Email: ".$email."\n".
"Organization: ".$institution."\n".
"\n\n".
"The above user has requested a tutorial account.\n\n".
"Thanks,\n".
"Einstein Toolkit Registration Bot\n";

/* PHP form validation: the script checks that the Email field contains a valid email address and the Subject field isn't empty. preg_match performs a regular expression match. It's a very powerful PHP function to validate form fields and other strings - see PHP manual for details. */
if (empty($name)) {
  echo '<h4>Please fill in your name.</h4>';
  echo '<br /><a href="javascript:history.back(1);">Try again</a>';
} elseif (!preg_match("/\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $email)) {
  echo '<h4>Please provide a valid email address.</h4>';
  echo '<br />Please <a href="javascript:history.back(1);">try again</a>';
} elseif (!empty($institution) && ($name == $institution)) {
  echo '<h4>You provided the same for name and institution. Go away, spam bot, or </h4>';
  echo '<br /><a href="javascript:history.back(1);">try again</a>';
} elseif (empty($buechsenwursttest) || ($buechsenwursttest != "nietsniE")) {
  echo '<h4>You did not spell \'Einstein\' backwards correctly. Go away, spam bot, or </h4>';
  echo '<br /><a href="javascript:history.back(1);">try again</a>';
}

/* Sends the mail and outputs the "Thank you" string if the mail is successfully sent, or the error string otherwise. */
elseif (mail('maintainers@einsteintoolkit.org','New Tutorial Account Requested',$message,'From: RegistrationBot@einsteintoolkit.org')) {
  echo '<h4>Your tutorial account request has been successfully submitted. Thank you for registering!</h4>';
  echo '<br /><a href="/">Home</a>';
} else {
  echo '<h4>Unfortunately, there was a problem registering.</h4>';
  echo 'Go back to <a href="javascript:history.back(1);">try again</a>?';
  echo 'Or contact the <a href="mailto:maintainers@einsteintoolkit.org">maintainers</a>';
  error_log('Failed to send email: ' . implode(',', error_get_last()));
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

