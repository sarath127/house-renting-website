<?php
require_once( dirname(__FILE__).'/form.lib.php' );

define( 'PHPFMG_USER', "domicile892@gmail.com" ); // must be a email address. for sending password to you.
define( 'PHPFMG_PW', "8a5d4e" );

?>
<?php
/**
 * GNU Library or Lesser General Public License version 2.0 (LGPLv2)
*/

# main
# ------------------------------------------------------
error_reporting( E_ERROR ) ;
phpfmg_admin_main();
# ------------------------------------------------------




function phpfmg_admin_main(){
    $mod  = isset($_REQUEST['mod'])  ? $_REQUEST['mod']  : '';
    $func = isset($_REQUEST['func']) ? $_REQUEST['func'] : '';
    $function = "phpfmg_{$mod}_{$func}";
    if( !function_exists($function) ){
        phpfmg_admin_default();
        exit;
    };

    // no login required modules
    $public_modules   = false !== strpos('|captcha|', "|{$mod}|", "|ajax|");
    $public_functions = false !== strpos('|phpfmg_ajax_submit||phpfmg_mail_request_password||phpfmg_filman_download||phpfmg_image_processing||phpfmg_dd_lookup|', "|{$function}|") ;   
    if( $public_modules || $public_functions ) { 
        $function();
        exit;
    };
    
    return phpfmg_user_isLogin() ? $function() : phpfmg_admin_default();
}

function phpfmg_ajax_submit(){
    $phpfmg_send = phpfmg_sendmail( $GLOBALS['form_mail'] );
    $isHideForm  = isset($phpfmg_send['isHideForm']) ? $phpfmg_send['isHideForm'] : false;

    $response = array(
        'ok' => $isHideForm,
        'error_fields' => isset($phpfmg_send['error']) ? $phpfmg_send['error']['fields'] : '',
        'OneEntry' => isset($GLOBALS['OneEntry']) ? $GLOBALS['OneEntry'] : '',
    );
    
    @header("Content-Type:text/html; charset=$charset");
    echo "<html><body><script>
    var response = " . json_encode( $response ) . ";
    try{
        parent.fmgHandler.onResponse( response );
    }catch(E){};
    \n\n";
    echo "\n\n</script></body></html>";

}


function phpfmg_admin_default(){
    if( phpfmg_user_login() ){
        phpfmg_admin_panel();
    };
}



function phpfmg_admin_panel()
{    
    phpfmg_admin_header();
    phpfmg_writable_check();
?>    
<table cellpadding="0" cellspacing="0" border="0">
	<tr>
		<td valign=top style="padding-left:280px;">

<style type="text/css">
    .fmg_title{
        font-size: 16px;
        font-weight: bold;
        padding: 10px;
    }
    
    .fmg_sep{
        width:32px;
    }
    
    .fmg_text{
        line-height: 150%;
        vertical-align: top;
        padding-left:28px;
    }

</style>

<script type="text/javascript">
    function deleteAll(n){
        if( confirm("Are you sure you want to delete?" ) ){
            location.href = "admin.php?mod=log&func=delete&file=" + n ;
        };
        return false ;
    }
</script>


<div class="fmg_title">
    1. Email Traffics
</div>
<div class="fmg_text">
    <a href="admin.php?mod=log&func=view&file=1">view</a> &nbsp;&nbsp;
    <a href="admin.php?mod=log&func=download&file=1">download</a> &nbsp;&nbsp;
    <?php 
        if( file_exists(PHPFMG_EMAILS_LOGFILE) ){
            echo '<a href="#" onclick="return deleteAll(1);">delete all</a>';
        };
    ?>
</div>


<div class="fmg_title">
    2. Form Data
</div>
<div class="fmg_text">
    <a href="admin.php?mod=log&func=view&file=2">view</a> &nbsp;&nbsp;
    <a href="admin.php?mod=log&func=download&file=2">download</a> &nbsp;&nbsp;
    <?php 
        if( file_exists(PHPFMG_SAVE_FILE) ){
            echo '<a href="#" onclick="return deleteAll(2);">delete all</a>';
        };
    ?>
</div>

<div class="fmg_title">
    3. Form Generator
</div>
<div class="fmg_text">
    <a href="http://www.formmail-maker.com/generator.php" onclick="document.frmFormMail.submit(); return false;" title="<?php echo htmlspecialchars(PHPFMG_SUBJECT);?>">Edit Form</a> &nbsp;&nbsp;
    <a href="http://www.formmail-maker.com/generator.php" >New Form</a>
</div>
    <form name="frmFormMail" action='http://www.formmail-maker.com/generator.php' method='post' enctype='multipart/form-data'>
    <input type="hidden" name="uuid" value="<?php echo PHPFMG_ID; ?>">
    <input type="hidden" name="external_ini" value="<?php echo function_exists('phpfmg_formini') ?  phpfmg_formini() : ""; ?>">
    </form>

		</td>
	</tr>
</table>

<?php
    phpfmg_admin_footer();
}



function phpfmg_admin_header( $title = '' ){
    header( "Content-Type: text/html; charset=" . PHPFMG_CHARSET );
?>
<html>
<head>
    <title><?php echo '' == $title ? '' : $title . ' | ' ; ?>PHP FormMail Admin Panel </title>
    <meta name="keywords" content="PHP FormMail Generator, PHP HTML form, send html email with attachment, PHP web form,  Free Form, Form Builder, Form Creator, phpFormMailGen, Customized Web Forms, phpFormMailGenerator,formmail.php, formmail.pl, formMail Generator, ASP Formmail, ASP form, PHP Form, Generator, phpFormGen, phpFormGenerator, anti-spam, web hosting">
    <meta name="description" content="PHP formMail Generator - A tool to ceate ready-to-use web forms in a flash. Validating form with CAPTCHA security image, send html email with attachments, send auto response email copy, log email traffics, save and download form data in Excel. ">
    <meta name="generator" content="PHP Mail Form Generator, phpfmg.sourceforge.net">

    <style type='text/css'>
    body, td, label, div, span{
        font-family : Verdana, Arial, Helvetica, sans-serif;
        font-size : 12px;
    }
    </style>
</head>
<body  marginheight="0" marginwidth="0" leftmargin="0" topmargin="0">

<table cellspacing=0 cellpadding=0 border=0 width="100%">
    <td nowrap align=center style="background-color:#024e7b;padding:10px;font-size:18px;color:#ffffff;font-weight:bold;width:250px;" >
        Form Admin Panel
    </td>
    <td style="padding-left:30px;background-color:#86BC1B;width:100%;font-weight:bold;" >
        &nbsp;
<?php
    if( phpfmg_user_isLogin() ){
        echo '<a href="admin.php" style="color:#ffffff;">Main Menu</a> &nbsp;&nbsp;' ;
        echo '<a href="admin.php?mod=user&func=logout" style="color:#ffffff;">Logout</a>' ;
    }; 
?>
    </td>
</table>

<div style="padding-top:28px;">

<?php
    
}


function phpfmg_admin_footer(){
?>

</div>

<div style="color:#cccccc;text-decoration:none;padding:18px;font-weight:bold;">
	:: <a href="http://phpfmg.sourceforge.net" target="_blank" title="Free Mailform Maker: Create read-to-use Web Forms in a flash. Including validating form with CAPTCHA security image, send html email with attachments, send auto response email copy, log email traffics, save and download form data in Excel. " style="color:#cccccc;font-weight:bold;text-decoration:none;">PHP FormMail Generator</a> ::
</div>

</body>
</html>
<?php
}


function phpfmg_image_processing(){
    $img = new phpfmgImage();
    $img->out_processing_gif();
}


# phpfmg module : captcha
# ------------------------------------------------------
function phpfmg_captcha_get(){
    $img = new phpfmgImage();
    $img->out();
    //$_SESSION[PHPFMG_ID.'fmgCaptchCode'] = $img->text ;
    $_SESSION[ phpfmg_captcha_name() ] = $img->text ;
}



function phpfmg_captcha_generate_images(){
    for( $i = 0; $i < 50; $i ++ ){
        $file = "$i.png";
        $img = new phpfmgImage();
        $img->out($file);
        $data = base64_encode( file_get_contents($file) );
        echo "'{$img->text}' => '{$data}',\n" ;
        unlink( $file );
    };
}


