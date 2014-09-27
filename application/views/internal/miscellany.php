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
				<h3>REMINDERS</h3>
			</div>
			<div class="grid_12">
<?php
if ( ! is_null($reminders)):
?>
				<h3><?php echo count($reminders); ?> RESULT(S)</h3>
<?php
else:
?>
				<h3>NO RECORD</h3>
<?php
endif;
?>
			</div>
		</div>
	</section>
<?php
if ( ! is_null($reminders)):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Maintain reminders information</h3>
<?php
	$count = 0;
	foreach ($reminders as $object):
?>
		<div class="grid_4">
			<form method="post">
				<input type="hidden" name="section" value="reminders" />
				<img src="data:image/jpeg;base64,<?php echo $files[$object->fid]; ?>" alt="" />
				<input type="hidden" name="rid" value="<?php echo $object->rid; ?>" />
				<input type="url" name="url" value="<?php echo $object->url; ?>" placeholder="URL" maxlength="150" required />
<?php
		if (date('G') >= 5):
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" value="<?php echo date('Y-m-d', $object->expiration); ?>" required />
<?php
		else:
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('today')); ?>" value="<?php echo date('Y-m-d', $object->expiration); ?>" required />
<?php
		endif;
?>
				<button type="submit" name="action" value="edit">EDIT</button>
				<button type="submit" name="action" value="remove">REMOVE</button>
			</form>
		</div>
<?php
		if ( ! (($count + 1) % 4) && ($count + 1) < count($reminders)):
?>
		<div class="clear"></div>
<?php
		endif;
		$count++;
	endforeach;
?>
	</div>
<?php
endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Assign new reminder for public</h3>
		<form method="post">
			<input type="hidden" name="section" value="reminders" />
			<div class="grid_16">
				<input type="url" name="url" placeholder="URL" maxlength="150" required />
<?php
if (date('G') >= 5):
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('tomorrow')); ?>" required />
<?php
else:
?>
				<input type="date" name="expiration" min="<?php echo date('Y-m-d', strtotime('today')); ?>" required />
<?php
endif;
?>
				<input type="file" name="poster" required />
				<button type="submit" name="action" value="add">ADD</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>GENRES</h3>
			</div>
			<div class="grid_12">
<?php
if ( ! is_null($genres)):
?>
				<h3><?php echo count($genres); ?> RESULT(S)</h3>
<?php
else:
?>
				<h3>NO RECORD</h3>
<?php
endif;
?>
			</div>
		</div>
	</section>
<?php
if ( ! is_null($genres)):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Maintain dance genres information</h3>
		<form method="post">
			<input type="hidden" name="section" value="genres" />
<?php
	$count = 0;
	foreach ($genres as $object):
?>
			<div class="grid_4">
				<input type="hidden" name="gid[]" value="<?php echo $object->gid; ?>" />
				<input type="text" name="name[<?php echo $object->gid; ?>]" value="<?php echo $object->name; ?>" placeholder="NAME" maxlength="30" pattern="^[a-zA-Z \-']+$" />
			</div>
<?php
		if ( ! (($count + 1) % 4) || ($count + 1) == count($genres)):
?>
			<div class="clear"></div>
<?php
		endif;
		$count++;
	endforeach;
?>
			<div class="grid_16">
				<button type="submit" name="action" value="edit/remove">EDIT/ REMOVE</button>
			</div>
		</form>
	</div>
<?php
endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Assign new genre for general</h3>
		<form method="post">
			<input type="hidden" name="section" value="genres" />
			<div class="grid_16">
				<input type="text" name="name" placeholder="NAME" maxlength="30" pattern="^[a-zA-Z \-']+$" required />
				<button type="submit" name="action" value="add">ADD</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>NOTICES</h3>
			</div>
			<div class="grid_12">
<?php
if ( ! is_null($notices)):
?>
				<h3><?php echo count($notices); ?> RESULT(S)</h3>
<?php
else:
?>
				<h3>NO RECORD</h3>
<?php
endif;
?>
			</div>
		</div>
	</section>
<?php
if ( ! is_null($notices)):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Maintain dance genres information</h3>
<?php
	$count = 0;
	foreach ($notices as $object):
?>
		<div class="grid_8">
			<form method="post">
				<input type="hidden" name="section" value="notices" />
				<input type="hidden" name="nid" value="<?php echo $object->nid; ?>" />
				<input type="text" name="title" value="<?php echo $object->title; ?>" placeholder="TITLE" maxlength="100" pattern="^[a-zA-Z \-']+$" required />
				<textarea name="message" placeholder="MESSAGE" maxlength="500" required><?php echo $object->message; ?></textarea>
				<button type="submit" name="action" value="edit">EDIT</button>
				<button type="submit" name="action" value="remove">REMOVE</button>
			</form>
		</div>
<?php
		if ( ! (($count + 1) % 2) && ($count + 1) < count($notices)):
?>
		<div class="clear"></div>
<?php
		endif;
		$count++;
	endforeach;
?>
	</div>
<?php
endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Add new notice for announcement</h3>
		<form method="post">
			<input type="hidden" name="section" value="notices" />
			<div class="grid_16">
				<input type="text" name="title" placeholder="TITLE" maxlength="100" pattern="^[a-zA-Z \-']+$" required />
				<textarea name="message" placeholder="MESSAGE" maxlength="500" required></textarea>
				<button type="submit" name="action" value="add">ADD</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>