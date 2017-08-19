Fast Secure Contact Form PHP Script - by Mike Challis
Free PHP Scripts - www.642weather.com/weather/scripts.php
Home page        - http://www.fastsecurecontactform.com/
Download         - http://www.fastsecurecontactform.com/download-php-script
Support          - http://www.fastsecurecontactform.com/support
FAQ              - http://www.fastsecurecontactform.com/faq-php-version
Changelog        - http://www.fastsecurecontactform.com/changelog-php
Donate:          - http://www.fastsecurecontactform.com/donate

Version: 3.1.2 - 18-Sep-2014  see http://www.fastsecurecontactform.com/changelog-php for changes


-----------------------------------------
Purpose
-----------------------------------------
Fast Secure Contact Form PHP Script
This contact form lets your visitors send you a quick E-mail message. Blocks all common spammer tactics. Spam is no longer a problem. Includes a CAPTCHA and Akismet spam prevention support. Additionally, the plugin has a multi-form feature, optional extra fields, and an option to redirect visitors to any URL after the message is sent. Packed with settings and features.
(there is also a WordPress plugin version, this is a PHP Sript version that does NOT require or use WordPress!) 


-----------------------------------------
Installation
-----------------------------------------

Step 1)
Download fs-contact-form.zip, unzip and FTP upload the /contact-files/ folder to www.yourwebsite.com/contact-files/ with your favorite FTP client such as FileZilla. Be sure to preserve the folder structure from the zip file. 
(upload /contact-files/ and all its subdirectories)


Step 2)
Run the install:
Put this URL in your web browser and configure the site settings needed for the program install:
www.yourwebsite.com/contact-files/install/index.php

Step 3)
After the install page is complete, you are directed to the admin page.
This is where you edit and preview your forms:
www.yourwebsite.com/contact-files/admin/index.php

Step 4)
How to insert a form on your web site:
Go to the admin menu (step 3): when editing or previewing a form, you will see the "Usage" instructions:
Click "Show PHP Code", then edit the HTML of a PHP page on your web site and add the code.
You can add more than one form on a page, just repeat the complete PHP code block using a different form number.
Example: you make a new contact.php page, then enter the PHP code block you copied from the "Show PHP Code" instructions.

Step 5)
This step is required for the CAPTCHA refresh to work properly:
Put this HTML code in your page somewhere in the head section(anywhere after <head> but before </head>): 
<script type="text/javascript" src="http://www.yourwebsite.com/contact-files/contact-form.js"></script>

Make sure you have replaced "www.yourwebsite.com" with your own web site, and if you have installed /contact-files/ in a sub directory you have added the path also. You should be able to put http://www.yourwebsite.com/contact-files/contact-form.js in a web browser and not get a "not found message". And after installing, be sure to test that the CAPTCHA refresh button works, if it does not work you have performed this step incorrectly.


Step 6)
Upload your PHP contact for page to your server and test it.
www.yourwebsite.com/contact.php
Example: Upload contact.php to your server and test the form, send yourself a message and see if it works.
Note: do not put your contact pages in the /contact-files/ folder because then future program updates would be more risky. 
It is most common to put your form pages in the root of your web site, like this: www.yourwebsite.com/contact.php
You can put the form pages in other folders if you want, like this:
www.yourwebsite.com/wx/contact.php
www.yourwebsite.com/weather/contact.php


-----------------------------------------
Upgrade
-----------------------------------------
Step 1) Backup your forms! You can use the Backup Tool located on the bottom of the admin settings page to backup "All Forms".
The Tool will allow you to download a backup file from the admin web page. Save the file on your computer to restore after the upgrade.
The Restore Tool is located on the bottom of the admin settings page.

Step 2) Backup your "Site Settings" that were made during the install setup. The "Site Settings" contains the Site Name, Admin Name, Admin Password, etc.
The site settings are stored in the folder /contact-files/settings/ in the file fsc_site.php
Download the fsc_site.php with your favorite FTP client such as FileZilla. 
Save the file on your computer to restore back to the same folder /contact-files/settings/ after the upgrade.

Step 3) (My favorite way - combines step 1 and step 2) Backup all the settings at once. 
All the forms and site settings are stored in the folder /contact-files/settings/
Download the entire /contact-files/settings/ folder with your favorite FTP client such as FileZilla. 
Save the entire folder on your computer to restore back to the same folder /contact-files/settings/ after the upgrade.

Step 4) Download the updated program install package from 
http://www.fastsecurecontactform.com/download-php-script
Save the file fs-contact-form.zip to your computer. 

Step 5) (Do not perform this step until you have backed up the forms and settings in steps 1, 2, 3, and 4!)
Delete the entire /contact-files/ folder from your web server. This will ensure a clean upgrade.