function phpfmg_dd_lookup(){
    $paraOk = ( isset($_REQUEST['n']) && isset($_REQUEST['lookup']) && isset($_REQUEST['field_name']) );
    if( !$paraOk )
        return;
        
    $base64 = phpfmg_dependent_dropdown_data();
    $data = @unserialize( base64_decode($base64) );
    if( !is_array($data) ){
        return ;
    };
    
    
    foreach( $data as $field ){
        if( $field['name'] == $_REQUEST['field_name'] ){
            $nColumn = intval($_REQUEST['n']);
            $lookup  = $_REQUEST['lookup']; // $lookup is an array
            $dd      = new DependantDropdown(); 
            echo $dd->lookupFieldColumn( $field, $nColumn, $lookup );
            return;
        };
    };
    
    return;
}


function phpfmg_filman_download(){
    if( !isset($_REQUEST['filelink']) )
        return ;
        
    $info =  @unserialize(base64_decode($_REQUEST['filelink']));
    if( !isset($info['recordID']) ){
        return ;
    };
    
    $file = PHPFMG_SAVE_ATTACHMENTS_DIR . $info['recordID'] . '-' . $info['filename'];
    phpfmg_util_download( $file, $info['filename'] );
}


class phpfmgDataManager
{
    var $dataFile = '';
    var $columns = '';
    var $records = '';
    
    function phpfmgDataManager(){
        $this->dataFile = PHPFMG_SAVE_FILE; 
    }
    
    function parseFile(){
        $fp = @fopen($this->dataFile, 'rb');
        if( !$fp ) return false;
        
        $i = 0 ;
        $phpExitLine = 1; // first line is php code
        $colsLine = 2 ; // second line is column headers
        $this->columns = array();
        $this->records = array();
        $sep = chr(0x09);
        while( !feof($fp) ) { 
            $line = fgets($fp);
            $line = trim($line);
            if( empty($line) ) continue;
            $line = $this->line2display($line);
            $i ++ ;
            switch( $i ){
                case $phpExitLine:
                    continue;
                    break;
                case $colsLine :
                    $this->columns = explode($sep,$line);
                    break;
                default:
                    $this->records[] = explode( $sep, phpfmg_data2record( $line, false ) );
            };
        }; 
        fclose ($fp);
    }
    
    function displayRecords(){
        $this->parseFile();
        echo "<table border=1 style='width=95%;border-collapse: collapse;border-color:#cccccc;' >";
        echo "<tr><td>&nbsp;</td><td><b>" . join( "</b></td><td>&nbsp;<b>", $this->columns ) . "</b></td></tr>\n";
        $i = 1;
        foreach( $this->records as $r ){
            echo "<tr><td align=right>{$i}&nbsp;</td><td>" . join( "</td><td>&nbsp;", $r ) . "</td></tr>\n";
            $i++;
        };
        echo "</table>\n";
    }
    
    function line2display( $line ){
        $line = str_replace( array('"' . chr(0x09) . '"', '""'),  array(chr(0x09),'"'),  $line );
        $line = substr( $line, 1, -1 ); // chop first " and last "
        return $line;
    }
    
}
# end of class



# ------------------------------------------------------
class phpfmgImage
{
    var $im = null;
    var $width = 73 ;
    var $height = 33 ;
    var $text = '' ; 
    var $line_distance = 8;
    var $text_len = 4 ;

    function phpfmgImage( $text = '', $len = 4 ){
        $this->text_len = $len ;
        $this->text = '' == $text ? $this->uniqid( $this->text_len ) : $text ;
        $this->text = strtoupper( substr( $this->text, 0, $this->text_len ) );
    }
    
    function create(){
        $this->im = imagecreate( $this->width, $this->height );
        $bgcolor   = imagecolorallocate($this->im, 255, 255, 255);
        $textcolor = imagecolorallocate($this->im, 0, 0, 0);
        $this->drawLines();
        imagestring($this->im, 5, 20, 9, $this->text, $textcolor);
    }
    
    function drawLines(){
        $linecolor = imagecolorallocate($this->im, 210, 210, 210);
    
        //vertical lines
        for($x = 0; $x < $this->width; $x += $this->line_distance) {
          imageline($this->im, $x, 0, $x, $this->height, $linecolor);
        };
    
        //horizontal lines
        for($y = 0; $y < $this->height; $y += $this->line_distance) {
          imageline($this->im, 0, $y, $this->width, $y, $linecolor);
        };
    }
    
    function out( $filename = '' ){
        if( function_exists('imageline') ){
            $this->create();
            if( '' == $filename ) header("Content-type: image/png");
            ( '' == $filename ) ? imagepng( $this->im ) : imagepng( $this->im, $filename );
            imagedestroy( $this->im ); 
        }else{
            $this->out_predefined_image(); 
        };
    }

    function uniqid( $len = 0 ){
        $md5 = md5( uniqid(rand()) );
        return $len > 0 ? substr($md5,0,$len) : $md5 ;
    }
    
    function out_predefined_image(){
        header("Content-type: image/png");
        $data = $this->getImage(); 
        echo base64_decode($data);
    }
    
