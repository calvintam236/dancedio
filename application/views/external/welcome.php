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