<?php
function ltsmp_css_strip_whitespace($css){
	  $replace = array(
	    "#/\*.*?\*/#s" => "",  // Strip C style comments.
	    "#\s\s+#"      => " ", // Strip excess whitespace.
	  );
	  $search = array_keys($replace);
	  $css = preg_replace($search, $replace, $css);

	  $replace = array(
	    ": "  => ":",
	    "; "  => ";",
	    " {"  => "{",
	    " }"  => "}",
	    ", "  => ",",
	    "{ "  => "{",
	    ";}"  => "}", // Strip optional semicolons.
	    ",\n" => ",", // Don't wrap multiple selectors.
	    "\n}" => "}", // Don't wrap closing braces.
	    "} "  => "}\n", // Put each rule on it's own line.
	  );
	  $search = array_keys($replace);
	  $css = str_replace($search, $replace, $css);

	  return trim($css);
}



function ltsmp_no_sanitize(){}

//SANITIZATION FUNCTIONS
function ltsmp_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}

function ltsmp_sanitize_checkbox( $input ) {
    if ( $input == 1 ) {
        return 1;
    } else {
        return '';
    }
}

?>
