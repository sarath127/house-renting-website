<?php 
session_start();
require_once('Connections/domicile.php'); ?>
<?php
if(isset($_GET['name']))
{
	$a=$_GET['name'];
mysql_select_db($database_domicile, $domicile);	
$query_user = "select * from user u inner join domicile d on u.user_id = d.user_id where d.home_id = $a";
$user = mysql_query($query_user, $domicile) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
}
 ?>


<!Doctype html>
<head>
<Title> template </Title>

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
<li><a href="signup.php">Sign up</a></li>
<li><a href="about.php">Abouts us</a></li>
<li><a href="contact.php">Contact us</a></li>
</ul>
</nav>
</div>
<div id="Filter"></div>
<div id="Content">
  <div id="pageheading">
  <h1> details of the home </h1> 
  </div>
  <div id="Contentl">
    <table width="976" border="0" align="center">
      <tr>
        <td width="150" height="34">owner name:</td>
        <td colspan="2"><?php echo $row_user['user_name']; ?></td>
        <td>owner religion:</td>
        <td><?php echo $row_user['religion']; ?></td>
      </tr>
      <tr>
        <td height="34" colspan="2">&nbsp;</td>
        <td width="318">&nbsp;</td>
        <td width="267">&nbsp;</td>
        <td width="211">&nbsp;</td>
      </tr>
   
    <tr>
      <td colspan="2" border="1">
      <tr>
        <td height="152" colspan="2">home type:</td>
        <td width="318"><?php echo $row_user['home_type']; ?></td>
        <td width="267">photo:</td>
        <td width="211"><img src="images/<?php echo $row_user['photo']; ?>"style="width:300px;height:300px;" ></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">Bedrooms:</td>
        <td><?php echo $row_user['bedrooms']; ?></td>
        <td>area information:</td>
        <td><?php echo $row_user['area_information']; ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">Halls:</td>
        <td> <?php echo $row_user['halls']; ?></td>
        <td>description:</td>
        <td><?php echo $row_user['description']; ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">Bathrooms:</td>
        <td><?php echo $row_user['bathroom']; ?></td>
        <td>price:</td>
        <td><?php echo $row_user['price']; ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">address:</td>
        <td><?php echo $row_user['address']; ?></td>
        <td>owner number:</td>
        <td><?php echo $row_user['Contact_no']; ?></td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td>&nbsp;</td>
        <td>owner email_id:</td>
        <td><?php echo $row_user['Email']; ?></td>
      </tr>
    </table>
  </div>
</div>
<div id="Footer"></div>
</body>
<?php
mysql_free_result($user);
?>
