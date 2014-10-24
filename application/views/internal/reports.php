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
			<div class="grid_16 form">
				<h3>Skip if you don't want to travel back</h3>
				<form method="post">
<?php
if (date('G') >= 5):
?>
					<input type="date" name="date" max="<?php echo date('Y-m-d', strtotime('yesterday')); ?>" required autofocus />
<?php
else:
?>
					<input type="date" name="date" max="<?php echo date('Y-m-d', strtotime('-1 day', strtotime('yesterday'))); ?>" required autofocus />
<?php
endif;
?>
					<button>GENERATE</button>
				</form>
			</div>
		</div>
	</div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>DAILY INCOME</h3>
			</div>
			<div class="grid_12">
<?php
if ( ! is_null($this->input->post('date'))):
?>
				<h3><?php echo date('m/d/Y', strtotime($this->input->post('date'))); ?></h3>
<?php
elseif (date('G') >= 17):
?>
				<h3><?php echo date('m/d/Y h:iA', strtotime('today 5pm')); ?></h3>
<?php
elseif (date('G') >= 5):
?>
				<h3><?php echo date('m/d/Y h:iA', strtotime('today 5am')); ?></h3>
<?php
else:
?>
				<h3><?php echo date('m/d/Y h:iA', strtotime('yesterday 5pm')); ?></h3>
<?php
endif;
?>
				<p>AS OF <?php echo date('m/d/Y h:i:sA'); ?></p>
			</div>
		</div>
	</section>
	<div class="clear"></div>
	<div class="container_16 clearfix table">
		<h3>Event/ Designation registration stats</h3>
<?php
if ( ! is_null($designations)):
?>
		<div class="grid_6">
			<table>
				<tr>
					<th>STD</th>
					<th>DISC</th>
					<th>REV</th>
					<th>FREE</th>
				</tr>
			</table>
		</div>
		<div class="grid_5">
			<table>
				<tr>
					<th>CA/CHK</th>
					<th>CC/DC</th>
				</tr>
			</table>
		</div>
		<div class="grid_5">
			<table>
				<tr>
					<th>TOTAL</th>
					<th>SPLIT</th>
				</tr>
			</table>
		</div>
		<div class="clear"></div>
<?php
	$count = 0;
	foreach ($designations as $object):
?>
		<div class="grid_6">
			<table>
				<tr>
					<th colspan="4"><?php echo date('h:iA', $object->begin); ?> &ndash; <?php echo date('h:iA', $object->end); ?></th>
				</tr>
			</table>
			<table>
				<tr>
					<td><?php echo $arrivals['E/D']['count'][$object->did]->standard; ?></td>
					<td><?php echo $arrivals['E/D']['count'][$object->did]->discounted; ?></td>
					<td><?php echo $arrivals['E/D']['count'][$object->did]->reversed; ?></td>
					<td><?php echo $arrivals['E/D']['count'][$object->did]->free; ?></td>
				</tr>
			</table>
		</div>
		<div class="grid_5">
			<table>
				<tr>
					<th colspan="2"><?php echo $events[$object->eid]->label; ?></th>
				</tr>
			</table>
			<table>
				<tr>
					<td>$<?php echo number_format($arrivals['E/D']['count'][$object->did]->total['CA/CHK'], 2, '.', ''); ?></td>
					<td>$<?php echo number_format($arrivals['E/D']['count'][$object->did]->total['CC/DC'], 2, '.', ''); ?></td>
				</tr>
			</table>
		</div>
		<div class="grid_5">
			<table>
				<tr>
<?php
		$data = array();
		if (isset($instructions['persons']) && ! is_null($instructions['persons'][$object->eid])):
			foreach ($instructions['persons'][$object->eid] as $item):
				if (isset($persons[$item->pid])):
					$data[] = $persons[$item->pid]->firstname;
				endif;
			endforeach;
		elseif (isset($instructions['genres']) && ! is_null($instructions['genres'][$object->did]) && ! is_null($genres)):
			foreach ($instructions['genres'][$object->did] as $item):
				foreach ($genres as $thing):
					if ($thing->gid == $item->gid):
						$data[] = $thing->name;
					endif;
				endforeach;
			endforeach;
		endif;
		if (count($data) > 0):
			sort($data);
?>
					<th colspan="2"><?php echo implode(' &amp; ', $data); ?></th>
<?php
		else:
			if ( ! is_null($locations)):
				foreach ($locations as $item):
					if ($item->lid == $events[$object->eid]->lid):
?>
					<th><?php echo $item->name; ?></th>
<?php
					endif;
				endforeach;
			endif;
			$data = array('C' => 'CLASS', 'P' => 'PARTY', 'S' => 'SPECIAL', 'R' => 'RENTAL', 'MIX' => 'MIXED');
			foreach ($data as $item => $thing):
				if ($item == $events[$object->eid]->category):
?>
					<th><?php echo $thing; ?></th>
<?php
				endif;
			endforeach;
		endif;
?>
				</tr>
			</table>
			<table>
				<tr>
					<td>$<?php echo number_format($arrivals['E/D']['count'][$object->did]->total['CA/CHK'] + $arrivals['E/D']['count'][$object->did]->total['CC/DC'], 2, '.', ''); ?></td>