    // Use predefined captcha random images if web server doens't have GD graphics library installed  
    function getImage(){
        $images = array(
			'6E84' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7WANEQxlCGRoCkMREpog0MDo6NCKLBbSINLA2BLSiiDWA1U0JQHJfZNTUsFWhq6KikNwXAjbP0QFFbyvIvMDQEAyxAGxuQRHD5uaBCj8qQizuAwDMpM2MroakDwAAAABJRU5ErkJggg==',
			'3738' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7RANEQx1DGaY6IIkFTGFodG10CAhAVtnK0OjQEOgggiw2BSwKUwd20sqoVdNWTV01NQvZfVMYAhgwzGN0YEA3r5W1AV0sYIpIAyuaXtEAkQZGNDcPVPhREWJxHwBhs80BOjPoWwAAAABJRU5ErkJggg==',
			'A97A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAd0lEQVR4nGNYhQEaGAYTpIn7GB0YQ1hDA1qRxVgDWIH8gKkOSGIiU0QaHRoCAgKQxAJagWKNjg4iSO6LWrp0adbSlVnTkNwX0MoY6DCFEaYODENDGRodAhhDQ1DMYwGahqouoJW1lbUBXQzoZjSxgQo/KkIs7gMAoL7MZC2/+KYAAAAASUVORK5CYII=',
			'FD43' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7QkNFQxgaHUIdkMQCGkRaGVodHQJQxRodpjo0iKCLBTo0BCC5LzRq2srMzKylWUjuA6lzbYSrQ4iFBmCa14hhRytDI7pbMN08UOFHRYjFfQAI+tAiYinY1wAAAABJRU5ErkJggg==',
			'49CD' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpI37pjCGMIQ6hjogi4WwtjI6BDoEIIkxhog0ujYIOoggibFOAYkxwsTATpo2benS1FUrs6YhuS9gCmMgkjowDA1laEQXY5jCgmEHwxRMt2B180CFH/UgFvcBALTuyxUh+SC4AAAAAElFTkSuQmCC',
			'C214' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nM2QsRHAIAhFv4UbmH3MBhTYOI0UbuBlgzRMGUs0lskl/O4Bxzugtyr4U17x8+wYDYUMC9VXMMQykiA7ow6sQGJDI+OXVU89NGfj1/t9ysVplzpLPNxwceFSZuZ5S3uKA/vqfw9m4XcBByjNtzRXdbsAAAAASUVORK5CYII=',
			'5C0C' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7QkMYQxmmMEwNQBILaGBtdAhlCBBBERNpcHR0dGBBEgsEqmBtCHRAdl/YtGmrlq6KzEJxXyuKOpxiAa2YdohMwXQLawCmmwcq/KgIsbgPANzTy8kGIcL8AAAAAElFTkSuQmCC',
			'179C' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7GB1EQx1CGaYGIImxOjA0Ojo6BIggiYkCxVwbAh1YUPQytLICxZDdtzJr1bSVmZFZyO4DqgtgCIGrg4oBRRvQxVgbGDHsEGlgRHdLCJCH5uaBCj8qQizuAwAmncgRjP8UkgAAAABJRU5ErkJggg==',
			'2BDA' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7WANEQ1hDGVqRxUSmiLSyNjpMdUASC2gVaXRtCAgIQNbdClTXEOggguy+aVPDlq6KzJqG7L4AFHVgyOgAMi8wNATZLQ1gMRR1Ig0gtziiiIWGgtzMiCI2UOFHRYjFfQBjQMw0StZM3AAAAABJRU5ErkJggg==',
			'FEC9' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAWklEQVR4nGNYhQEaGAYTpIn7QkNFQxlCHaY6IIkFNIg0MDoEBASgibE2CDqIYIgxwsTATgqNmhq2dNWqqDAk90HUMUzF1MvQgCkmgGEHplsw3TxQ4UdFiMV9AMwtzMLZ+PaoAAAAAElFTkSuQmCC',
			'0909' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7GB0YQximMEx1QBJjDWBtZQhlCAhAEhOZItLo6OjoIIIkFtAq0ujaEAgTAzspaunSpamroqLCkNwX0MoY6NoQMBVVLwNQb0CDCIodLEA7HFDswOYWbG4eqPCjIsTiPgBtCcuikUUcqgAAAABJRU5ErkJggg==',
			'7C31' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZklEQVR4nGNYhQEaGAYTpIn7QkMZgZChFUW0lbXRtdFhKqqYSINDQ0AoitgUkQaGRgeYXoiboqatWjV11VJk9zE6oKgDQ9YGoFhDAIqYSAPYDhSxgAawW9DEwG4ODRgE4UdFiMV9AJ1YzXz/ghO2AAAAAElFTkSuQmCC',
			'E108' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7QkMYAhimMEx1QBILaGAMYAhlCAhAEWMNYHR0dBBBEWMIYG0IgKkDOyk0alXU0lVRU7OQ3IemDkksEMM8bHaguyU0hDUU3c0DFX5UhFjcBwC4lcsGD1OriAAAAABJRU5ErkJggg==',
			'8A3A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcElEQVR4nGNYhQEaGAYTpIn7WAMYAhhDGVqRxUSmMIawNjpMdUASC2hlBaoJCAhAUSfS6NDo6CCC5L6lUdNWZk1dmTUNyX1o6qDmiYY6NASGhqCIAdU1BKKoA+l1RdPLGiDS6BjKiCI2UOFHRYjFfQCVo81zKWBnggAAAABJRU5ErkJggg==',
			'FF5E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAV0lEQVR4nGNYhQEaGAYTpIn7QkNFQ11DHUMDkMQCGkQaWBsYHRiIEZsKFwM7KTRqatjSzMzQLCT3gdQxNARi6MUmxopFjNHREVNvKCOKmwcq/KgIsbgPAOZVyyxOqZZ+AAAAAElFTkSuQmCC',
			'A2A1' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7GB0YQximMLQii7EGsLYyhDJMRRYTmSLS6OjoEIosFtDK0OgKIpHcF7V01dKlIBLJfUAVU1gR6sAwNJQhgDUUVSygldEBXV1AK2sDpphoKNDe0IBBEH5UhFjcBwD6as1WNC7L+wAAAABJRU5ErkJggg==',
			'1C20' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7GB0YQxlCGVqRxVgdWBsdHR2mOiCJiTqINLg2BAQEoOgVAZKBYBLmvpVZ04BEJoiEuw+srpURpg4hNgVTzCGAAc0OoFscGFDdEsIYyhoagOLmgQo/KkIs7gMAjjrJQu2vKgkAAAAASUVORK5CYII=',
			'0FBA' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7GB1EQ11DGVqRxVgDRBpYGx2mOiCJiUwBijUEBAQgiQW0gtQ5OogguS9q6dSwpaErs6YhuQ9NHUKsITA0BMOOQBR1ELeg6mUE8lhDGVHEBir8qAixuA8Ay0/LtXIdn4oAAAAASUVORK5CYII=',
			'E3DE' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAVElEQVR4nGNYhQEaGAYTpIn7QkNYQ1hDGUMDkMQCGkRaWRsdHRhQxBgaXRsC0cVaWRFiYCeFRq0KW7oqMjQLyX1o6vCZh0UM0y3Y3DxQ4UdFiMV9AP8KzBAkYpy0AAAAAElFTkSuQmCC',
			'EC72' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7QkMYQ1lDA6Y6IIkFNLA2OjQEBASgiIk0ODQEOoigiTEAVYoguS80atqqVUtXrYpCch9Y3RSQSjS9AQytDGhijg5AlWhucQWpRHdzA2NoyCAIPypCLO4DACgbzkH1X6T9AAAAAElFTkSuQmCC',
			'D6DD' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAW0lEQVR4nGNYhQEaGAYTpIn7QgMYQ1hDGUMdkMQCprC2sjY6OgQgi7WKNLI2BDqIoIo1IImBnRS1dFrY0lWRWdOQ3BfQKtqKRW+jKzFiWNyCzc0DFX5UhFjcBwDrms2ktvjBUAAAAABJRU5ErkJggg==',
			'4F04' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpI37poiGOkxhaAhAFgsRaWAIZWhEFmMEijE6OrQii7FOEWlgbQiYEoDkvmnTpoYtXRUVFYXkvgCwukAHZL2hoWCx0BAUt4DtQHXLFLBbMMXQ3TxQ4Uc9iMV9ALOlzYMFt7RqAAAAAElFTkSuQmCC',
			'37E9' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7RANEQ11DHaY6IIkFTGFodG1gCAhAVtkKEmN0EEEWm8LQyooQAztpZdSqaUtDV0WFIbtvCkMAawPDVBS9rYwOQLEGVDHWBqAYih0BU0RAYihuEQ0AiqG5eaDCj4oQi/sA7mzLFm2lGz8AAAAASUVORK5CYII=',
			'BB33' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAV0lEQVR4nGNYhQEaGAYTpIn7QgNEQxhDGUIdkMQCpoi0sjY6OgQgi7WKNDo0BDSIoKljAIsi3BcaNTVs1dRVS7OQ3IemDrd5OOxAdws2Nw9U+FERYnEfAJSZz71kkCGkAAAAAElFTkSuQmCC',
			'82D5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAc0lEQVR4nM2QMQ6AIAxFy9Ab1PvUgb0mMshpysAN8AgsnFLcSnDUxP7t5ad9KbRpFP6UT/xQ3I7BBTGMCmZMK9ueZEpet4FRgZt5Nn41tlrbEaPx672CKkrDPpCZOcZ+g0YXxcRi/VCW4AOc/IP/vZgHvwt4rsyQVkT71wAAAABJRU5ErkJggg==',
			'87A5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdElEQVR4nM2QsRGAMAhFk4IN4j6ksMeCwkyDRTaIbpAmU8pZEbXUu/C7d//gHa49RtxI+cUPaGIsnsmwUNyG7NH2KLstxtgx7WWQZUbjV1M7altTMn7aIxCS0O3zCHxnILoPQ3cjKCOyfkAX23GA/32YF78TNwTMfMCpu3cAAAAASUVORK5CYII=',
			'D40E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7QgMYWhmmMIYGIIkFTGGYyhDK6ICsLqAVKOLoiCbG6MraEAgTAzspaikQrIoMzUJyX0CrSCuSOqiYaKgrhhhDK4YdUxha0d2Czc0DFX5UhFjcBwDX4MslbivSjQAAAABJRU5ErkJggg==',
			'09DB' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7GB0YQ1hDGUMdkMRYA1hbWRsdHQKQxESmiDS6NgQ6iCCJBbRCxAKQ3Be1dOnS1FWRoVlI7gtoZQxEUgcVY8AwT2QKC4YYNrdgc/NAhR8VIRb3AQADpswOn+OBawAAAABJRU5ErkJggg==',
			'B985' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7QgMYQxhCGUMDkMQCprC2Mjo6OiCrC2gVaXRtCEQVmyLS6Ojo6OqA5L7QqKVLs0JXRkUhuS9gCmMg0LgGERTzGIDmBaCJsYDtEMFwi0MAsvsgbmaY6jAIwo+KEIv7AAetzQqnh9d5AAAAAElFTkSuQmCC',
			'7E6E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAX0lEQVR4nGNYhQEaGAYTpIn7QkNFQxlCGUMDkEVbRRoYHR0dGNDEWBvQxKaAxBhhYhA3RU0NWzp1ZWgWkvsYHYDq0MxjbQDpDUQRE8EiFtCA6ZaABixuHqDwoyLE4j4AUqXJOfrOpKkAAAAASUVORK5CYII=',
			'849B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7WAMYWhlCGUMdkMREpjBMZXR0dAhAEgsAqmJtCHQQQVHH6AoSC0By39KopUtXZkaGZiG5T2SKSCtDSCCaeaJAO1HNA9rRyohhB1AMzS3Y3DxQ4UdFiMV9AL+0yxpXZmqdAAAAAElFTkSuQmCC',
			'18E7' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAX0lEQVR4nGNYhQEaGAYTpIn7GB0YQ1hDHUNDkMRYHVhbWYG0CJKYqINIoyuaGCNUXQCS+1ZmrQxbGgqkkNwHVdeKai/YvClYxAIYMOxgdEAWEw0BuxlFbKDCj4oQi/sAkinIUhMfYPEAAAAASUVORK5CYII=',
			'DE5D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAY0lEQVR4nGNYhQEaGAYTpIn7QgNEQ1lDHUMdkMQCpog0sDYwOgQgi7VCxETQxabCxcBOilo6NWxpZmbWNCT3gdQxNARi6MUmxoouBnQLo6MjiltAbmYIZURx80CFHxUhFvcBAFBIzEguv9VhAAAAAElFTkSuQmCC',
			'851A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7WANEQxmmMLQii4lMEWlgCGGY6oAkFtAq0sAYwhAQgKouhGEKo4MIkvuWRk1dumrayqxpSO4TmcLQ6IBQBzUPLBYagmoHhjqRKaytDGhirAGMIYyhjihiAxV+VIRY3AcAQ6/LaskUfSgAAAAASUVORK5CYII=',
			'880D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXUlEQVR4nGNYhQEaGAYTpIn7WAMYQximMIY6IImJTGFtZQhldAhAEgtoFWl0dHR0EEFTx9oQCBMDO2lp1Mqwpasis6YhuQ9NHdw8Vyxi2OxAdws2Nw9U+FERYnEfABBUy1ffuFMmAAAAAElFTkSuQmCC',
			'F90A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7QkMZQximMLQiiwU0sLYyhDJMdUARE2l0dHQICEATc20IdBBBcl9o1NKlqasis6YhuS+ggTEQSR1UjAGkNzQERYwFaIcjmjqQWxjRxEBuRhUbqPCjIsTiPgBXXsz4LJ3j1wAAAABJRU5ErkJggg==',
			'69BA' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7WAMYQ1hDGVqRxUSmsLayNjpMdUASC2gRaXRtCAgIQBZrAIo1OjqIILkvMmrp0tTQlVnTkNwXMoUxEEkdRG8rA9C8wNAQFDEWkBiKOohbUPVC3MyIIjZQ4UdFiMV9AFX6zPN8t+7fAAAAAElFTkSuQmCC',
			'5FC6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7QkNEQx1CHaY6IIkFNIg0MDoEBASgibE2CDoIIIkFBoDEGB2Q3Rc2bWrY0lUrU7OQ3dcKVodiHlTMQQTZjlaIHchiIlMw3cIKtJcBzc0DFX5UhFjcBwDWscvFjRyY9AAAAABJRU5ErkJggg==',
			'EB8B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAATklEQVR4nGNYhQEaGAYTpIn7QkNEQxhCGUMdkMQCGkRaGR0dHQJQxRpdGwIdRHCrAzspNGpq2KrQlaFZSO4jwTxCduB080CFHxUhFvcBAK8MzKPn5ox8AAAAAElFTkSuQmCC',
			'4BBC' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpI37poiGsIYyTA1AFgsRaWVtdAgQQRJjDBFpdG0IdGBBEmOdAlLn6IDsvmnTpoYtDV2Zhey+AFR1YBgaCjEP1S2YdjBMwXQLVjcPVPhRD2JxHwDkj8wYfM1UZwAAAABJRU5ErkJggg==',
			'910F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaUlEQVR4nGNYhQEaGAYTpIn7WAMYAhimMIaGIImJTGEMYAhldEBWF9DKGsDo6IgmxhDA2hAIEwM7adrUVVFLV0WGZiG5j9UVRR0EtmKKCQDF0O0QmcKA4RbWANZQoJtRzRug8KMixOI+ALWzxtByUZP7AAAAAElFTkSuQmCC',
			'F62C' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7QkMZQxhCGaYGIIkFNLC2Mjo6BIigiIk0sjYEOrCgigHJQAdk94VGTQtbtTIzC9l9AQ2irQytjA4MaOY5TMEiFsCIZgcrSCeaWxhDWEMDUNw8UOFHRYjFfQCSxMu61vWe5QAAAABJRU5ErkJggg==',
			'9795' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAeUlEQVR4nGNYhQEaGAYTpIn7WANEQx1CGUMDkMREpjA0Ojo6OiCrC2hlaHRtCEQXa2VtCHR1QHLftKmrpq3MjIyKQnIfqytDAENIQIMIss2tjECzUMUEgKYxAu1AFhOZItLA6OgQgOw+1gCgilCGqQ6DIPyoCLG4DwDMS8sJwDhp0AAAAABJRU5ErkJggg==',
			'DA40' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7QgMYAhgaHVqRxQKmMIYwtDpMdUAWa2VtZZjqEBCAIibS6BDo6CCC5L6opdNWZmZmZk1Dch9InWsjXB1UTDTUNTQQTQxoXiOaHVPAYihuCQ0Ai6G4eaDCj4oQi/sAC4vPkw4JNgEAAAAASUVORK5CYII=',
			'66A5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7WAMYQximMIYGIImJTGFtZQhldEBWF9Ai0sjo6Igq1iDSwNoQ6OqA5L7IqGlhS4FkFJL7QqaItrKCVSPpbRVpdA3FItYQ6CCC5hag3gBk94HcDBSb6jAIwo+KEIv7APh6zH+dzuPhAAAAAElFTkSuQmCC',
			'ABA7' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7GB1EQximMIaGIImxBoi0MoQyNIggiYlMEWl0dHRAEQtoFWllbQgAQoT7opZODVu6KmplFpL7oOpake0NDRVpdA0NmMKAal6ja0NAAAOGHYEOqGKiIehiAxV+VIRY3AcAeFjNghdhOA8AAAAASUVORK5CYII=',
			'962D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7WAMYQxhCGUMdkMREprC2Mjo6OgQgiQW0ijSyNgQ6iKCKAUm4GNhJ06ZOC1u1MjNrGpL7WF1FWxlaGVH0MgDNc5iCKiYAEgtAFQO7xYERxS0gN7OGBqK4eaDCj4oQi/sArJ/KGF+ar6EAAAAASUVORK5CYII=',
			'6D1F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7WANEQximMIaGIImJTBFpZQhhdEBWF9Ai0uiILtYg0ugwBS4GdlJk1LSVWdNWhmYhuS9kCoo6iN5W4sTAbkETA7mZMdQRRWygwo+KEIv7AABwymtA0FZ0AAAAAElFTkSuQmCC',
			'0AD1' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7GB0YAlhDGVqRxVgDGENYGx2mIouJTGFtZW0ICEUWC2gVaXQFksjui1o6bWUqkER2H5o6qJhoKLqYyBRMdawBQLFGBxQxRgegWChDaMAgCD8qQizuAwAlks1UMHIflAAAAABJRU5ErkJggg==',
			'0D1A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZUlEQVR4nGNYhQEaGAYTpIn7GB1EQximMLQii7EGiLQyhDBMdUASE5ki0ugYwhAQgCQW0CrS6DCF0UEEyX1RS6etzAIhJPehqUMWCw1BswNdHdgtaGIgNzOGOqKIDVT4URFicR8AQBLLXhxPRgcAAAAASUVORK5CYII=',
			'34EA' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7RAMYWllDHVqRxQKmMExlbWCY6oCsspUhFCgWEIAsNoXRlbWB0UEEyX0ro5YuXRq6MmsasvumiLQiqYOaJxrq2sAYGoJqB4Y6oFswxCBudkQ1b4DCj4oQi/sA2nHKL60N2AUAAAAASUVORK5CYII=',
			'E360' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7QkNYQxhCGVqRxQIaRFoZHR2mOqCIMTS6NjgEBKCKtbI2MDqIILkvNGpV2NKpK7OmIbkPrM7REaYOybxALGIBaHZgugWbmwcq/KgIsbgPAFVRzSsmZLpxAAAAAElFTkSuQmCC',
			'BBBB' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAUElEQVR4nGNYhQEaGAYTpIn7QgNEQ1hDGUMdkMQCpoi0sjY6OgQgi7WKNLo2BDqI4FYHdlJo1NSwpaErQ7OQ3Ee0eYTtwOnmgQo/KkIs7gMAfEfODzRWa6MAAAAASUVORK5CYII=',
			'F0CE' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAV0lEQVR4nGNYhQEaGAYTpIn7QkMZAhhCHUMDkMQCGhhDGB0CHRhQxFhbWRsE0cREGl0bGGFiYCeFRk1bmbpqZWgWkvvQ1OERw2YHNrdgunmgwo+KEIv7AGxfys/U2AaFAAAAAElFTkSuQmCC',
			'1742' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdElEQVR4nGNYhQEaGAYTpIn7GB1EQx0aHaY6IImxOjA0OrQ6BAQgiYmCxKY6Ooig6GVoZQh0aBBBct/KrFXTVmZmrYpCch9QXQBrI9AWFL2MDqyhAa2obmFtANoyBVVMBCQWgCwmGgIScwwNGQThR0WIxX0AIcfKZ+Rn1hwAAAAASUVORK5CYII=',
			'20C2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7WAMYAhhCHaY6IImJTGEMYXQICAhAEgtoZW1lbRB0EEHW3SrS6ApSj+y+adNWpgKpKGT3BYDVNSLbwegAFmtFcUsDyA6BKchiIg0QtyCLhYaC3OwYGjIIwo+KEIv7ACFNy0arvPf1AAAAAElFTkSuQmCC',
			'CA25' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdklEQVR4nGNYhQEaGAYTpIn7WEMYAhhCGUMDkMREWhlDGB0dHZDVBTSytrI2BKKKNYg0OjQEujoguS9q1bSVWSszo6KQ3AdW1wo0F0WvaKjDFDSxRqC6AEYHERS3iDQCXRKA7D7WEJFG19CAqQ6DIPyoCLG4DwClxswmMrypFAAAAABJRU5ErkJggg==',
			'5EF3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAX0lEQVR4nGNYhQEaGAYTpIn7QkNEQ1lDA0IdkMQCGkQaWBsYHQIwxBiAJEIsMAAiFoDkvrBpU8OWhq5amoXsvlYUdShiyOYFYBETmYLpFtYAoJsbGFDcPFDhR0WIxX0AHTXL9WzaCqgAAAAASUVORK5CYII=',
			'7E45' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7QkNFQxkaHUMDkEVbRYDY0YEBXWwqmtgUoFigo6sDsvuipoatzMyMikJyH6ODSANro0ODCJJeViCPFWgrspgIiNfo6IAsBlbR6BAQgCIGcrPDVIdBEH5UhFjcBwBVmsvK3qWpugAAAABJRU5ErkJggg==',
			'674A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7WANEQx0aHVqRxUSmMABFHKY6IIkFtADFpjoEBCCLNTC0MgQ6OogguS8yatW0lZmZWdOQ3BcyhSGAtRGuDqK3ldGBNTQwNARFjLWBAU2dyBQRDDHWAEyxgQo/KkIs7gMAQ/nMxE9+SJQAAAAASUVORK5CYII=',
			'17C8' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7GB1EQx1CHaY6IImxOjA0OjoEBAQgiYkCxVwbBB1EUPQytLI2MMDUgZ20MmvVtKWrVk3NQnIfUF0AkjqoGKMDK5BENY+1gRXDDhEgRnNLCFAFmpsHKvyoCLG4DwCiGMk8SB2g7AAAAABJRU5ErkJggg==',
			'54E5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7QkMYWllDHUMDkMSA7KmsDYwODKhioehigQGMrkAxVwck94VNW7p0aejKqChk97WKtLICaRFkm1tFQ13RxAJagW4B2oEsJjIFJMYQgOw+1gCQmx2mOgyC8KMixOI+AB9AypyxVUsuAAAAAElFTkSuQmCC',
			'BB3A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYklEQVR4nGNYhQEaGAYTpIn7QgNEQxhDGVqRxQKmiLSyNjpMdUAWaxVpdGgICAhAU8fQ6OggguS+0KipYaumrsyahuQ+NHVI5gWGhmCKoaoDuwVVL8TNjChiAxV+VIRY3AcACUzOUlDDvOsAAAAASUVORK5CYII=',
			'2229' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7WAMYQxhCGaY6IImJTGFtZXR0CAhAEgtoFWl0bQh0EEHW3crQ6IAQg7hp2qqlq1ZmRYUhuy+AYQpQ7VRkvYwOYNEGZDFWiCiKHSJQUWS3hIaKhrqGBqC4eaDCj4oQi/sAaUHKsIeYbxkAAAAASUVORK5CYII=',
			'3320' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7RANYQxhCGVqRxQKmiLQyOjpMdUBW2crQ6NoQEBCALDYFpC/QQQTJfSujVoWtWpmZNQ3ZfSB1rYwwdXDzHKZgEQtgQLED7BYHBhS3gNzMGhqA4uaBCj8qQizuAwAauctHJS5sFQAAAABJRU5ErkJggg==',
			'F6BC' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYElEQVR4nGNYhQEaGAYTpIn7QkMZQ1hDGaYGIIkFNLC2sjY6BIigiIk0sjYEOrCgijWwNjo6ILsvNGpa2NLQlVnI7gtoEG1FUgc3zxVoHjYxVDuwuQXTzQMVflSEWNwHADDwzRyw2t1qAAAAAElFTkSuQmCC',
			'1E5F' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7GB1EQ1lDHUNDkMRYHUQaWIEyyOpEsYgxgsSmwsXATlqZNTVsaWZmaBaS+0DqGBoCMfRiE2PFIsbo6IjqlhDRUIZQVLcMVPhREWJxHwC5NsYkK/YcPwAAAABJRU5ErkJggg==',
			'0726' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAeklEQVR4nGNYhQEaGAYTpIn7GB1EQx1CGaY6IImxBjA0Ojo6BAQgiYlMYWh0bQh0EEASC2hlaGUAiiG7L2rpqmmrVmamZiG5D6gugKGVEcW8gFZGB4YpjA4iKHawNjAEoIqxBogA3ciAohekgjU0AMXNAxV+VIRY3AcAZGXKlps/I2MAAAAASUVORK5CYII=',
			'A17A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7GB0YAlhDA1qRxVgDGAMYGgKmOiCJiUxhBYkFBCCJAXUFMDQ6OogguS9q6aqoVUtXZk1Dch9Y3RRGmDowDA0FigUwhoagmcfogKoOJMbagC7GGoouNlDhR0WIxX0ASd7JvtZS5N0AAAAASUVORK5CYII=',
			'8C80' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAX0lEQVR4nGNYhQEaGAYTpIn7WAMYQxlCGVqRxUSmsDY6OjpMdUASC2gVaXBtCAgIQFEn0sAIVCiC5L6lUdNWrQpdmTUNyX1o6uDmsTYEYohh2oHpFmxuHqjwoyLE4j4AzrfMu7yId+cAAAAASUVORK5CYII=',
			'053A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdElEQVR4nGNYhQEaGAYTpIn7GB1EQxlDGVqRxVgDRBpYGx2mOiCJiUwRAZIBAQFIYgGtIiEMjY4OIkjui1o6demqqSuzpiG5L6CVodEBoQ4h1hAYGoJqB0gMRR1rAGsrK5peRgfGEMZQRhSxgQo/KkIs7gMAKUPMDuI6SJoAAAAASUVORK5CYII=',
			'7AB5' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcklEQVR4nGNYhQEaGAYTpIn7QkMZAlhDGUMDkEVbGUNYGx0dUFS2srayNgSiik0RaXRtdHR1QHZf1LSVqaEro6KQ3MfoAFLn0CCCpJe1QTTUtSEARUykAagOaAeyWEADWG9AALpYKMNUh0EQflSEWNwHAELwzNSgHRYpAAAAAElFTkSuQmCC',
			'0ED7' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7GB1EQ1lDGUNDkMRYA0QaWBsdGkSQxESmAMUaAlDEAlohYgFI7otaOjVs6aqolVlI7oOqa2XA1DuFAdOOAAYMtzg6YHEzithAhR8VIRb3AQDrA8vCv2ALvQAAAABJRU5ErkJggg==',
			'29E8' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZklEQVR4nGNYhQEaGAYTpIn7WAMYQ1hDHaY6IImJTGFtZW1gCAhAEgtoFWl0bWB0EEHWDRaDq4O4adrSpamhq6ZmIbsvgDHQFc08RgcGDPNYG1gwxEQaMN0SGorp5oEKPypCLO4DADsdy2MWmwidAAAAAElFTkSuQmCC',
			'63BB' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXUlEQVR4nGNYhQEaGAYTpIn7WANYQ1hDGUMdkMREpoi0sjY6OgQgiQW0MDS6NgQ6iCCLNTAgqwM7KTJqVdjS0JWhWUjuC5nCgGleKxbzsIhhcws2Nw9U+FERYnEfAHzczHu61Im7AAAAAElFTkSuQmCC',
			'D8C6' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7QgMYQxhCHaY6IIkFTGFtZXQICAhAFmsVaXRtEHQQQBFjbWVtYHRAdl/U0pVhS1etTM1Cch9UHRbzGB1EsNghQsAt2Nw8UOFHRYjFfQCrIM1oZm8+iQAAAABJRU5ErkJggg==',
			'D1F3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7QgMYAlhDA0IdkMQCpjAGsDYwOgQgi7WyAsUYGkRQxBjAYgFI7otaCkShq5ZmIbkPTR2KGDbzUMSmMGC4JRToYqA6FDcPVPhREWJxHwB95suWyr6ySQAAAABJRU5ErkJggg==',
			'727B' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdUlEQVR4nGNYhQEaGAYTpIn7QkMZQ1hDA0MdkEVbWVsZGgIdAlDERBodgGIiyGJTGBodGh1h6iBuilq1dNXSlaFZSO5jdACqnMKIYh5rA0MAQwAjinkiQJUgiCwWAFTJ2oCqN6BBNNS1gRHVzQMUflSEWNwHAP2fywnp73hOAAAAAElFTkSuQmCC',
			'B340' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZUlEQVR4nGNYhQEaGAYTpIn7QgNYQxgaHVqRxQKmiLQytDpMdUAWawWqmuoQEICijqGVIdDRQQTJfaFRq8JWZmZmTUNyH0gdayNcHdw819BADDGHRnQ7RCA2E3DzQIUfFSEW9wEAHWTOkYmq3kUAAAAASUVORK5CYII=',
			'8E6E' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAWUlEQVR4nGNYhQEaGAYTpIn7WANEQxlCGUMDkMREpog0MDo6OiCrC2gVaWBtQBUDqWNtYISJgZ20NGpq2NKpK0OzkNwHVofVvECCYtjcgs3NAxV+VIRY3AcAEHzJu4p/2nYAAAAASUVORK5CYII=',
			'BACF' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7QgMYAhhCHUNDkMQCpjCGMDoEOiCrC2hlbWVtEEQVmyLS6NrACBMDOyk0atrK1FUrQ7OQ3IemDmqeaCimGEgdph2OaG4JDRBpdAh1RBEbqPCjIsTiPgB2rcvCABEVGAAAAABJRU5ErkJggg==',
			'CB13' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7WENEQximMIQ6IImJtIq0MoQwOgQgiQU0ijQ6hgDlkMWAKoF6GwKQ3Be1amrYqmmrlmYhuQ9NHUys0WEKmnmNmGJgt0xBdQvIzYyhDihuHqjwoyLE4j4AWqvNPZD+3/4AAAAASUVORK5CYII=',
			'DD16' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7QgNEQximMEx1QBILmCLSyhDCEBCALNYq0ugYwugggCbmMIXRAdl9UUunrcyatjI1C8l9UHUY5oH0ihASA7llCqpbQG5mDHVAcfNAhR8VIRb3AQAyU83n8mw67gAAAABJRU5ErkJggg==',
			'7C7D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAb0lEQVR4nGNYhQEaGAYTpIn7QkMZQ1lDA0MdkEVbWRsdGgIdAlDERBpAYiLIYlOAvEZHmBjETVHTVq1aujJrGpL7GEEqpjCi6GVtAPICUMVEgNDRAVUsoIG10RVoQgCKGNDNQIzi5gEKPypCLO4DAJ8sy5aaQS8SAAAAAElFTkSuQmCC',
			'C6C2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbElEQVR4nGNYhQEaGAYTpIn7WEMYQxhCHaY6IImJtLK2MjoEBAQgiQU0ijSyNgg6iCCLNYg0sILUI7kvatW0sKVgGuG+gAbRVqC6RgdUvY2uDQytDGh2uDYITGHA4hZMNzuGhgyC8KMixOI+AKjzzJCCkj+rAAAAAElFTkSuQmCC',
			'606D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaElEQVR4nGNYhQEaGAYTpIn7WAMYAhhCGUMdkMREpjCGMDo6OgQgiQW0sLayNjg6iCCLNYg0ujYwwsTAToqMmrYyderKrGlI7guZAlTniKa3FaQ3EE0MZAeqGDa3YHPzQIUfFSEW9wEAr/fLDAY42xEAAAAASUVORK5CYII=',
			'D805' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7QgMYQximMIYGIIkFTGFtZQhldEBWF9Aq0ujo6IgmxtrK2hDo6oDkvqilK8OWroqMikJyH0RdQIMImnmuWMRAdohguIUhANl9EDczTHUYBOFHRYjFfQAmIM0m8dRCWgAAAABJRU5ErkJggg==',
			'EC4D' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYUlEQVR4nGNYhQEaGAYTpIn7QkMYQxkaHUMdkMQCGlgbHVodHQJQxEQaHKY6OoigiTEEwsXATgqNmrZqZWZm1jQk94HUsTZi6mUNDcQQc8BQB3RLI6pbsLl5oMKPihCL+wBVr83pLBo3rgAAAABJRU5ErkJggg==',
			'87CF' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7WANEQx1CHUNDkMREpjA0OjoEOiCrC2hlaHRtEEQRA6prZW1ghImBnbQ0atW0patWhmYhuQ+oLgBJHdQ8RgdMMdYGVgw7RICqUN3CGiDSwBDqiCI2UOFHRYjFfQBj2cmwHtl+ZQAAAABJRU5ErkJggg==',
			'0613' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbklEQVR4nGNYhQEaGAYTpIn7GB0YQximMIQ6IImxBrC2MoQwOgQgiYlMEWkEqmwQQRILaAXypgBpJPdFLZ0WtmraqqVZSO4LaBVtRVIH09voMAXVPJAd6GJgt0xBdQvIzYyhDihuHqjwoyLE4j4AXajLtDP9dh8AAAAASUVORK5CYII=',
			'8BA0' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZElEQVR4nGNYhQEaGAYTpIn7WANEQximMLQii4lMEWllCGWY6oAkFtAq0ujo6BAQgKaOtSHQQQTJfUujpoYtXRWZNQ3JfWjq4Oa5hmIRawjAYkcAiltAbgaKobh5oMKPihCL+wCKU82MQmHalgAAAABJRU5ErkJggg==',
			'D632' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAZ0lEQVR4nGNYhQEaGAYTpIn7QgMYQxhDGaY6IIkFTGFtZW10CAhAFmsVaWRoCHQQQRVrYGh0aBBBcl/U0mlhq6YCaST3BbSKtgLVNTqgmecAJBkwxaYwYHELppsZQ0MGQfhREWJxHwCRS87lkZGCxgAAAABJRU5ErkJggg==',
			'38D8' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAWklEQVR4nGNYhQEaGAYTpIn7RAMYQ1hDGaY6IIkFTGFtZW10CAhAVtkq0ujaEOgggiwGUtcQAFMHdtLKqJVhS1dFTc1Cdh+qOtzmYRHD5hZsbh6o8KMixOI+AFNXzSH6oyjAAAAAAElFTkSuQmCC',
			'5634' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAcUlEQVR4nGNYhQEaGAYTpIn7QkMYQxhDGRoCkMQCGlhbWRsdGlHFRBqBZCuyWGCASANDo8OUACT3hU2bFrZq6qqoKGT3tYq2MjQ6OiDrZWgVaXRoCAwNQbYDLBaA4haRKWC3oIixBmC6eaDCj4oQi/sAmLXO4NqP30MAAAAASUVORK5CYII=',
			'043A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAdElEQVR4nGNYhQEaGAYTpIn7GB0YWhlDGVqRxVgDGKayNjpMdUASE5nCEMrQEBAQgCQW0MroytDo6CCC5L6opUuXrpq6MmsakvsCWkVakdRBxURDHRoCQ0NQ7QC6IxBFHdAtraxoeiFuZkQRG6jwoyLE4j4AaCTLdf9kJ+8AAAAASUVORK5CYII=',
			'EFD2' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAXklEQVR4nGNYhQEaGAYTpIn7QkNEQ11DGaY6IIkFNIg0sDY6BASgizUEOohgiIFIhPtCo6aGLV0VBYQI90HVNWLY0RDQyoApNgVDDOgWVDcDxUIZQ0MGQfhREWJxHwAhMc55s9I71gAAAABJRU5ErkJggg==',
			'3C55' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAa0lEQVR4nGNYhQEaGAYTpIn7RAMYQ1lDHUMDkMQCprA2ujYwOqCobBVpwBCbItLAOpXR1QHJfSujpq1ampkZFYXsPqA6oKkNImjmYRNzbQh0QBYDucXR0SEA2X0gNzOEMkx1GAThR0WIxX0Aeg/LyOn9as0AAAAASUVORK5CYII=',
			'864A' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAbUlEQVR4nGNYhQEaGAYTpIn7WAMYQxgaHVqRxUSmsLYytDpMdUASC2gVaWSY6hAQgKJOpIEh0NFBBMl9S6Omha3MzMyahuQ+kSmirayNcHVw81xDA0ND0MQc0NSB3YImBnEzqthAhR8VIRb3AQDC4cyReyBhRAAAAABJRU5ErkJggg==',
			'B378' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAaklEQVR4nGNYhQEaGAYTpIn7QgNYQ1hDA6Y6IIkFTBFpBZIBAchirQyNDg2BDiIo6hhAojB1YCeFRq0KW7V01dQsJPeB1U1hwDQvgBHVPKCYowOaGNAtrA2oesFubmBAcfNAhR8VIRb3AQCU383fM+orWAAAAABJRU5ErkJggg==',
			'73D3' => 'iVBORw0KGgoAAAANSUhEUgAAAEkAAAAhAgMAAADoum54AAAACVBMVEX///8AAADS0tIrj1xmAAAAYklEQVR4nGNYhQEaGAYTpIn7QkNZQ1hDGUIdkEVbRVpZGx0dAlDEGBpdGwIaRJDFpjC0sgLFApDdF7UqbOmqqKVZSO5jdEBRB4asDZjmiWARA/Iw3BLQgMXNAxR+VIRY3AcAs5fNizhN6OEAAAAASUVORK5CYII='        
        );
        $this->text = array_rand( $images );
        return $images[ $this->text ] ;    
    }
    