Step 6) Unzip the fs-contact-form.zip file and upload the /contact-files/ folder to www.yourwebsite.com/contact-files/
be sure to preserve the folder structure from the zip file. 
(upload /contact-files/ and all its subdirectories)

Step 7) Restore your site settings and forms. Upload the entire /contact-files/settings/ folder (from your backup step 3) 
with your favorite FTP client such as FileZilla. 

Step 8) Test a form and see if it works. You should be able to log into the admin again. 
If any new settings were added in the new version they will be automatically initialized 
(and merged with your prior settings) when the form is first used or edited.
This is where you edit and preview your forms:
www.yourwebsite.com/contact-files/admin/index.php


-----------------------------------------
Language Translations
-----------------------------------------

How to select a language: (there are 3 ways)
1) Setting a Default Language: The default language can be selected by visiting “Site Settings” on the admin page top menu. There is a form select to select a language by country locale.

2) Manually set a form to a specific (non-default language):
Edit the PHP code in the HTML body section of the page where your form is located:
Just after this:
$contact_form = 1; // set desired form number
add this:
$contact_form_language_override = ‘en_US’; // manual override for default “site settings” language

Be sure to change en_US to your desired language.

3) This program can also take a URL parameter to change the language:
?lang=it_IT or ?lang=it (Italian)
?lang=en_US or ?lang=en (English)

More information on translation files and how to translate...
see translations-readme-txt


-----------------------------------------
Features
-----------------------------------------
    * Super easy customizable Options from Admin settings page.
    * Multi-Form feature that allows you to have as many different forms as you need.
    * Optional extra fields of any type: text, textarea, checkbox, radio, select, select-multiple, attachment, date, fieldset(box).
    * File attachments
    * Backup/restore tool. You can backup/restore all your forms or single forms and settings.
    * Easy to hide subject and message fields for use as a newsletter signup.
    * Supports sending mail to multiple departments.
    * Optional redirect to any URL after message sent.
    * Optional autoresponder E-mail message.
    * Valid coding for HTML, XHTML, HTML STRICT, Section 508, and WAI Accessibility.
    * Uses simple inline error messages.
    * Reloads form data and warns user if user forgets to fill out a field.
    * Validates syntax of E-mail address.
    * CAPTCHA can be turned off if you do not like CAPTCHA, Akismet can still be used for spam protection.
    * Multi "E-mail to" contact support.
    * Customizable form field titles.
    * Customizable CSS style.
    * SMTP mailer inclued(optional).
    * Sends E-mail with UTF-8 character encoding for US and International character support.
    * I18n language translation support (see FAQ)

Security:

    * It has very tight security, stops all automated spammers.
    * Akismet spam protection support.
    * Spam checks E-mail address input from common spammer tactics... prevents spammer forcing to:, cc:, bcc:, newlines, and other E-mail injection attempts to spam the world.
    * Makes sure the contact form was posted from your blog domain name only.
    * Filters all form inputs from HTML and other nasties.
    * E-mail message footer Date/Time, IP address, and user agent (browser version) of user who contacted you.

Captcha Image Support:

    * Uses Open-source free PHP CAPTCHA library by http://www.phpcaptcha.org (customized version included)
    * Abstract background with multi colored, angled, and transparent text
    * Arched lines through text
    * Visual and Audible CAPTCHA
    * Refresh button to reload captcha if you cannot read it
    * CAPTCHA can be disabled in Options


-----------------------------------------
Requirements
-----------------------------------------
PHP version 5.1 or greater is required.
Your server must be set with folder permissions to allow this script to write files.
NOTE: This script requires PHP installed using GD image support.
http://us2.php.net/manual/en/ref.image.php
PHP register_globals and safe_mode MUST be set to "Off".


-----------------------------------------
Please Donate to keep this program FREE
-----------------------------------------
If you find this program useful to you, please consider making a small donation to help contribute to my time invested and to further development. Thanks for your kind support! - Mike Challis
Some people donate $2, $5, $10, $20, or more. No amount is too small. 
If you are not able to, that is OK.
Donations can be made with your PayPal account, or securely using any of the major credit cards.
http://www.fastsecurecontactform.com/donate


-----------------------------------------
Terms of Use (Use of this script signifies your acceptance)
-----------------------------------------
You are free to use and modify the code

This php code provided "as is", and Michael Challis
disclaims any and all warranties, whether express or implied, including
(without limitation) any implied warranties of merchantability or
fitness for a particular purpose.

Copyright (C) 2008-2014 Mike Challis  (http://www.fastsecurecontactform.com/contact)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA




