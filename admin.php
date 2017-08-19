<?php require_once('Connections/domicile.php'); ?>
<?php session_start();?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$colname_account = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_account = $_SESSION['MM_Username'];
}
mysql_select_db($database_domicile, $domicile);
$query_account = sprintf("SELECT * FROM `admin` WHERE uname = %s", GetSQLValueString($colname_account, "text"));
$account = mysql_query($query_account, $domicile) or die(mysql_error());
$row_account = mysql_fetch_assoc($account);
$totalRows_account = mysql_num_rows($account);
 @session_start(); ?>
<!Doctype html>
<head>
<Title> Account</Title>

<link href="template.css" rel="stylesheet" type="text/css">
<link href="layout.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="Holder"> </div>
<div id="TopBar"></div>
<div id="NavBar">
<nav>
<ul>
<li><a href="admin.php"> Admin</a></li>
<li><a href="user.php">User table</a></li>
<li><a href="hometable.php">home table</a></li>
<li><a href="addadmin.php">add admin</a></li>
<li><a href="logout.php">logout</a></li>
</ul>
</nav>
</div>
<div id="Filter"></div>
<div id="Content">
  <div id="pageheading">
  <h1>Admin panel: welcome <?php echo $row_account['uname']; ?></h1> 
  </div>
  <div id="Contentl">
  <form>
    <center>
    </center>
  </form>
  </div>
</div>
 <div id="Contentr"></div>
<div id="Footer"></div>
</body>
<?php
mysql_free_result($account);
?>