    function out_processing_gif(){
        $image = dirname(__FILE__) . '/processing.gif';
        $base64_image = "R0lGODlhFAAUALMIAPh2AP+TMsZiALlcAKNOAOp4ANVqAP+PFv///wAAAAAAAAAAAAAAAAAAAAAAAAAAACH/C05FVFNDQVBFMi4wAwEAAAAh+QQFCgAIACwAAAAAFAAUAAAEUxDJSau9iBDMtebTMEjehgTBJYqkiaLWOlZvGs8WDO6UIPCHw8TnAwWDEuKPcxQml0Ynj2cwYACAS7VqwWItWyuiUJB4s2AxmWxGg9bl6YQtl0cAACH5BAUKAAgALAEAAQASABIAAAROEMkpx6A4W5upENUmEQT2feFIltMJYivbvhnZ3Z1h4FMQIDodz+cL7nDEn5CH8DGZhcLtcMBEoxkqlXKVIgAAibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkphaA4W5upMdUmDQP2feFIltMJYivbvhnZ3V1R4BNBIDodz+cL7nDEn5CH8DGZAMAtEMBEoxkqlXKVIg4HibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpjaE4W5tpKdUmCQL2feFIltMJYivbvhnZ3R0A4NMwIDodz+cL7nDEn5CH8DGZh8ONQMBEoxkqlXKVIgIBibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpS6E4W5spANUmGQb2feFIltMJYivbvhnZ3d1x4JMgIDodz+cL7nDEn5CH8DGZgcBtMMBEoxkqlXKVIggEibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpAaA4W5vpOdUmFQX2feFIltMJYivbvhnZ3V0Q4JNhIDodz+cL7nDEn5CH8DGZBMJNIMBEoxkqlXKVIgYDibbK9YLBYvLtHH5K0J0IACH5BAUKAAgALAEAAQASABIAAAROEMkpz6E4W5tpCNUmAQD2feFIltMJYivbvhnZ3R1B4FNRIDodz+cL7nDEn5CH8DGZg8HNYMBEoxkqlXKVIgQCibbK9YLBYvLtHH5K0J0IACH5BAkKAAgALAEAAQASABIAAAROEMkpQ6A4W5spIdUmHQf2feFIltMJYivbvhnZ3d0w4BMAIDodz+cL7nDEn5CH8DGZAsGtUMBEoxkqlXKVIgwGibbK9YLBYvLtHH5K0J0IADs=";
        $binary = is_file($image) ? join("",file($image)) : base64_decode($base64_image); 
        header("Cache-Control: post-check=0, pre-check=0, max-age=0, no-store, no-cache, must-revalidate");
        header("Pragma: no-cache");
        header("Content-type: image/gif");
        echo $binary;
    }

}
# end of class phpfmgImage
# ------------------------------------------------------
# end of module : captcha


