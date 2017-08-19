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
$query_Recordset1 = "SELECT * FROM `user`";
$Recordset1 = mysql_query($query_Recordset1, $domicile) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['textfield'])) {
  $loginUsername=$_POST['textfield'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "account.php";
  $MM_redirectLoginFailed = "fail.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_domicile, $domicile);
  
  $LoginRS__query=sprintf("SELECT user_name, Password FROM `user` WHERE user_name=%s AND Password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $domicile) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!Doctype html>
<head>
<Title> LOGIN </title>
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
  <h1> LOG IN</h1> 
  </div>
  <div id="Contentl">
  <form enctype="multipart/form-data">
  <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST"><center><table width="963" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td width="207">&nbsp;</td>
      <td width="736">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td> User name</td>
      <td><input name="textfield" type="text" class="Y" id="textfield" placeholder="  Enter username"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>Password</td>
      <td><input name="password" type="password" class="Y" id="password" placeholder="  Enter password"></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right" valign="bottom">&nbsp;</td>
      <td rowspan="2" align="left" valign="top"><input name="submit2" type="submit" class="X" id="submit2" formmethod="POST" value="Submit"></td>
      </tr>
    <tr>
      <td align="center" valign="bottom">&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </tbody>
</table>
</center>
</form>
</div>
</div> 
<div id="Footer"></div>
</body>
</html><?php
mysql_free_result($Recordset1);
?>
