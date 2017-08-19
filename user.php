<?php require_once('Connections/domicile.php'); ?>
<?php @session_start(); ?>
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
  $deleteSQL = sprintf("DELETE FROM `user` WHERE user_id=%s",
                       GetSQLValueString($_POST['hiddenField'], "int"));

  mysql_select_db($database_domicile, $domicile);
  $Result1 = mysql_query($deleteSQL, $domicile) or die(mysql_error());

  $deleteGoTo = "user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
    $deleteGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $deleteGoTo));
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

$maxRows_user = 5;
$pageNum_user = 0;
if (isset($_GET['pageNum_user'])) {
  $pageNum_user = $_GET['pageNum_user'];
}
$startRow_user = $pageNum_user * $maxRows_user;

mysql_select_db($database_domicile, $domicile);
$query_user = "SELECT * FROM `user` ORDER BY user_id ASC";
$query_limit_user = sprintf("%s LIMIT %d, %d", $query_user, $startRow_user, $maxRows_user);
$user = mysql_query($query_limit_user, $domicile) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);

if (isset($_GET['totalRows_user'])) {
  $totalRows_user = $_GET['totalRows_user'];
} else {
  $all_user = mysql_query($query_user);
  $totalRows_user = mysql_num_rows($all_user);
}
$totalPages_user = ceil($totalRows_user/$maxRows_user)-1;

$queryString_user = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_user") == false && 
        stristr($param, "totalRows_user") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_user = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_user = sprintf("&totalRows_user=%d%s", $totalRows_user, $queryString_user);
?>
<!Doctype html>
<head>
<Title> Manage user account</Title>

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
  <h1>Admin panel: logged in as <?php echo $row_account['uname']; ?></h1> 
</div>
  <div id="Contentl">
<table width="303" border="1" align="center">
  <tr>
    <td colspan="6" align="left" valign="top">showing record from&nbsp;<?php echo ($startRow_user + 1) ?> to   <?php echo min($startRow_user + $maxRows_user, $totalRows_user) ?> of <?php echo $totalRows_user ?> records</td>
  </tr>
  <tr>
    <td colspan="5" align="left" valign="top"><?php if ($pageNum_user > 0) { // Show if not first page ?>
        <a href="<?php printf("%s?pageNum_user=%d%s", $currentPage, max(0, $pageNum_user - 1), $queryString_user); ?>">Previous </a>
        <?php } // Show if not first page ?></td>
    <td align="right" valign="top"><?php if ($pageNum_user < $totalPages_user) { // Show if not last page ?>
  <a href="<?php printf("%s?pageNum_user=%d%s", $currentPage, min($totalPages_user, $pageNum_user + 1), $queryString_user); ?>">Next</a>
  <?php } // Show if not last page ?></td>
  </tr>
  <tr>
    <td width="23" height="24" align="center">user_id</td>
    <td width="23" align="center">username</td>
    <td width="47" align="center">sex</td>
    <td width="47" align="center">number</td>
    <td width="47" align="center">photo</td>
    <td width="76" align="center">delete</td>
  </tr>
  <?php do { ?>
  
      <?php if ($totalRows_user > 0) { // Show if recordset not empty ?>
  <tr>
    <td><?php echo $row_user['user_id']; ?></td>
    <td><?php echo $row_user['user_name']; ?></td>
    <td><?php echo $row_user['sex']; ?></td>
    <td><?php echo $row_user['Contact_no']; ?></td>
    <td><img src="images/<?php echo $row_user['photo']; ?>" style="width:200px;height:150px;" ></td>
      
    <td><form name="form1" method="post" action="">
      <input name="Submit" type="submit" class="Y" id="button" value="delete user">
      <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_user['user_id']; ?>">
    </form></td>
  </tr>
  <?php } // Show if recordset not empty ?>
<?php } while ($row_user = mysql_fetch_assoc($user)); ?>
  </table>

<div>
</div>
<div id="Footer"></div>
</body>
<?php
mysql_free_result($account);

mysql_free_result($user);
?>
