<?php

if($_POST["message"]) {

mail("ville.lahdenp@hotmail.fi", "OpenPayCheck Invitation",

$_POST["Tällä linkillä pääset vertailemaan palkkatietoja ryhmässä:"]. "From: ville.lahdenp@hotmail.fi");

}

?>

<form method="post" action="emailform.php">

<textarea name="message"></textarea>

<input type="submit">

</form>
