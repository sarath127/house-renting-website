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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO `admin` (uname, password) VALUES (%s, %s)",
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_domicile, $domicile);
  $Result1 = mysql_query($insertSQL, $domicile) or die(mysql_error());

  $insertGoTo = "addadmin.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
?>
<!Doctype html>
<head>
<Title> Add admin</Title>

<link href="template.css" rel="stylesheet" type="text/css">
<link href="layout.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
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
  <h1>Admin panel: logged in as <?php echo $row_account['uname']; ?></h1> 
  </div>
  <div id="Contentl">
  <form method="POST" action="<?php echo $editFormAction; ?>" name="form">
    <center>
      <table width="759" border="0" align="center">
        <tr>
          <td width="100">&nbsp;</td>
          <td width="282" align="center">Add admin</td>
          <td width="43">&nbsp;</td>
        </tr>
        <tr>
          <td><p>&nbsp;</p>
            <p>Name</p>
            <p>&nbsp;</p></td>
          <td><span id="sprytextfield1">
            <label>
              <input name="uname" type="text" class="Y" id="uname">
            </label>
            <span class="textfieldRequiredMsg">please  fill out</span></span></td>
          <td width="43">&nbsp;</td>
          </tr>
        <tr>
          <td><p>&nbsp;</p>
            <p>password</p>
            <p>&nbsp;</p></td>
          <td><span id="sprypassword1">
            <label>
              <input name="password" type="password" class="Y" id="password">
            </label>
            <span class="passwordRequiredMsg">please fill out.</span></span></td>
          <td width="43">&nbsp;</td>
          </tr>
        <tr>
          <td height="53">&nbsp;</td>
          <td><input name="submit" type="submit" class="Y" id="submit" value="add admin"></td>
          <td width="43"><input name="Reset" type="reset" class="Y" id="reset" value="Reset"></td>
          </tr>
      </table>
    </center>
    <input type="hidden" name="MM_insert" value="form">
  </form>
  </div>
</div>
 <div id="Contentr"></div>
<div id="Footer"></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
</script>
</body>
</html><?php
mysql_free_result($account);
?>
