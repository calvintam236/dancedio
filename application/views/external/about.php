<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>	<section class="top">
		<div class="wrapper content_header clearfix">
			<h2 class="title">We're non-profit dance studio</h2>
		</div>
	</section>
	<section class="wrapper">
		<div class="content">
			<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc,</p>
			<p>For slidehow, please click <?php echo anchor('http://youtu.be/', 'here', array('class' => 'popup_iframe')); ?> to watch.</p>
			<h5>Board meetings' minutes archives</h5>
			<p>Please click <?php echo anchor('https://drive.google.com/embeddedfolderview?id=#grid', 'here', array('class' => 'popup_iframe')); ?> to view.</p>
			<h5>Agenda archives</h5>
			<p>Please click <?php echo anchor('', 'here', array('class' => 'popup_iframe')); ?> to view.</p>
			<h5>Press kit</h5>
			<p>Please click <?php echo anchor('frames/press-kit', 'here', array('class' => 'popup_iframe')); ?> to download.</p>
		</div>
	</section>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># FACILITY #</h2></div></div>
		</a>
	</div>
	<div class="work">
		<?php echo anchor('resources/images/main.jpg', img('resources/images/main.jpg').'<div class="caption"><div class="work_title"><h2>MAIN FLOOR<br>(4,000FT&sup2;)</h2></div></div>', array('class' => 'popup_image'))."\n"; ?>
	</div>
<?php
if ( ! is_null($jobs['bod'])):
?>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># BOARD OF DIRECTORS #</h2></div></div>
		</a>
	</div>
<?php
	foreach ($jobs['bod'] as $object):
?>
	<div class="work">
<?php
		if ( ! is_null($persons[$object->pid]->fid)):
?>
		<?php echo anchor('frames/view-bod/'.$object->pid, '<img src="data:image/jpeg;base64,'.$files[$persons[$object->pid]->fid].'" alt="" /><div class="caption"><div class="work_title"><h2>'.$persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname.'</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
<?php
		else:
?>
		<?php echo anchor('frames/view-bod/'.$object->pid, img('resources/images/missing.png').'<div class="caption"><div class="work_title"><h2>'.$persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname.'</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
<?php
		endif;
?>
	</div>
<?php
	endforeach;
endif;
if ( ! is_null($jobs['management'])):
?>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># MANAGEMENT #</h2></div></div>
		</a>
	</div>
<?php
	foreach ($jobs['management'] as $object):
?>
	<div class="work">
<?php
		if ( ! is_null($persons[$object->pid]->fid)):
?>
		<?php echo anchor('frames/view-management/'.$object->pid, '<img src="data:image/jpeg;base64,'.$files[$persons[$object->pid]->fid].'" alt="" /><div class="caption"><div class="work_title"><h2>'.$persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname.'</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
<?php
		else:
?>
		<?php echo anchor('frames/view-management/'.$object->pid, img('resources/images/missing.png').'<div class="caption"><div class="work_title"><h2>'.$persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname.'</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
<?php
		endif;
?>
	</div>
<?php
	endforeach;
endif;
if ( ! is_null($jobs['host'])):
?>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># HOSTS #</h2></div></div>
		</a>
	</div>
<?php
	foreach ($jobs['host'] as $object):
?>
	<div class="work">
		<a href="javascript:void(0);" class="popup_image">
<?php
		if ( ! is_null($persons[$object->pid]->fid)):
?>
			<?php echo '<img src="data:image/jpeg;base64,'.$files[$persons[$object->pid]->fid].'" alt="" />'."\n"; ?>
<?php
		else:
?>
			<?php echo img('resources/images/missing.png')."\n"; ?>
<?php
		endif;
?>
			<div class="caption">
				<div class="work_title"><h2><?php echo $persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname; ?></h2></div>
			</div>
		</a>
	</div>
<?php
	endforeach;
?>
	</section>
<?php
endif;
if ( ! is_null($jobs['dj'])):
?>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># PARTY DJS #</h2></div></div>
		</a>
	</div>
<?php
	foreach ($jobs['dj'] as $object):
?>
	<div class="work">
		<a href="javascript:void(0);" class="popup_image">
<?php
		if ( ! is_null($persons[$object->pid]->fid)):
?>
			<?php echo '<img src="data:image/jpeg;base64,'.$files[$persons[$object->pid]->fid].'" alt="" />'."\n"; ?>
<?php
		else:
?>
			<?php echo img('resources/images/missing.png')."\n"; ?>
<?php
		endif;
?>
			<div class="caption">
				<div class="work_title"><h2><?php echo $persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname; ?></h2></div>
			</div>
		</a>
	</div>
<?php
	endforeach;
endif;
if ( ! is_null($jobs['taxi'])):
?>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># TAXI DANCERS #</h2></div></div>
		</a>
	</div>
<?php
	foreach ($jobs['taxi'] as $object):
?>
	<div class="work">
		<a href="javascript:void(0);" class="popup_image">
<?php
		if ( ! is_null($persons[$object->pid]->fid)):
?>
			<?php echo '<img src="data:image/jpeg;base64,'.$files[$persons[$object->pid]->fid].'" alt="" />'."\n"; ?>
<?php
		else:
?>
			<?php echo img('resources/images/missing.png')."\n"; ?>
<?php
		endif;
?>
			<div class="caption">
				<div class="work_title"><h2><?php echo $persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname; ?></h2></div>
			</div>
		</a>
	</div>
<?php
	endforeach;
endif;
if ( ! is_null($copartnerships)):
?>
	<div class="work">
		<a href="javascript:void(0);">
			<?php echo img('resources/images/placeholder.png')."\n"; ?>
			<div class="caption"><div class="work_title"><h2># TEACHERS #</h2></div></div>
		</a>
	</div>
<?php
	foreach ($copartnerships as $object):
?>
	<div class="work">
<?php
		if ( ! is_null($persons[$object->pid]->fid)):
?>
		<?php echo anchor('frames/view-teacher/'.$object->pid, '<img src="data:image/jpeg;base64,'.$files[$persons[$object->pid]->fid].'" alt="" /><div class="caption"><div class="work_title"><h2>'.$persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname.'</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
<?php
		else:
?>
		<?php echo anchor('frames/view-teacher/'.$object->pid, img('resources/images/missing.png').'<div class="caption"><div class="work_title"><h2>'.$persons[$object->pid]->firstname.'<br>'.$persons[$object->pid]->lastname.'</h2></div></div>', array('class' => 'popup_iframe'))."\n"; ?>
<?php
		endif;
?>
	</div>
<?php
	endforeach;
endif;
?>