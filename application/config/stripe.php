<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['stripe_key_test_public']         = 'pk_test_';
$config['stripe_key_test_secret']         = 'sk_test_';
$config['stripe_key_live_public']         = 'pk_live_';
$config['stripe_key_live_secret']         = 'sk_live_';
$config['stripe_test_mode']               = (ENVIRONMENT == 'production') ? FALSE : TRUE;
$config['stripe_verify_ssl']              = TRUE;
$config['stripe_currency']                = 'usd';
$config['stripe_decode']                  = TRUE;


/* End of file stripe.php */
/* Location: ./application/config/stripe.php */