# module user
# ------------------------------------------------------
function phpfmg_user_isLogin(){
    return ( isset($_SESSION['authenticated']) && true === $_SESSION['authenticated'] );
}


function phpfmg_user_logout(){
    session_destroy();
    header("Location: admin.php");
}

function phpfmg_user_login()
{
    if( phpfmg_user_isLogin() ){
        return true ;
    };
    
    $sErr = "" ;
    if( 'Y' == $_POST['formmail_submit'] ){
        if(
            defined( 'PHPFMG_USER' ) && strtolower(PHPFMG_USER) == strtolower($_POST['Username']) &&
            defined( 'PHPFMG_PW' )   && strtolower(PHPFMG_PW) == strtolower($_POST['Password']) 
        ){
             $_SESSION['authenticated'] = true ;
             return true ;
             
        }else{
            $sErr = 'Login failed. Please try again.';
        }
    };
    
    // show login form 
    phpfmg_admin_header();
?>
<form name="frmFormMail" action="" method='post' enctype='multipart/form-data'>
<input type='hidden' name='formmail_submit' value='Y'>
<br><br><br>

<center>
<div style="width:380px;height:260px;">
<fieldset style="padding:18px;" >
<table cellspacing='3' cellpadding='3' border='0' >
	<tr>
		<td class="form_field" valign='top' align='right'>Email :</td>
		<td class="form_text">
            <input type="text" name="Username"  value="<?php echo $_POST['Username']; ?>" class='text_box' >
		</td>
	</tr>

	<tr>
		<td class="form_field" valign='top' align='right'>Password :</td>
		<td class="form_text">
            <input type="password" name="Password"  value="" class='text_box'>
		</td>
	</tr>

	<tr><td colspan=3 align='center'>
        <input type='submit' value='Login'><br><br>
        <?php if( $sErr ) echo "<span style='color:red;font-weight:bold;'>{$sErr}</span><br><br>\n"; ?>
        <a href="admin.php?mod=mail&func=request_password">I forgot my password</a>   
    </td></tr>
</table>
</fieldset>
</div>
<script type="text/javascript">
    document.frmFormMail.Username.focus();
</script>
</form>
<?php
    phpfmg_admin_footer();
}


