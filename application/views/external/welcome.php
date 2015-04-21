<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if ( ! is_null($reminders)):
?>
		<div class="work">
			<a href="javascript:void(0);">
				<?php echo img('resources/images/placeholder.png')."\n"; ?>
				<div class="caption"><div class="work_title"><h2># REMINDERS #</h2></div></div>
			</a>
		</div>
<?php
	foreach ($reminders as $object):
?>
		<div class="work">
			<?php echo anchor($object->url, '<img src="data:image/jpeg;base64,'.$files[$object->fid].'" alt="" />')."\n"; ?>
		</div>
<?php
	endforeach;
endif;
?>
		<div class="work">
			<a href="javascript:void(0);">
				<?php echo img('resources/images/placeholder.png')."\n"; ?>
				<div class="caption"><div class="work_title"><h2># FEATURED #</h2></div></div>
			</a>
		</div>
		<div class="work">
			<?php echo anchor('', img('resources/images/.jpg').'<div class="caption"><div class="work_title"><h2>A PROGRAM</h2></div></div>')."\n"; ?>
		</div>
		<div class="work">
			<a href="javascript:void(0);">
				<?php echo img('resources/images/placeholder.png')."\n"; ?>
				<div class="caption"><div class="work_title"><h2># PAST EVENTS #</h2></div></div>
			</a>
		</div>
		<!-- flickr -->