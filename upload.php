<?php require_once('Connections/domicile.php'); ?>
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
if(isset($_POST['submit']))
{	
  $uploadfile=$_FILES["fileField"]["tmp_name"];
  $folder="images/";
  move_uploaded_file($_FILES["fileField"]["tmp_name"], $folder.$_FILES["fileField"]["name"]);
  $img=$_FILES["fileField"]["name"];
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO domicile (user_id, home_type, bedrooms, bathroom, halls, `size`, price, address, pin_number, title, `description`, area_information, photo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, '$img')",
                       GetSQLValueString($_POST['hiddenField'], "int"),
                       GetSQLValueString($_POST['home_type'], "text"),
                       GetSQLValueString($_POST['bedroom'], "text"),
                       GetSQLValueString($_POST['bathroom'], "text"),
                       GetSQLValueString($_POST['hall'], "text"),
                       GetSQLValueString($_POST['size'], "text"),
                       GetSQLValueString($_POST['price'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['pin_number'], "text"),
                       GetSQLValueString($_POST['title'], "text"),
                       GetSQLValueString($_POST['textarea1'], "text"),
                       GetSQLValueString($_POST['area'], "text"),
                       GetSQLValueString($_POST['fileField']["name"], "text"));

  mysql_select_db($database_domicile, $domicile);
  $Result1 = mysql_query($insertSQL, $domicile) or die(mysql_error());

  $insertGoTo = "home.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
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

$colname_user = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_user = $_SESSION['MM_Username'];
}
mysql_select_db($database_domicile, $domicile);
$query_user = sprintf("SELECT * FROM `user` WHERE user_name = %s", GetSQLValueString($colname_user, "text"));
$user = mysql_query($query_user, $domicile) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);

mysql_select_db($database_domicile, $domicile);
$query_Recordset1 = "SELECT * FROM domicile";
$Recordset1 = mysql_query($query_Recordset1, $domicile) or die(mysql_error());
$row_Recordset1 = mysql_fetch_assoc($Recordset1);
$totalRows_Recordset1 = mysql_num_rows($Recordset1);
?>
<!Doctype html>
<head>
<Title>upload property details</Title>
<link href="template.css" rel="stylesheet" type="text/css">
<link href="layout.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.form.js"></script>
<script>
$(document).ready(function() 
{ 
 $('form').ajaxForm(function() 
 {
  alert("Uploaded SuccessFully");
 }); 
});

