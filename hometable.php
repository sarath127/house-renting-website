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

$currentPage = $_SERVER["PHP_SELF"];

if ((isset($_POST['hiddenField'])) && ($_POST['hiddenField'] != "")) {
  $deleteSQL = sprintf("DELETE FROM `domicile` WHERE home_id=%s",
                       GetSQLValueString($_POST['hiddenField'], "int"));

  mysql_select_db($database_domicile, $domicile);
  $Result1 = mysql_query($deleteSQL, $domicile) or die(mysql_error());


  $deleteGoTo = "hometable.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
}

$colname_admin = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_admin = $_SESSION['MM_Username'];
}
mysql_select_db($database_domicile, $domicile);
$query_admin = sprintf("SELECT * FROM `admin` WHERE uname = %s", GetSQLValueString($colname_admin, "text"));
$admin = mysql_query($query_admin, $domicile) or die(mysql_error());
$row_admin = mysql_fetch_assoc($admin);
$totalRows_admin = mysql_num_rows($admin);

$maxRows_home = 5;
$pageNum_home = 0;
if (isset($_GET['pageNum_home'])) {
  $pageNum_home = $_GET['pageNum_home'];
}
$startRow_home = $pageNum_home * $maxRows_home;

mysql_select_db($database_domicile, $domicile);
$query_home = "SELECT home_id, user_id, home_type, price, photo FROM domicile ORDER BY home_id ASC";
$query_limit_home = sprintf("%s LIMIT %d, %d", $query_home, $startRow_home, $maxRows_home);
$home = mysql_query($query_limit_home, $domicile) or die(mysql_error());
$row_home = mysql_fetch_assoc($home);

if (isset($_GET['totalRows_home'])) {
  $totalRows_home = $_GET['totalRows_home'];
} else {
  $all_home = mysql_query($query_home);
  $totalRows_home = mysql_num_rows($all_home);
}
$totalPages_home = ceil($totalRows_home/$maxRows_home)-1;

$queryString_home = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_home") == false && 
        stristr($param, "totalRows_home") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_home = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_home = sprintf("&totalRows_home=%d%s", $totalRows_home, $queryString_home);
?>
<?php require_once('Connections/domicile.php'); ?>
<?php @session_start(); ?>
<!Doctype html>
<head>
<Title>manage home table</Title>

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
<div id="Content">
<div id="pageheading">
  <h1>Admin panel: logged in as <?php echo $row_admin['uname']; ?></h1> 
</div>
  <div id="Contentl">
<table width="303" border="1" align="center">
  <tr>
    <td colspan="6" align="left" valign="top">showing record<?php echo ($startRow_home + 1) ?> from&nbsp;<?php echo min($startRow_home + $maxRows_home, $totalRows_home) ?> to    of <?php echo $totalRows_home ?> records</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="top"><?php if ($pageNum_home > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_home=%d%s", $currentPage, max(0, $pageNum_home - 1), $queryString_home); ?>">Previous</a>
        <?php } // Show if not first page ?></td>
    <td align="right" valign="top"><?php if ($pageNum_home < $totalPages_home) { // Show if not last page ?>
        <a href="<?php printf("%s?pageNum_home=%d%s", $currentPage, min($totalPages_home, $pageNum_home + 1), $queryString_home); ?>">Next</a>
        <?php } // Show if not last page ?></td>
  </tr>
  <tr>
    <td width="23" height="24" align="center">user_id</td>
    <td width="23" align="center">home _id</td>
    <td width="47" align="center">home type</td>
    <td width="47" align="center">home price</td>
    <td width="47" align="center">photo</td>
    <td width="76" align="center">delete</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_home['user_id']; ?></td>
      <td><?php echo $row_home['home_id']; ?></td>
      <td><?php echo $row_home['home_type']; ?></td>
      <td><?php echo $row_home['price']; ?></td>
      <td><img src="images/<?php echo $row_home['photo']; ?>" style="width:200px; height:200px"></td>
      <td><form name="form1" method="post" action="">
        <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_home['home_id']; ?>">
        <input name="submit" type="submit" class="Y" id="submit" value="delete home">
      </form></td>
    </tr>
    <?php } while ($row_home = mysql_fetch_assoc($home)); ?>
</table>

<div>
</div>
<div id="Footer"></div>
</body>
<?php

mysql_free_result($home);

mysql_free_result($admin);
?>
