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
	<title>dancedio</title>
	<?php echo meta('viewport', 'width=device-width, user-scalable=no'); ?>
	<?php echo link_tag('http://fonts.googleapis.com/css?family=Lato:300,400,700'); ?>
	<?php echo link_tag('../resources/styles/keyners.css'); ?>
	<script type="text/javascript" src="../resources/scripts/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('.logo a').click(function() {
				if ($('.mainMenu').css('display') == 'none') {
					$('.mainMenu').fadeIn();
				} else if ($(window).width() <= 1399) {
					$('.mainMenu').fadeOut();
				}
			});
			$(window).resize(function() {
				if ($(window).width() > 1399 && $('.mainMenu').attr('style') !== undefined) {
					$('.mainMenu').removeAttr('style');
				}
			});
			$(window).scroll(function() {
				if ($('#error').length > 0 && $('#error').attr('style') === undefined) {
					$('#error').slideUp();
				}
				if ($('#done').length > 0 && $('#done').attr('style') === undefined) {
					$('#done').slideUp();
				}
			});
			if ($('#error').length > 0) {
				$('#error').click(function() {
					$('#error').slideUp();
				});
			}
			if ($('#done').length > 0) {
				$('#done').click(function() {
					$('#done').slideUp();
				});
			}
		});
	</script>
</head>
<body>
	<header>
		<nav>
			<div class="container_16 clearfix">
				<div class="grid_2 logo">
					<a href="javascript:void(0);"><h1>dancedio</h1><?php echo img('resources/images/logo.png'); ?></a>
				</div>
				<div class="grid_14 mainMenu">
					<ul>
<?php
switch ($users->permission):
	case 'D';
	case 'O';
	case 'S';
	case 'A':
?>
						<li><?php echo anchor(NULL, 'HOME'); ?></li>
						<li><?php echo anchor('reports', 'REPORTS'); ?></li>
<?php
endswitch;
switch ($users->permission):
	case 'O';
	case 'S';
	case 'A':
?>
						<li><?php echo anchor('miscellany', 'MISCELLANY'); ?></li>
						<li><?php echo anchor('relationships', 'RELATIONSHIPS'); ?></li>
						<li><?php echo anchor('calendar', 'CALENDAR'); ?></li>
<?php
endswitch;
switch ($users->permission):
	case 'S';
	case 'A':
?>
						<li><?php echo anchor('integrations', 'INTEGRATIONS'); ?></li>
<?php
endswitch;
if ($users->permission == 'A'):
?>
						<li><?php echo anchor('administrations', 'ADMINISTRATIONS'); ?></li>
<?php
endif;
?>
					</ul>
				</div>
			</div>
		</nav>
	</header>
<?php
if (isset($error)):
?>
	<section id="error" class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>ERROR</h3>
			</div>
			<div class="grid_12">
				<h3><?php echo $error; ?></h3>
			</div>
		</div>
	</section>
<?php
endif;
if (isset($done)):
?>
	<section id="done" class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>DONE</h3>
			</div>
			<div class="grid_12">
<?php
	foreach ($done as $object):
?>
				<h3><?php echo $object; ?></h3>
<?php
	endforeach;
?>
			</div>
		</div>
	</section>
<?php
endif;
?>
