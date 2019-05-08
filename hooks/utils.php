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

?>
