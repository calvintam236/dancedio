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
echo doctype('html5')."\n";
?>
<html lang="en-us">
<head>
	<meta charset="utf-8" />
	<?php echo meta('viewport', 'width=device-width, user-scalable=no'); ?>
	<?php echo link_tag('http://fonts.googleapis.com/css?family=Raleway:100,400,600,700'); ?>
	<?php echo link_tag('../resources/styles/magnetic.css'); ?>
	<?php echo link_tag('../resources/styles/validatr.css'); ?>
	<script type="text/javascript" src="../resources/scripts/jquery.min.js"></script>
	<script type="text/javascript" src="../resources/scripts/migrate.min.js" defer></script>
	<script type="text/javascript" src="../resources/scripts/validatr.min.js" defer></script>
	<script type="text/javascript" src="https://js.stripe.com/v2" defer></script>
	<script>
		$(document).ready(function() {
			$.validatr.messages = {
				checkbox: 'Please check this box if you want to proceed.',
				color: 'Please enter a color in the format #xxxxxx.',
				email: {
					single: 'Please enter an email address.',
					multiple: 'Please enter a comma separated list of email addresses.'
				},
				pattern: 'Please match the requested format.',
				radio: 'Please select one of these options.',
				range: {
					base: 'Please enter a {{type}}.',
					overflow: 'Please enter a {{type}} greater than or equal to {{min}}.', 
					overUnder: 'Please enter a {{type}} greater than or equal to {{min}}<br> and less than or equal to {{max}}.',
					invalid: 'Invalid {{type}}.',
					underflow: 'Please enter a {{type}} less than or equal to {{max}}.'
				},
				required: 'Please fill out this field.',
				select: 'Please select an item in the list.',
				time: 'Please enter a time in the format hh:mm:ss.',
				url: 'Please enter a url.'
			};
			$('form').validatr({
				position: function($error, $input) {},
				showall: true
			});
		});
		$('form').submit(function() {
			$('input[type=submit],input[type=reset],button').each(function() {
				$(this).prop('disabled', true);
			});
			if ($('input[name="token"]').length > 0) {
				Stripe.setPublishableKey('pk_test_6pRNASCoBOKtIshFeQd4XMUh');
				Stripe.card.createToekn($this, function($status, $response) {
					if ($status == 200) {
						$('input[name="token"]').val($response.id);
					}
					else
					{
						$('input[type=submit],input[type=reset],button').each(function() {
							$(this).prop('disabled', false);
						});
						return false;
					}
				});
			}
		});
	</script>
</head>
<body>