function phpfmg_mail_request_password(){
    $sErr = '';
    if( $_POST['formmail_submit'] == 'Y' ){
        if( strtoupper(trim($_POST['Username'])) == strtoupper(trim(PHPFMG_USER)) ){
            phpfmg_mail_password();
            exit;
        }else{
            $sErr = "Failed to verify your email.";
        };
    };
    
    $n1 = strpos(PHPFMG_USER,'@');
    $n2 = strrpos(PHPFMG_USER,'.');
    $email = substr(PHPFMG_USER,0,1) . str_repeat('*',$n1-1) . 
            '@' . substr(PHPFMG_USER,$n1+1,1) . str_repeat('*',$n2-$n1-2) . 
            '.' . substr(PHPFMG_USER,$n2+1,1) . str_repeat('*',strlen(PHPFMG_USER)-$n2-2) ;


    phpfmg_admin_header("Request Password of Email Form Admin Panel");
?>
<form name="frmRequestPassword" action="admin.php?mod=mail&func=request_password" method='post' enctype='multipart/form-data'>
<input type='hidden' name='formmail_submit' value='Y'>
<br><br><br>

<center>
<div style="width:580px;height:260px;text-align:left;">
<fieldset style="padding:18px;" >
<legend>Request Password</legend>
Enter Email Address <b><?php echo strtoupper($email) ;?></b>:<br />
<input type="text" name="Username"  value="<?php echo $_POST['Username']; ?>" style="width:380px;">
<input type='submit' value='Verify'><br>
The password will be sent to this email address. 
<?php if( $sErr ) echo "<br /><br /><span style='color:red;font-weight:bold;'>{$sErr}</span><br><br>\n"; ?>
</fieldset>
</div>
<script type="text/javascript">
    document.frmRequestPassword.Username.focus();
</script>
</form>
<?php
    phpfmg_admin_footer();    
}