<?php
		if ($events[$object->eid]->category != 'R'):
?>
					<td>$<?php echo number_format(($arrivals['E/D']['count'][$object->did]->total['CA/CHK'] + $arrivals['E/D']['count'][$object->did]->total['CC/DC']) / 2, 2, '.', ''); ?></td>
<?php
		else:
?>
					<td>N/A</td>
<?php
		endif;
?>
				</tr>
			</table>
		</div>
<?php
		if (($count + 1) < count($designations)):
?>
		<div class="clear"></div>
<?php
		endif;
		$count++;
	endforeach;
else:
?>
		<p>Not available.</p>
<?php
endif;
?>
	</div>
	<div class="clear"></div>
	<div class="container_16 clearfix table">
		<h3>Floor fee registration record(s)</h3>
<?php
if ( ! is_null($arrivals['FLOOR'])):
	$count = 0;
	foreach ($arrivals['FLOOR'] as $object):
?>
		<div class="grid_4">
			<table>
				<tr>
					<td><?php echo date('h:i:sA', $object->time); ?></td>
				</tr>
			</table>
			<table>
				<tr>
<?php
		if ( ! is_null($object->pid) && ! is_null($persons[$object->pid])):
?>
					<th colspan="2">#<?php echo sprintf('%06d', $object->pid); ?>: <?php echo $persons[$object->pid]->firstname[0].' '.$persons[$object->pid]->lastname; ?></th>
<?php
		else:
?>
					<th colspan="2"><?php echo $object->fullname; ?></th>
<?php
		endif;
?>
				</tr>
				<tr>
<?php
		if ( ! $object->reversed):
			if ( ! is_null($orders[$object->oid]->tid)):
				switch ($transactions[$orders[$object->oid]->tid]->payment):
					case 'CA/CHK';
					case 'CC/DC':
?>
					<td><?php echo $transactions[$orders[$object->oid]->tid]->payment; ?></td>
					<td>$<?php echo $transactions[$orders[$object->oid]->tid]->amount; ?></td>
<?php
						break;
					case '';
					case NULL:
?>
					<td colspan="2">FREE</td>
<?php
				endswitch;
			else:
?>
					<td colspan="2">FREE</td>
<?php
			endif;
		else:
?>
					<td colspan="2"><?php echo $object->reason; ?></td>
<?php
		endif;
?>
				</tr>
			</table>
		</div>
<?php
		if ( ! (($count + 1) % 4) && ($count + 1) < count($arrivals['FLOOR'])):
?>
		<div class="clear"></div>
<?php
		endif;
		$count++;
	endforeach;
else:
?>
		<p>Not available.</p>
<?php
endif;
?>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>SUBTOTAL</h3>
				<p>EVENT/ DESIGNATION</p>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format(array_sum($arrivals['subtotal']['E/D']), 2, '.', ''); ?></h3>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format($arrivals['subtotal']['E/D']['CA/CHK'], 2, '.', ''); ?></h3>
				<p>CASH/ CHECK</p>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format($arrivals['subtotal']['E/D']['CC/DC'], 2, '.', ''); ?></h3>
				<p>CREDIT/ DEBIT CARD</p>
			</div>
		</div>
	</section>
<?php
if (isset($arrivals['E/D']['split'])):
?>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>SPLIT</h3>
				<p>EVENT/ DESIGNATION</p>
			</div>
			<div class="grid_12">
				<h3>$<?php echo number_format(array_sum($arrivals['E/D']['split']), 2, '.', ''); ?></h3>
			</div>
		</div>
	</section>
	<div class="clear"></div>
	<div class="container_16 clearfix">
<?php
	$count = 0;
	foreach ($arrivals['E/D']['split'] as $object => $item):
?>
		<div class="grid_4">
			<h3>$<?php echo number_format($item, 2, '.', ''); ?></h3>
<?php
		foreach (unserialize($object) as $thing):
?>
			<p><?php echo $persons[$thing]->firstname[0].' '.$persons[$thing]->lastname; ?></p>
<?php
		endforeach;
?>
		</div>
<?php
		if ( ! (($count + 1) % 4)):
?>
		<div class="clear"></div>
<?php
		endif;
	endforeach;
?>
	</div>
	<div class="clear"></div>
<?php
endif;
?>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>SUBTOTAL</h3>
				<p>FLOOR FEE</p>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format(array_sum($arrivals['subtotal']['FLOOR']), 2, '.', ''); ?></h3>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format($arrivals['subtotal']['FLOOR']['CA/CHK'], 2, '.', ''); ?></h3>
				<p>CASH/ CHECK</p>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format($arrivals['subtotal']['FLOOR']['CC/DC'], 2, '.', ''); ?></h3>
				<p>CREDIT/ DEBIT CARD</p>
			</div>
		</div>
	</section>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>GRAND TOTAL</h3>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format(array_sum($arrivals['total']), 2, '.', ''); ?></h3>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format($arrivals['total']['CA/CHK'], 2, '.', ''); ?></h3>
				<p>CASH/ CHECK</p>
			</div>
			<div class="grid_4">
				<h3>$<?php echo number_format($arrivals['total']['CC/DC'], 2, '.', ''); ?></h3>
				<p>CREDIT/ DEBIT CARD</p>
			</div>
		</div>
	</section>