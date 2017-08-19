<?php require_once('Connections/domicile.php'); ?>
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

mysql_select_db($database_domicile, $domicile);
$query_domicile2 = "SELECT * FROM domicile ORDER BY home_id ASC";
$domicile2 = mysql_query($query_domicile2, $domicile) or die(mysql_error());
$row_domicile2 = mysql_fetch_assoc($domicile2);
$totalRows_domicile2 = mysql_num_rows($domicile2);

$maxRows_domicile = 100;
$pageNum_domicile = 0;
if (isset($_GET['pageNum_domicile'])) {
  $pageNum_domicile = $_GET['pageNum_domicile'];
}
$startRow_domicile = $pageNum_domicile * $maxRows_domicile;

mysql_select_db($database_domicile, $domicile);
$query_domicile = "SELECT * FROM domicile ORDER BY home_id DESC";
$query_limit_domicile = sprintf("%s LIMIT %d, %d", $query_domicile, $startRow_domicile, $maxRows_domicile);
$domicile = mysql_query($query_limit_domicile, $domicile) or die(mysql_error());
$row_domicile = mysql_fetch_assoc($domicile);


if (isset($_GET['totalRows_domicile'])) {
  $totalRows_domicile = $_GET['totalRows_domicile'];
} else {
  $all_domicile = mysql_query($query_domicile);
  $totalRows_domicile = mysql_num_rows($all_domicile);
}
$totalPages_domicile = ceil($totalRows_domicile/$maxRows_domicile)-1;

if(isset($_POST['submit']))
{
	

$maxRows_domicile = 10;
$pageNum_domicile = 0;
if (isset($_GET['pageNum_domicile'])) {
  $pageNum_domicile = $_GET['pageNum_domicile'];
}
$startRow_domicile = $pageNum_domicile * $maxRows_domicile;

mysql_select_db($database_domicile, $domicile);
$query_domicile = "SELECT * FROM domicile ORDER BY home_id ASC";
$query_limit_domicile = sprintf("%s LIMIT %d, %d", $query_domicile, $startRow_domicile, $maxRows_domicile);
$domicile = mysql_query($query_limit_domicile, $domicile) or die(mysql_error());
$row_domicile = mysql_fetch_assoc($domicile);


if (isset($_GET['totalRows_domicile'])) {
  $totalRows_domicile = $_GET['totalRows_domicile'];
} else {
  $all_domicile = mysql_query($query_domicile);
  $totalRows_domicile = mysql_num_rows($all_domicile);
}
$totalPages_domicile = ceil($totalRows_domicile/$maxRows_domicile)-1;
	
}
?>
<!Doctype html>
<head>
<Title>home page</Title>
<link href="template.css" rel="stylesheet" type="text/css">
<link href="layout.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="Holder"> </div>
<div id="TopBar"></div>
<div id="NavBar">
<nav>
<ul>
<li><a href="home.php">Home</a></li>
<li><a href="login.php">Login</a></li>
<li><a href="register.php">Sign up</a></li>
<li><a href="about.php">About us</a></li>
<li><a href="contact.php">Contact us</a></li>
</ul>
</nav>
</div>
<div id="Filter"></div>
<div id="Content">
  <div id="pageheading">
  <h1>Filter search</h1>
  <form>
    <table width="1379" border="0" align="center">
      <tr>
        <td width="244" height="52" align="center"><a href="home.php">sort by time</a></td>
        <td width="244" align="center" valign="middle"><a href="home2.php">sort by time</a></td>
        <td width="246" align="center"><a href="home3.php">sort by price</a></td>
        <td width="244" align="center"><a href="home4.php">sort by price</a></td>
        <td width="300">&nbsp;</td>
        <td width="75">&nbsp;</td>
      </tr>
    </table>
  </form>
  </div>
  <div id="Contentl">
  <form action="" method="post">
  <center>
  <?php do { ?>
    <table width="1001" height="267" border="0">
      <tr>
        <td width="200" rowspan="3"><img src="images/<?php echo $row_domicile2['photo']; ?>" style="width:200px; height:200px;"></td>
        <td rowspan="3">&nbsp;</td>
        <td width="761">&nbsp;</td>
        </tr>
      <tr>
        <td height="41">Title:<?php echo $row_domicile2['title']; ?></td>
        </tr>
      <tr>
        <td valign="top">description:<?php echo $row_domicile2['description']; ?></td>
        </tr>
      <tr>
        <td colspan="2"><p>price:<?php echo $row_domicile2['price']; ?> rs</p></td>
        <td><a href="details.php?name=<?php echo $row_domicile2['home_id'];?>"> details</a></td>
        </tr>
      <tr>
        <td height="32" colspan="2">&nbsp;</td>
        <td height="32">&nbsp;</td>
        </tr>
    </table>
    <?php } while ($row_domicile2 = mysql_fetch_assoc($domicile2)); ?>
  </form></div>
  
</div>
<div id="Footer">
<br>

<table width="1097" border="0">
  <tr>
    <td width="535" align="right"><p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p></p></td>
      </td>
  </tr>
</table>

</div>
</body>
<?php
mysql_free_result($domicile);

mysql_free_result($domicile2);
?>