function preview_image() 
{
 var total_file=document.getElementById("upload_file").files.length;
 for(var i=0;i<total_file;i++)
 {
  $('#image_preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'><br>");
 }
}
</script>
<style type="text/css">
body,td,th {
	color: rgba(0,29,255,1);
	font-weight: bold;
	font-family: "Gill Sans", "Gill Sans MT", "Myriad Pro", "DejaVu Sans Condensed", Helvetica, Arial, sans-serif;
	font-size: large;
}
.ele {font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif}
</style>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script type="text/javascript">
function MM_validateForm() { //v4.0
  if (document.getElementById){
    var i,p,q,nm,test,num,min,max,errors='',args=MM_validateForm.arguments;
    for (i=0; i<(args.length-2); i+=3) { test=args[i+2]; val=document.getElementById(args[i]);
      if (val) { nm=val.name; if ((val=val.value)!="") {
        if (test.indexOf('isEmail')!=-1) { p=val.indexOf('@');
          if (p<1 || p==(val.length-1)) errors+='- '+nm+' must contain an e-mail address.\n';
        } else if (test!='R') { num = parseFloat(val);
          if (isNaN(val)) errors+='- '+nm+' must contain a number.\n';
          if (test.indexOf('inRange') != -1) { p=test.indexOf(':');
            min=test.substring(8,p); max=test.substring(p+1);
            if (num<min || max<num) errors+='- '+nm+' must contain a number between '+min+' and '+max+'.\n';
      } } } else if (test.charAt(0) == 'R') errors += '- '+nm+' is required.\n'; }
    } if (errors) alert('The following error(s) occurred:\n'+errors);
    document.MM_returnValue = (errors == '');
} }
</script>
</head>
<body>
<div id="Holder"> </div>
<div id="TopBar">
  </div>
<div id="NavBar">
<nav>
<ul>
<li><a href="account.php">View profile</a></li>
<li><a href="upload.php">upload property</a></li>
<li><a href="edit.php">Edit profile</a></li>
<li><a href="logout.php">Log out</a></li>>
</ul>
</nav>
</div>
<div id="Filter"></div>
<div id="Content">
  <div id="pageheading">
  <h1 class="ele"><em>upload property details</em></h1>
  <table width="351" border="0">
    <tr>
      <td width="117">logged in as </td>
      <td width="224"><?php echo $row_user['user_name']; ?></td>
      </tr>
  </table> 
  </div>
  <div id="Contentl">
  <form action="<?php echo $editFormAction; ?>" method="POST" name="form" enctype="multipart/form-data">
  <center>
  <table width="1015" height="626" border="0">
  <tbody>
    <tr>
      <td width="242" height="46" align="center">Home type:</td>
      <td width="291"><label>
        <select name="home_type" class="Y" id="home_type">
          <option>apartment</option>
          <option>individual house</option>
          <option>roof house</option>
        </select>
      </label></td>
      <td width="172" align="center">bathrooms:</td>
      <td width="292"><label>
        <select name="bathroom" class="Y" id="bathroom">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>greter than 3</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Bedroom:</td>
      <td><label>
        <select name="bedroom" class="Y" id="bedroom">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>greter than 3</option>
        </select>
      </label></td>
      <td align="center" style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif">Halls:</td>
      <td><label>
        <select name="hall" class="Y" id="hall">
          <option>1</option>
          <option>2</option>
          <option>3</option>
          <option>greter than 3</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">size (approximately):</td>
      <td><label>
        <select name="size" class="Y" id="size">
          <option>1000</option>
          <option>2000</option>
          <option>3000</option>
          <option>greter than 3000</option>
        </select>
      </label></td>
      <td align="center" style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif">Address:</td>
      <td><span id="sprytextarea1">
        <label for="address"></label>
        <textarea name="address" cols="45" rows="5" class="Y" id="address"></textarea>
        <span class="textareaRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="2"><p>&nbsp;</p></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><span class="ele">Title:</span></td>
      <td onfocus="MM_validateForm('fname','','R','lname','','R','uname','','R','password','','R','cpass','','R');return document.MM_returnValue"><span id="sprytextfield1">
        <label for="title"></label>
        <input name="title" type="text" class="Y" id="title">
        <span class="textfieldRequiredMsg">Please fill out.</span></span></td>
      <td align="center">Pin number:</td>
      <td><span id="sprytextfield3">
        <label>
          <input name="pin_number" type="number" class="Y" id="pin_number">
        </label>
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      </tr>
    <tr>
      <td colspan="2"><p>&nbsp;</p></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Area Information:</td>
      <td><span id="sprytextarea3">
        <label for="area"></label>
        <textarea name="area" cols="45" rows="5" class="Y" id="area"></textarea>
        <span class="textareaRequiredMsg">Please fill out.</span></span></td>
      <td align="center">Description:</td>
      <td><span id="sprytextarea2">
        <label>
          <textarea name="textarea1" cols="45" rows="5" class="Y" id="textarea1"></textarea>
        </label>
        <span class="textareaRequiredMsg">A value is required.</span></span></td>
    </tr>
    <tr>
      <td colspan="2"><p>&nbsp;</p></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Upload photo 1:</td>
      <td><input type="file" name="fileField" id="fileField2"></td>
      <td align="center">&nbsp;</td>
      <td>&nbsp;</td>
      </tr>
    <tr>
      <td height="63" colspan="2">&nbsp;</td>
      <td align="center" valign="middle"><p>&nbsp;</p>
        <p>&nbsp;</p></td>
      <td valign="bottom">&nbsp;</td>
      </tr>
    <tr>
      <td align="center"><label for="fileField2"></label>
        Price: (Ruppes)</td>
      <td align="center"><span id="sprytextfield2">
        <label for="price"></label>
        <input name="price" type="number" class="Y" id="price">
        <span class="textfieldRequiredMsg">A value is required.</span></span></td>
      </tr>
    </tbody>
  </table>
  <label for="fileField"><br>
    <br>
</label>
  <input name="submit" type="submit" class="X" id="submit" formmethod="POST" value="Upload property">
  <input name="hiddenField" type="hidden" id="hiddenField" value="<?php echo $row_user['user_id']; ?>">
  </center>
  <input type="hidden" name="MM_insert" value="form">
  </form>
  </div>
  
</div>
<div id="Footer"></div>

<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("sprytextarea1");
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextarea3 = new Spry.Widget.ValidationTextarea("sprytextarea3");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextarea2 = new Spry.Widget.ValidationTextarea("sprytextarea2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
</script>
</body>
</html><?php
mysql_free_result($user);

mysql_free_result($Recordset1);
?>
