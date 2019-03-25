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

// format a php data structure
function pr($x) {
    $t = gettype($x);
    if($t == "string" or $t == "integer" or $t == "double") {
        return $x;
    } else if($t == "boolean") {
        if($x) {
            return "true";
        } else {
            return "false";
        }
    } else if($t == "array") {
        # Avoid messy output
        if(array_key_exists("display_name",$x)) {
            return $x["display_name"];
        }

        $out = "[";
        $tween = "";
        foreach($x as $key => $elem) {
            $out .= $tween;
            $out .= pr("$key: ");
            $out .= pr($elem);
            $tween = ",";
        }
        $out .= "]";
        return $out;
    } else if($t == "NULL") {
        return "";
    } else {
        return "(type=$t)";
    }
}

// from https://lornajane.net/posts/2017/handling-incoming-webhooks-in-php
// webhook syntax for bitbucket is here: https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html#EventPayloads-Issueevents
$secret = $_GET['secret'];
// a random number to ensure that not everyone can use the hook
if ($secret != "24324473106b803349a8b0d71e960129") {
  echo ("Invalid hook\n");
  http_response_code(403);
} elseif($json = json_decode(file_get_contents("php://input"), true)) {
  $data = $json;
  $event_key = $_SERVER['HTTP_X_EVENT_KEY'];
  echo ("Event:".$event_key.":\n");

  $subject = "";
  $msg = "";

  switch($event_key) {
  case "repo:push":
    $subject = sprintf("commit/%s: new changesets", $data['repository']['name']);
    $msg .= sprintf("new commits in %s:\n\n", $data['repository']['name']);
    $push = $data['push'];
    foreach($push['changes'] as $change) {
      if($change['new']) {
        $date = $change['new']['target']['date'];
        $branch = $change['new']['name'];
      } elseif($change['old']) {
        $date = $change['old']['target']['date'];
        $branch = $change['old']['name'];
      } else {
        $date = "unknown";
        $branch = "unknown";
      }
      foreach($change['commits'] as $commit) {
        $msg .= $commit['links']['html']['href'] . "\n";
        $msg .= sprintf("% 12s: %s\n", "Changeset", $commit['hash']);
        $msg .= sprintf("% 12s: %s\n", "Branch", $branch);
        $msg .= sprintf("% 12s: %s\n", "User", $commit['author']);
        $msg .= sprintf("% 12s: %s\n", "Date", $date);
        $msg .= sprintf("% 12s: %s\n", "Summary", $commit['message']);
      }
      if($change['truncated']) {
        $mag .= "[further commits truncated]\n";
      }
    }
    break;
  case "repo:updated":
    break;
  }
  $url = $data['repository']['links']['html']['href'];
  $msg .= sprintf("Repository URL: %s\n", $url);

  if ($subject != "") {
    if(isset($data['actor'])) {
      $headers  = sprintf("From: \"%s\" <commits-noreply@bitbucket.org>\r\n", $data['actor']['display_name']);
    } else {
      $headers  = "From: commits-noreply@bitbucket.org\r\n";
    }
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    $email = 'commits@einsteintoolkit.org';
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