function phpfmg_mail_password(){
    phpfmg_admin_header();
    if( defined( 'PHPFMG_USER' ) && defined( 'PHPFMG_PW' ) ){
        $body = "Here is the password for your form admin panel:\n\nUsername: " . PHPFMG_USER . "\nPassword: " . PHPFMG_PW . "\n\n" ;
        if( 'html' == PHPFMG_MAIL_TYPE )
            $body = nl2br($body);
        mailAttachments( PHPFMG_USER, "Password for Your Form Admin Panel", $body, PHPFMG_USER, 'You', "You <" . PHPFMG_USER . ">" );
        echo "<center>Your password has been sent.<br><br><a href='admin.php'>Click here to login again</a></center>";
    };   
    phpfmg_admin_footer();
}


function phpfmg_writable_check(){
 
    if( is_writable( dirname(PHPFMG_SAVE_FILE) ) && is_writable( dirname(PHPFMG_EMAILS_LOGFILE) )  ){
        return ;
    };
?>
<style type="text/css">
    .fmg_warning{
        background-color: #F4F6E5;
        border: 1px dashed #ff0000;
        padding: 16px;
        color : black;
        margin: 10px;
        line-height: 180%;
        width:80%;
    }
    
    .fmg_warning_title{
        font-weight: bold;
    }

</style>
<br><br>
<div class="fmg_warning">
    <div class="fmg_warning_title">Your form data or email traffic log is NOT saving.</div>
    The form data (<?php echo PHPFMG_SAVE_FILE ?>) and email traffic log (<?php echo PHPFMG_EMAILS_LOGFILE?>) will be created automatically when the form is submitted. 
    However, the script doesn't have writable permission to create those files. In order to save your valuable information, please set the directory to writable.
     If you don't know how to do it, please ask for help from your web Administrator or Technical Support of your hosting company.   
</div>
<br><br>
<?php
}


