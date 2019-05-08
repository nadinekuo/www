<?php

// format a php data structure
function pr($x) {
    $t = gettype($x);
    if($t == "string" or $t == "integer" or $t == "double") {
        return htmlentities($x);
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

function call_REST($url) {
  // lifted from various places on the net, eg:
  // https://stackoverflow.com/questions/9802788/call-a-rest-api-in-php
  $curl = curl_init($url);
  curl_setopt($curl,CURLOPT_HTTPHEADER,['Accept:application/json, Content-Type:application/json']);
  curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'GET');
  curl_setopt($curl,CURLOPT_RETURNTRANSFER ,TRUE);
  $result = curl_exec($curl);
  curl_close($curl);
  return json_decode($result,true);
}

?>
