<?php require_once('Connections/domicile.php');
session_start(); ?>
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update")) {
  $updateSQL = sprintf("UPDATE `user` SET Fname=%s, Lname=%s, Email=%s, Password=%s, Contact_no=%s WHERE user_id=%s",
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['text1'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['number'], "text"),
                       GetSQLValueString($_POST['hiddenField'], "int"));

  mysql_select_db($database_domicile, $domicile);
  $Result1 = mysql_query($updateSQL, $domicile) or die(mysql_error());

  $updateGoTo = "edit.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_Recordset1 = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_Recordset1 = $_SESSION['MM_Username'];
  @session_start();
}
mysql_select_db($database_domicile, $domicile);
$query_Recordset1 = sprintf("SELECT user_id, user_name, Fname, Lname, Email, Password, Contact_no FROM `user` WHERE user_name = %s", GetSQLValueString($colname_Recordset1, "text"));
$Recordset1 = mysql_query($query_Recordset1, $domicile) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);

?>



<!Doctype html>
<head>
<Title>update profile</Title>

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
  <h1> Edit Profile : logged as <?php echo $row_Recordset1['user_name']; ?></h1> 
  </div>
  <div id="Contentl">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="update" enctype="multipart/form-data" id="update">
  
    <table width="1000" border="0" align="center" cellpadding="2" cellspacing="2">
      <tbody>
    <tr>
      <td width="148">User:</td>
      <td width="281"><?php echo $row_Recordset1['user_name']; ?></td>
      <td width="111">account:</td>
      <td><?php echo $row_Recordset1['Fname']; ?></td>
      <td><?php echo $row_Recordset1['Lname']; ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td>Email address</td>
      <td colspan="2"><span id="sprytextfield1">
        <label>
          <input name="email" type="email" class="Y" id="email" value="<?php echo $row_Recordset1['Email']; ?>">
        </label>
        <span class="textfieldRequiredMsg">Please enter the value.</span></span></td>
      <td width="84">contact number</td>
      <td width="344"><span id="sprytextfield3">
        <label>
          <input name="number" type="number" class="Y" id="number" value="<?php echo $row_Recordset1['Contact_no']; ?>">
        </label>
        <span class="textfieldRequiredMsg">Please enter the value.</span></span></td>
    </tr>
    <tr>
      <td>password</td>
      <td colspan="2"><span id="sprypassword2">
        <label>
          <input name="password" type="password" class="Y" id="password" value="<?php echo $row_Recordset1['Password']; ?>">
        </label>
        <span class="passwordRequiredMsg">Please enter the value.</span></span></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td height="43">First name</td>
      <td colspan="2"><span id="sprytextfield5">
        <label>
          <input name="uname" type="text" class="Y" id="uname" value="<?php echo $row_Recordset1['Fname']; ?>">
        </label>
        <span class="textfieldRequiredMsg">please enter the value.</span></span></td>
      <td>Last name</td>
      <td><span id="sprytextfield2">
        <label for="text1"></label>
        <input name="text1" type="text" class="Y" id="text1" value="<?php echo $row_Recordset1['Lname']; ?>">
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2"><p>&nbsp;</p></td>
      <td colspan="2" align="center"><label for="form2">
        <input name="Submit" type="submit" class="Y" id="button" value="update account">
        <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_Recordset1['user_id']; ?>">
      </label></td>
      </tr>
    <tr>
      <td colspan="3" align="center">&nbsp;</td>
      <td colspan="2" align="center">&nbsp;</td>
      </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="5">&nbsp;</td>
    </tr>
    </tbody>
</table>
    <input type="hidden" name="MM_update" value="update">
  </form>
  
  </div>
</div>
<div id="Footer"></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
<?php
mysql_free_result($Recordset1);
?>
