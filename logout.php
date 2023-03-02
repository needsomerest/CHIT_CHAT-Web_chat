<?php 
# Resume existing session
session_start();
# Free all session variables
session_unset();
# Destroys all data registered to a session
session_destroy();
#return to index page (login page) 
header("Location: index.php");
exit;