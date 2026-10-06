<?php

require_once "core/core.php";

// Clear every value stored in the session...
$_SESSION = [];

// then destroy the session itself
session_destroy();

header("Location: index.php");
exit;
