<!Doctype html>
<head>
<Title> CONTACT </Title>

<link href="template.css" rel="stylesheet" type="text/css">
<link href="layout.css" rel="stylesheet" type="text/css">

<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
 <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
  <script>tinymce.init({ selector:'textarea' });</script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
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
  <h1>&nbsp;</h1> 
  </div>
  <div id="Contentl">
  <form enctype="multipart/form-data">
  <form>
  <center>
  <table width="1000" border="0" cellspacing="2" cellpadding="2">
  <tbody>
    <tr>
      <td width="260">&nbsp;</td>
      <td width="720">&nbsp;</td>
    </tr>
    <tr>
      <td style="color: rgba(2,47,255,1); font-size: x-large;">Name</td>
      <td><span id="sprytextfield1">
        <label>
          <input name="name" type="text" class="Y" id="name">
        </label>
        <span class="textfieldRequiredMsg">Please enter the name</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="font-size: x-large; color: rgba(2,0,255,1);">Email</td>
      <td><span id="sprytextfield2">
        <label>
          <input name="email" type="email" class="Y" id="email">
        </label>
        <span class="textfieldRequiredMsg">Please enter the email address</span></span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td style="font-size: x-large; color: rgba(0,44,255,1);">Comment</td>
      <td align="left"><label>
        <textarea name="textarea" class="Y" id="textarea"></textarea>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input name="submit" type="submit" class="X" id="submit" value="Submit"></td>
    </tr>
  </tbody>
</table>
</center>
</form>
</div>
</div>
<div id="Footer"></div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
</script>
</body>
