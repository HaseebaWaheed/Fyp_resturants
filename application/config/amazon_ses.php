<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Config for the Amazon Simple Email Service library
 *
 * @see ../libraries/Amazon_ses.php
 */
// Amazon credentials
$config['amazon_ses_secret_key'] = 'AKIAIBQFHKS6ZMNMNEZQ';
$config['amazon_ses_access_key'] = 'cqFdd+xnSlweR2QiK+gF1qUNNCCl0zhdf4jVh9Rm';

// Adresses
$config['amazon_ses_from'] = 'alert@ajubia.com';
$config['amazon_ses_from_name'] = 'ajubia';
$config['amazon_ses_reply_to'] = 'alert@ajubia.com';

// Path to certificate to verify SSL connection (i.e. 'certs/cacert.pem') 
$config['amazon_ses_cert_path'] = 'uploads';

// Charset to be used, for example UTF-8, ISO-8859-1 or Shift_JIS. The SMTP
// protocol uses 7-bit ASCII by default
$config['amazon_ses_charset'] = 'iso-8859-1';
