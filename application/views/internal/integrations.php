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
				<h3>EXPORT</h3>
			</div>
			<div class="grid_12">
				<h3>USE WITH CAUTIONS</h3>
				<p>Don't save any of the data into portable storage, or you will be in trouble when you lost it.</p>
			</div>
		</div>
	</section>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Exported to CSV format</h3>
		<form method="post">
			<div class="grid_16">
				<input type="hidden" name="section" value="export" />
				<select name="type" required>
					<option value="" selected disabled>TYPE</option>
<?php
$data = array('M/ACTIVE' => 'MEMBERS - ACTIVE', 'M/NEW' => 'MEMBERS - NEWLY JOINED', 'M/EXPIRED/LAST' => 'MEMBERS - EXPIRED LAST MONTH', 'M/EXPIRED/THIS' => 'MEMBERS - EXPIRED THIS MONTH', 'M/B/LAST' => 'MEMBERS - BIRTH LAST MONTH', 'M/B/THIS' => 'MEMBERS - BIRTH THIS MONTH', 'M/B/NEXT' => 'MEMBERS - BIRTH NEXT MONTH', 'C/ACTIVE' => 'COPARTNERS - ACTIVE', 'C/NEW' => 'COPARTNERS - NEWLY JOINED', 'C/B/LAST' => 'COPARTNERS - BIRTH LAST MONTH', 'C/B/THIS' => 'COPARTNERS - BIRTH THIS MONTH', 'C/B/NEXT' => 'COPARTNERS - BIRTH NEXT MONTH');
foreach ($data as $object => $item):
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
endforeach;
?>
				</select>
				<button type="submit" name="action" value="generate">GENERATE</button>
			</div>
		</form>
<?php
if (isset($persons)):
	$data = array();
	$count = 0;
	$data[$count] = array('pid', 'firstname', 'lastname', 'address', 'city', 'state', 'zipcode', 'email', 'cellphone', 'homephone', 'emergencyphone', 'birthmonth');
	if (isset($memberships) || isset($copartnerships)):
		if (isset($memberships)):
			$data[$count][] = 'type';
		$data[$count][] = 'since';
		$data[$count][] = 'expiration';
	endif;
	$data[$count] = '"'.implode('","', $data[$count]).'"';
	foreach ($persons as $object):
		if ( ! is_null($object)):
			$data[$count + 1] = array(
				sprintf('%06d', $object->pid),
				$object->firstname,
				$object->lastname,
				$object->address,
				$object->city,
				$object->state,
				$object->zipcode,
				$object->email,
				$object->cellphone,
				$object->homephone,
				$object->emergencyphone,
				$object->birthmonth
			);
			if (isset($memberships[$object->pid])):
				$data[$count + 1][] = $memberships[$object->pid]->type;
				$data[$count + 1][] = date('Y-m-d', $memberships[$object->pid]->since);
				$data[$count + 1][] = date('Y-m-d', $memberships[$object->pid]->expiration);
			endif;
			if (isset($copartnerships[$object->pid])):
				$data[$count + 1][] = date('Y-m-d', $copartnerships[$object->pid]->since);
				$data[$count + 1][] = date('Y-m-d', $copartnerships[$object->pid]->expiration);
			endif;
			$data[$count + 1] = '"'.implode('","', $data[$count + 1]).'"';
			$count++;
		endif;
	endforeach;
?>
		<div class="grid_16">
			<textarea placeholder="CSV" readonly><?php echo implode("\n", $data); ?></textarea>
		</div>
<?php
endif;
?>
	</div>
	<div class="clear"></div>