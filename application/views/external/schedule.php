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
?>	<section class="top">
		<div class="wrapper content_header clearfix">
			<h2 class="title">Calendar of upcoming events</h2>
		</div>
	</section>
	<section class="wrapper">
		<div class="content">
			<p>We provide the latest schedule here.</p>
			<h5>Newsletter archives</h5>
			<p>Please click <?php echo anchor('https://drive.google.com/embeddedfolderview?id={}#grid', 'here', array('class' => 'popup_iframe')); ?> to view.</p>
			<h5>Subscribe emails</h5>
			<p>Please click <?php echo anchor('http://eepurl.com/{}', 'here', array('class' => 'popup_iframe')); ?>.</p>
			<p>To view daily schedule, just click on the date. For advance search, please click <?php echo anchor('frames/search_schedule', 'here', array('class' => 'popup_iframe')); ?>.</p>
<?php
$data = array();
foreach ($designations as $date => $object):
	if ( ! is_null($object)):
		$count = 0;
		$data[$date] = '';
		foreach ($object as $item):
			$data[$date] .= '<h4>'.$events[$item->eid]->label;
			if ( ! is_null($events[$item->eid]->name)):
				$data[$date] .= ' # '.$events[$item->eid]->name;
				if ( ! is_null($item->note)):
					$data[$date] .= ' ('.$item->note.')';
				endif;
			elseif ( ! is_null($item->note)):
				$data[$date] .= ' # '.$item->note;
			endif;
			$data[$date] .= '</h4><p>'.date('h:iA', $item->begin).' &ndash; '.date('h:iA', $item->end).'</p>';
			if (isset($instructions['genres'][$item->eid]) && ! is_null($instructions['genres'][$item->eid]) && ! is_null($genres)):
				$material = array();
				foreach ($instructions['genres'][$item->eid] as $thing):
					foreach ($genres as $matter):
						if ($matter->gid == $thing->gid):
							$material[] = $matter->name;
						endif;
					endforeach;
				endforeach;
				sort($material);
				$data[$date] .= '<p><strong>'.implode(' &amp; ', $material).'</strong></p>';
			endif;
			/*if (isset($instructions['genres'][$item->did]) && ! is_null($instructions['genres'][$item->did]) && ! is_null($genres)):
				$material = array();
				foreach ($instructions['genres'][$item->did] as $thing):
					foreach ($genres as $matter):
						if ($matter->gid == $thing->gid):
							$material[] = $matter->name;
						endif;
					endforeach;
				endforeach;
				sort($material);
				$data[$date] .= '<p><strong>'.implode(' &amp; ', $material).'</strong></p>';
			endif;*/
			if ( ! is_null($events[$item->eid]->level)):
				$data[$date] .= '<p>'.$events[$item->eid]->level.'</p>';
			endif;
			if (isset($instructions['persons'][$item->eid]) && ! is_null($instructions['persons'][$item->eid])):
				$material = array();
				foreach ($instructions['persons'][$item->eid] as $thing):
					if (isset($persons[$thing->pid])):
						$material[] = $persons[$thing->pid]->firstname.' '.$persons[$thing->pid]->lastname;
					endif;
				endforeach;
				if ( !! count($material)):
					sort($material);
					$data[$date] .= '<p><strong>BY: '.implode(' &amp; ', $material).'</strong></p>';
				endif;
			endif;
			$data[$date] .= '<hr><p>';
			if ( ! is_null($events[$item->eid]->price)):
				$data[$date] .= '$'.number_format($events[$item->eid]->price, 2, '.', '');
				if ( ! is_null($events[$item->eid]->pricenote)):
					$data[$date] .= ' FOR '.$events[$item->eid]->pricenote;
				endif;
				if ( ! is_null($events[$item->eid]->discount)):
					$data[$date] .= '</p><p>';
					if ($events[$item->eid]->price - $events[$item->eid]->discount > 0.00):
						$data[$date] .= '$'.number_format($events[$item->eid]->price - $events[$item->eid]->discount, 2, '.', '');
					else:
						$data[$date] .= 'FREE';
					endif;
					$data[$date] .= ' FOR ';
					if ( ! is_null($events[$item->eid]->discountnote)):
						$data[$date] .= $events[$item->eid]->discountnote;
					else:
						$data[$date] .= 'MEMBERS';
					endif;
				endif;
			else:
				$data[$date] .= 'FREE';
				if ( ! is_null($events[$item->eid]->pricenote)):
					$data[$date] .= ' FOR '.$events[$item->eid]->pricenote;
				endif;
			endif;
			$data[$date] .= '</p>';
			if (($count + 1) < count($object)):
				$data[$date] .= '<hr>';
			endif;
			$count++;
		endforeach;
	endif;
endforeach;
?>
			<textarea id="caldata" style="display: none;"><?php echo json_encode($data); ?></textarea>
			<div class="custom-calendar-wrap">
				<div class="custom-inner">
					<div class="custom-header">
						<span id="custom-prev" class="pe-7s-angle-left"></span>
						<span id="custom-next" class="pe-7s-angle-right"></span>
						<h3 id="custom-month"></h3>
						<h4 id="custom-year"></h4>
					</div>
					<div id="calendar" class="fc-calendar-container"></div>
				</div>
				<div id="custom-content-reveal">
					<div id="custom-content"></div>
					<span id="custom-content-close" class="pe-7s-close-circle"></span>
				</div>
			</div>
		</div>
	</section>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># WE ACCEPTS #</h2></div></div>
		</a>
	</div>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/cash.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2>CASH</h2></div></div>
		</a>
	</div>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/check.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2>CHECK</h2></div></div>
		</a>
	</div>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/creditdebit.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2>CREDIT/ DEBIT</h2></div></div>
		</a>
	</div>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/giftcards.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2>GIFT CARDS</h2></div></div>
		</a>
	</div>