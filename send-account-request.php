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
$github = $_POST['github'];
$buechsenwursttest = $_POST['buechsenwursttest'];

$message  = "Einstein Toolkit maintainers\n";
$message .= "\n";
$message .= "$name has submitted a request for a tutorial server account.\n";
$message .= "email: $email\n";
$message .= "Institution: $institution\n";
$message .= "github user name: $github\n";

$headers = "From: RegistrationBot@einsteintoolkit.org\r\n".
           "Reply-To: $email";

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
} elseif (empty($github) and empty($institution)) {
  echo '<h4>You must name an identity provider.</h4>';
  echo '<br /><a href="javascript:history.back(1);">Try again</a>';
} elseif (empty($github) and strcasecmp($institution, "GitHub")) {
  echo '<h4>When using GitHub as the identity provider, please provide your GitHub user name.</h4>';
  echo '<br /><a href="javascript:history.back(1);">Try again</a>';
} elseif (!empty($github) and (strpos($github, "@") !== false)) {
  echo '<h4>Please provide your GitHub account name, not your email address. See you <a href="https://github.com/settings/admin">account page</a> for it.</h4>';
  echo '<br /><a href="javascript:history.back(1);">Try again</a>';
} elseif (!empty($github) and !verify_GitHub_Profile($github)) {
  echo '<h4>The GitHub user account that you provided does not exist.</h4>';
  echo '<br /><a href="javascript:history.back(1);">Try again</a>';
} elseif (empty($buechsenwursttest) || ($buechsenwursttest != "Einstein")) {
  echo '<h4>You did not spell \'Einstein\' correctly. Go away, spam bot, or </h4>';
  echo '<br /><a href="javascript:history.back(1);">try again</a>';
} elseif (mail('maintainers@einsteintoolkit.org',
	       'New Einstein Toolkit tutorial account request received',
	       $message,$headers)) {
/* Sends the mail and outputs the "Thank you" string if the mail is successfully sent, or the error string otherwise. */
  echo '<h4>Your account request has been successfully submitted.</h4>';
  echo '<br />Thank you for trying out the Einstein Toolkit.';
  echo '<br />Please allow for 2 business days for your account to be created.';
  echo '<br /><a href="/">Home</a>';
} else {
  echo '<h4>Unfortunately, there was a problem registering.</h4>';
  echo 'Go back to <a href="javascript:history.back(1);">try again</a>?';
  echo 'Or contact the <a href="mailto:maintainers@einsteintoolkit.org">maintainers</a>';
  error_log('Failed to send email: ' . implode(',', error_get_last()));
}

function verify_GitHub_Profile($github) {
  if(function_exists('curl_version')) {
    // lifted from various places on the net, eg:
    // https://stackoverflow.com/questions/9802788/call-a-rest-api-in-php
    $url = "https://github.com/" . $github;
    $curl = curl_init($url);
    curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
    curl_setopt($curl,CURLOPT_RETURNTRANSFER ,TRUE);
    $result = curl_exec($curl);
    curl_close($curl);
    return $result != "Not Found";
  } else {
    return 1;
  }
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

