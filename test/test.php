<?php 
/**
 *  Simple html input & output page, no templating, javascript or CSS included
 *
 *  @author Derek Boerger
 *  @since October 2018
 *
 *  @todo use a template, use javascript/jquery to handle, make it pretty, send it to a handler rather than back to itself
 *
 */
include("../number_to_string.php");

$input_number = (isset($_POST['input_number']) && strlen($_POST['input_number']) > 0) ?  $_POST['input_number'] : NULL;

echo "<form method='post'>\n".
    "<textarea cols='100' rows='10' name='input_number'>$input_number</textarea>\n".
    "<br />\n".
    "<input type='submit' value='Analyze'>\n".
    "<input type='reset'>\n".
    "</form>\n";


if (!is_null($input_number))
{
    $num2string = new num2string($input_number);
    
    echo $num2string->output;
}
?>