<?php require_once('Connections/domicile.php'); ?>
<?php @session_start();?>
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
$query_account = sprintf("SELECT * FROM `user` WHERE user_name = %s", GetSQLValueString($colname_account, "text"));
$account = mysql_query($query_account, $domicile) or die(mysql_error());
$row_account = mysql_fetch_assoc($account);
$totalRows_account = mysql_num_rows($account);
?>
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
<li><a href="account.php">View profile</a></li>
<li><a href="upload.php">upload property</a></li>
<li><a href="edit.php">Edit profile</a></li>
<li><a href="logout.php">Log out</a></li>
</ul>
</nav>
</div>
<div id="Filter"></div>
<div id="Content">
  <div id="pageheading">
  <h1>logged in as <?php echo $row_account['user_name']; ?></h1> 
  </div>
  <div id="Contentl">
  <form>
  <center>
  <table width="1007" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td width="178">First Name :</td>
      <td width="291"><?php echo $row_account['Fname']; ?></td>
      <td width="251">Last Name:</td>
      <td width="261"><?php echo $row_account['Lname']; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>User Name:</td>
      <td><?php echo $row_account['user_name']; ?></td>
      <td>Date of Birth:</td>
      <td><?php echo $row_account['Dob']; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Email id :</td>
      <td><?php echo $row_account['Email']; ?></td>
      <td>Sex:</td>
      <td><?php echo $row_account['sex']; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Religion:</td>
      <td><?php echo $row_account['religion']; ?></td>
      <td>Contact Number:</td>
      <td><?php echo $row_account['Contact_no']; ?></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Country:</td>
      <td><?php echo $row_account['Country']; ?></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>state:</td>
      <td><?php echo $row_account['State']; ?></td>
      <td rowspan="4">Profile Picture:</td>
      <td rowspan="4"><img src="images/<?php echo $row_account['photo']; ?>"style="width:300px;height:300px;" ></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
    <tr>
      <td>District:</td>
      <td><?php echo $row_account['District']; ?></td>
      </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
  </tbody>
</table>
</center>
  </form>
  </div>
</div>
 <div id="Contentr"></div>
<div id="Footer">
</div>
</body>
<?php
mysql_free_result($account);
?>
