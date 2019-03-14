<?php header("Content-Type: text/html; charset=utf-8"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta content="text/html; charset=utf-8" http-equiv="Content-Type">
  <title>Issue webhook received</title>
</head>
<body>
<pre>
<?php
// from https://lornajane.net/posts/2017/handling-incoming-webhooks-in-php
// webhook syntax for bitbucket is here: https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-Issueevents
$hook_uuid = $_SERVER['HTTP_X_HOOK_UUID'];
// the UUID is shown by bitbucket on the requst information page:
// https://bitbucket.org/einsteintoolkit/tickets/admin/addon/admin/bitbucket-webhooks/bb-webhooks-repo-admin
// and hopefully unique and secret enough for our purpose of serving as a "secret" token
if ($hook_uuid != "b1beef0a-aab4-4384-be6e-c635fee232a7") {
  echo ("Invalid hook\n");
  http_response_code(403);
} elseif($json = json_decode(file_get_contents("php://input"), true)) {
  $data = $json;
  $event_key = $_SERVER['HTTP_X_EVENT_KEY'];
  echo ("Event:".$event_key.":\n");

  $subject = "";
  // alternatively, use text/plain and the 'raw' content for the actual
  // markdown and plain ASCII emails
  $msg = "<html>";
  if(isset($data['issue']['milestone']['name']))
    $milestone = $data['issue']['milestone']['name'];
  else
    $milestone = "";
  if(isset($data['issue']['component']['name']))
    $component = $data['issue']['component']['name'];
  else
    $component = "";
  if(isset($data['issue']['version']['name']))
    $version = $data['issue']['version']['name'];
  else
    $version = "";

  $subject = sprintf("#%s: %s", $data['issue']['id'], $data['issue']['title']);
  $msg .= sprintf("#%s: %s\n", $data['issue']['id'], $data['issue']['title']);
  $msg .= "<table style='border-spacing: 1ex 0pt; '>\n";
  $msg .= sprintf("<tr><td style='text-align:right'>%s:</td><td>%s</td></tr>\n", " Reporter", $data['issue']['reporter']['display_name']);
  $msg .= sprintf("<tr><td style='text-align:right'>%s:</td><td>%s</td></tr>\n", "   Status", $data['issue']['state']);
  $msg .= sprintf("<tr><td style='text-align:right'>%s:</td><td>%s</td></tr>\n", "Milestone", $milestone);
  $msg .= sprintf("<tr><td style='text-align:right'>%s:</td><td>%s</td></tr>\n", "  Version", $version);
  $msg .= sprintf("<tr><td style='text-align:right'>%s:</td><td>%s</td></tr>\n", "     Type", $data['issue']['kind']);
  $msg .= sprintf("<tr><td style='text-align:right'>%s:</td><td>%s</td></tr>\n", " Priority", $data['issue']['priority']);
  $msg .= sprintf("<tr><td style='text-align:right'>%s:</td><td>%s</td></tr>\n", "Component", $component);
  $msg .= "</table>\n";
  $msg .= "\n";
  switch($event_key) {
  case "issue:updated":
    $msg .= sprintf("<p>Changes (by %s):</p>\n" % $data['actor']['display_name']);
    // passthrough
  case "issue:created":
    $msg .= $data['issue']['content']['html'] . "\n";
    break;
  case "issue:comment_created":
    $msg .= sprintf("<p>Comment (by %s):</p>\n" % $data['actor']['display_name']);
    $msg .= $data['comment']['content']['html'] . "\n";
    break;
  }
  $msg .= "--<br/>\n";
  $url = $data['issue']['links']['html']['href'];
  $msg .= sprintf("Ticket URL: <a href='%s'>%s</a>\n", $url, $url);
  $msg .= "</html>";

  if ($subject != "") {
    $headers  = "From: trac-noreply@einsteintoolkit.org\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $email = 'trac@einsteintoolkit.org';
    $rc = mail($email, $subject, $msg, $headers);
    echo ("mail sent successfully:".$rc);
  } else {
    echo ("unknown event type, nomail sent");
  }
} else {
  echo ("Invalid request\n");
  http_response_code(400);
}
?>
</pre>

</body>
</html>

