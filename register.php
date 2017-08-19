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
  $insertSQL = sprintf("INSERT INTO `user` (user_name, Fname, Lname, Email, Password, Dob, Country, `State`, District, Contact_no, sex, religion, photo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, '$img')",
                       GetSQLValueString($_POST['uname'], "text"),
                       GetSQLValueString($_POST['fname'], "text"),
                       GetSQLValueString($_POST['lname'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['date'], "text"),
                       GetSQLValueString($_POST['country'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['district'], "text"),
                       GetSQLValueString($_POST['number'], "text"),
                       GetSQLValueString($_POST['gender'], "text"),
                       GetSQLValueString($_POST['religion'], "text"),
                       GetSQLValueString($_POST['fileField']["name"], "text"));

  mysql_select_db($database_domicile, $domicile);
  $Result1 = mysql_query($insertSQL, $domicile) or die(mysql_error());

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
  
}

mysql_select_db($database_domicile, $domicile);
$query_user = "SELECT * FROM `user`";
$user = mysql_query($query_user, $domicile) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);
?>
<!Doctype html>
<head>
<Title> Register </Title>
<link href="template.css" rel="stylesheet" type="text/css">
<link href="layout.css" rel="stylesheet" type="text/css">
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
<link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
<meta charset="utf-8">
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>

<script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>

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
  <h1> sign up!</h1> 
  </div>
  <div id="Contentl">
  <form method="POST" name="form" enctype="multipart/form-data">
  <center>
  <table width="1015" height="662" border="0">
  <tbody>
    <tr>
      <td width="228" height="46" align="center"><label for="fname">First Name  </label></td>
      <td colspan="2"><span id="sprytextfield5">
        <label>
          <input name="fname" type="text" class="Y" id="fname" placeholder="Enter first name">
        </label>
        <span class="textfieldRequiredMsg">Please enter the value.</span></span></td>
      <td width="163" align="center"><label for="textfield6">Last Name</label></td>
      <td width="294"><span id="sprytextfield4">
        <label>
          <input name="lname" type="text" class="Y" id="lname" placeholder="Enter last name">
        </label>
        <span class="textfieldRequiredMsg">Please enter the value</span></span></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">User Name</td>
      <td colspan="2"><span id="sprytextfield2">
        <label>
          <input name="uname" type="text" class="Y" id="uname" placeholder="Enter user name">
        </label>
        <span class="textfieldRequiredMsg">Please enter the value</span></span></td>
      <td align="center" style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif">Email Address</td>
      <td><span id="sprytextfield3">
        <label>
          <input name="email" type="email" class="Y" id="email" placeholder="Enter Email address">
        </label>
        <span class="textfieldRequiredMsg">Please enter the value</span></span></td>
    </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">Password</td>
      <td colspan="2"><span id="sprypassword1">
      <label>
        <input name="password" type="password" class="Y" id="password" placeholder="Enter password between 8 to 15 charecters">
      </label>
      <span class="passwordRequiredMsg">Please enter the value</span></span><span class="passwordMinCharsMsg">Minimum number 8 characters</span><span class="passwordMaxCharsMsg"> maximum 15 characters.</span></span></td>
      <td align="center" style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif">Confirm Password</td>
      <td><span id="sprypassword2">
        <label>
          <input name="cpassword" type="password" class="Y" id="cpassword" placeholder="Retype password" min="8" maxlength="15" data-placeholder="Retype password">
        </label>
        <span class="passwordRequiredMsg">Please enter the value</span></span></td>
    </tr>
    <tr>
      <td colspan="3"><p>&nbsp;</p></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><label for="dob">Date Of Birth</label></td>
      <td colspan="2" onfocus="MM_validateForm('fname','','R','lname','','R','uname','','R','password','','R','cpass','','R');return document.MM_returnValue"><span id="sprytextfield1">
        <label>
          <input name="date" type="date" class="Y" id="date" placeholder="Enter date of birth">
        </label>
        <span class="textfieldRequiredMsg">Please enter the value</span></span></td>
      <td align="center"><label for="country" style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif; text-align: justify;">Country</label></td>
      <td><span id="sprytextfield7">
        <label for="country"></label>
        <input name="country" type="text" class="Y" id="country" placeholder="Enter country">
        <span class="textfieldRequiredMsg">please fill out.</span></span></td>
      </tr>
    <tr>
      <td colspan="3"><p>&nbsp;</p></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><span style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif">Contact No</span></td>
      <td colspan="2"><span id="sprytextfield6">
        <label>
          <input name="number" type="number" class="Y" id="number" placeholder="Enter contact number">
        </label>
        <span class="textfieldRequiredMsg">Please Fill out</span></span></td>
      <td align="center">State</td>
      <td><span id="sprytextfield8">
        <label for="state"></label>
        <input name="state" type="text" class="Y" id="state" placeholder="Enter state">
        <span class="textfieldRequiredMsg">please fill out</span></span></td>
    </tr>
    <tr>
      <td colspan="3"><p>&nbsp;</p></td>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><span style="font-family: 'Gill Sans', 'Gill Sans MT', 'Myriad Pro', 'DejaVu Sans Condensed', Helvetica, Arial, sans-serif">Religion</span></td>
      <td colspan="2"><select name="religion" class="Y" id="religion">
        <option>Hindu</option>
        <option>Christian</option>
        <option>Muslim</option>
        <option>Other</option>
      </select></td>
      <td align="center">District</td>
      <td><span id="sprytextfield9">
        <label for="district"></label>
        <input name="district" type="text" class="Y" id="district" placeholder="Enter district">
        <span class="textfieldRequiredMsg">please fill out.</span></span></td>
      </tr>
    <tr>
      <td colspan="3">&nbsp;</td>
      <td align="center"><p>&nbsp;</p>
        <p>Gender</p></td>
      <td valign="bottom"><label>
        <select name="gender" class="Y" id="gender">
          <option>male</option>
          <option>female</option>
        </select>
      </label></td>
      </tr>
    <tr>
      <td height="20" align="center">upload photo</td>
      <td width="282"><label>
        <input type="file" name="fileField" id="fileField">
      </label></td>
      <td width="14">&nbsp;</td>
      </tr>
    <tr>
      <td height="113">&nbsp;</td>
      <td height="113" colspan="2"></td>
    </tr>
    </tbody>
  </table>
  <label for="fileField"><br>
</label>
  <input name="submit" type="submit" class="X" id="submit" formmethod="POST" value="register">
  </center>
  <input type="hidden" name="MM_insert" value="form">
  </form>
  </div>
  
</div>
<div id="Footer">

  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p><center>copy rights domicile project developers || <a href="adminlogin.php">Admin </a></center></p>
</div>
<!--<script type="text/javascript">
function validate()
{
	var p =document.getElementById("Password").value;
	var cp=document.getElementById("Password2").value;
	if(p!=cp)
	{
		windows.alart("password do not match");
		return false;
     }
	 else
	 {
		 return true;
	 }
}-->
<script type="text/javascript">
var password =document.getElementById("password");
var confirm_password = document.getElementById("cpassword");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Passwords Don't Match");
  } else {
    confirm_password.setCustomValidity('');
  }  
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;
</script>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1", {minChars:8, maxChars:15});
var sprypassword2 = new Spry.Widget.ValidationPassword("sprypassword2");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5");
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6");
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7");
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8");
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9");
</script>
</body>
</html><?php
mysql_free_result($user);
?>
