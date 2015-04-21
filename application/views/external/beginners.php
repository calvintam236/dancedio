<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<section class="top">
		<div class="wrapper content_header clearfix">
			<h2 class="title">We were all beginners once</h2>
		</div>
	</section>
	<section class="wrapper">
		<div class="content">
			<p>Don't be shy! You don't need a partner, just bring your enthusiasm and a smile! This calendar is only listed events for beginners!</p>
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
			<h3>What is the difference between these?</h3>
			<h4>Group</h4>
			<p>You can try different dances each week, or focus on one dance a month, depending the classes you select. This's a great way to meet other people who share the same enthusiasm for dancing! You've plenty of chances since we rotate students often, letting you to try dancing with others.</p>
			<h4>Series of Group</h4>
			<p>If it marked 'Series', it's progressive, usually starts the first week of the month, for 4 weeks, 12 weeks or more. Build a good foundation with series group classes in over 15 different dances. Some classes require teachers' approval for enrollment.</p>
			<h4>Private</h4>
			<p>Private lessons are a vital part of the development of successful dancers. Take a look at our list of recognized teachers, ask he/ she for arrangement and pricing details. Standard floor fees apply to teacher or student(s).</p>
		</div>
	</section>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># DANCES #</h2></div></div>
		</a>
	</div>
	<div class="work">
		<?php echo anchor('http://en.wikipedia.org/wiki/Country-western_dance', img('resources/images/countrywestern.jpg').'<div class="caption"><div class="work_title"><h2>COUNTRY<br>&amp; WESTERN</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
	</div>
	<div class="work">
		<?php echo anchor('http://en.wikipedia.org/wiki/Swing_(dance)', img('resources/images/swing.jpg').'<div class="caption"><div class="work_title"><h2>SWING</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
	</div>
	<div class="work">
		<?php echo anchor('', img('resources/images/club.jpg').'<div class="caption"><div class="work_title"><h2>CLUB</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
	</div>
	<div class="work">
		<?php echo anchor('http://en.wikipedia.org/wiki/Street_dance', img('resources/images/street.jpg').'<div class="caption"><div class="work_title"><h2>STREET</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
	</div>
	<div class="work">
		<?php echo anchor('http://en.wikipedia.org/wiki/Ballroom_dance', img('resources/images/ballroomamerican.jpg').'<div class="caption"><div class="work_title"><h2>BALLROOM<br>(AMERICAN)</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
	</div>
	<div class="work">
		<?php echo anchor('http://en.wikipedia.org/wiki/Ballroom_dance', img('resources/images/ballroominternational.jpg').'<div class="caption"><div class="work_title"><h2>BALLROOM<br>(INTERNATIONAL)</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
	</div>