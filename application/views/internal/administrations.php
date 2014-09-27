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
?>	<div class="orange">
		<div class="container_16 clearfix">
			<div class="grid_16">
				<h3>Please scroll down for different sections</h3>
			</div>
		</div>
	</div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>IMPORT</h3>
			</div>
			<div class="grid_12">
				<h3>USE WITH CAUTIONS</h3>
				<p>Some of the data will be overwritten, if it has not overwritten, please empty tables.</p>
			</div>
		</div>
	</section>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Enter JSON format data</h3>
		<form method="post">
			<div class="grid_16">
				<input type="hidden" name="section" value="import" />
				<textarea name="json" placeholder="JSON" required></textarea>
				<button type="submit" name="action" value="process">PROCESS</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>