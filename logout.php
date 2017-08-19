<?php
// *** Logout the current user.
$logoutGoTo = "login.php";
if (!isset($_SESSION)) {
  session_start();
}
$_SESSION['MM_Username'] = NULL;
$_SESSION['MM_UserGroup'] = NULL;
unset($_SESSION['MM_Username']);
unset($_SESSION['MM_UserGroup']);
if ($logoutGoTo != "") {header("Location: $logoutGoTo");
exit;
}
?>
<!Doctype html>
<head>
<Title> template </Title>

<link href="template.css" rel="stylesheet" type="text/css">
<link href="layout.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="Holder"> </div>
<div id="TopBar"></div>
<div id="NavBar">
<nav>
<ul>
<li><a href="logout.php">Log out</a></li>
</ul>
</nav>
</div>
</body>
</html>
