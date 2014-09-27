<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.2.4 or newer
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the Academic Free License version 3.0
 *
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

$config['stripe_key_test_public']         = '';
$config['stripe_key_test_secret']         = '';
$config['stripe_key_live_public']         = '';
$config['stripe_key_live_secret']         = '';
$config['stripe_test_mode']               = (ENVIRONMENT == 'production') ? FALSE : TRUE;
$config['stripe_verify_ssl']              = TRUE;
$config['stripe_currency']                = 'usd';
$config['stripe_decode']                  = TRUE;


/* End of file stripe.php */
/* Location: ./application/config/stripe.php */