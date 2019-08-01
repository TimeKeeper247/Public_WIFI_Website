<?php
function input_field($errors, $name, $class, $pholder) {
	echo '<div class="required_field">';
	$value = posted_value($name);
	echo "<input type=\"text\" class=\"$class\" id=\"$name\" name=\"$name\" value=\"$value\" placeholder=\"$pholder\"/>";
	errorLabel($errors, $name, $pholder);
	//echo $name .'stuff';
	echo '</div>';
}

function passw_field($errors, $name, $class, $pholder) {
	echo '<div class="required_field">';
	$value = posted_value($name);
	echo "<input type=\"password\" class=\"$class\" id=\"$name\" name=\"$name\" value=\"$value\" placeholder=\"$pholder\"/>";
	echo "<input type=\"password\" class=\"$class\" id=\"$name" . "conf\" name=\"$name" . "conf\" value=\"$value\" placeholder=\"Confirm " . "$pholder\"/>";
	errorLabel($errors, $name, $pholder);
	echo '</div>';
}

function errorLabel($errors, $name, $pholder) {
	//echo '<div class="col-12">';
	echo '<span id=\"$errors\" class="error">';
	if (isset($errors[$name])) {
		echo '<label for=\"$name\" class="c-error">' .$pholder. ' ' .$errors[$name]. '</label>';
	}
	echo '</span>';
	//echo '</div>';
}

function posted_value($name) {
	if (isset($_POST["$name"])) {
		return htmlspecialchars($_POST["$name"]);
	}
}
?>