function phpfmg_log_view(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );
    
    phpfmg_admin_header();
   
    $file = $files[$n];
    if( is_file($file) ){
        if( 1== $n ){
            echo "<pre>\n";
            echo join("",file($file) );
            echo "</pre>\n";
        }else{
            $man = new phpfmgDataManager();
            $man->displayRecords();
        };
     

    }else{
        echo "<b>No form data found.</b>";
    };
    phpfmg_admin_footer();
}


function phpfmg_log_download(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );

    $file = $files[$n];
    if( is_file($file) ){
        phpfmg_util_download( $file, PHPFMG_SAVE_FILE == $file ? 'form-data.csv' : 'email-traffics.txt', true, 1 ); // skip the first line
    }else{
        phpfmg_admin_header();
        echo "<b>No email traffic log found.</b>";
        phpfmg_admin_footer();
    };

}


function phpfmg_log_delete(){
    $n = isset($_REQUEST['file'])  ? $_REQUEST['file']  : '';
    $files = array(
        1 => PHPFMG_EMAILS_LOGFILE,
        2 => PHPFMG_SAVE_FILE,
    );
    phpfmg_admin_header();

    $file = $files[$n];
    if( is_file($file) ){
        echo unlink($file) ? "It has been deleted!" : "Failed to delete!" ;
    };
    phpfmg_admin_footer();
}


function phpfmg_util_download($file, $filename='', $toCSV = false, $skipN = 0 ){
    if (!is_file($file)) return false ;

    set_time_limit(0);


    $buffer = "";
    $i = 0 ;
    $fp = @fopen($file, 'rb');
    while( !feof($fp)) { 
        $i ++ ;
        $line = fgets($fp);
        if($i > $skipN){ // skip lines
            if( $toCSV ){ 
              $line = str_replace( chr(0x09), ',', $line );
              $buffer .= phpfmg_data2record( $line, false );
            }else{
                $buffer .= $line;
            };
        }; 
    }; 
    fclose ($fp);
  

    
    /*
        If the Content-Length is NOT THE SAME SIZE as the real conent output, Windows+IIS might be hung!!
    */
    $len = strlen($buffer);
    $filename = basename( '' == $filename ? $file : $filename );
    $file_extension = strtolower(substr(strrchr($filename,"."),1));

    switch( $file_extension ) {
        case "pdf": $ctype="application/pdf"; break;
        case "exe": $ctype="application/octet-stream"; break;
        case "zip": $ctype="application/zip"; break;
        case "doc": $ctype="application/msword"; break;
        case "xls": $ctype="application/vnd.ms-excel"; break;
        case "ppt": $ctype="application/vnd.ms-powerpoint"; break;
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpg"; break;
        case "mp3": $ctype="audio/mpeg"; break;
        case "wav": $ctype="audio/x-wav"; break;
        case "mpeg":
        case "mpg":
        case "mpe": $ctype="video/mpeg"; break;
        case "mov": $ctype="video/quicktime"; break;
        case "avi": $ctype="video/x-msvideo"; break;
        //The following are for extensions that shouldn't be downloaded (sensitive stuff, like php files)
        case "php":
        case "htm":
        case "html": 
                $ctype="text/plain"; break;
        default: 
            $ctype="application/x-download";
    }
                                            

    //Begin writing headers
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
    //Use the switch-generated Content-Type
    header("Content-Type: $ctype");
    //Force the download
    header("Content-Disposition: attachment; filename=".$filename.";" );
    header("Content-Transfer-Encoding: binary");
    header("Content-Length: ".$len);
    
    while (@ob_end_clean()); // no output buffering !
    flush();
    echo $buffer ;
    
    return true;
 
    
}
?>