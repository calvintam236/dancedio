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
				<h3>Skip if you want to add an event</h3>
				<form method="post">
					<input type="text" name="label" placeholder="LABEL" maxlength="15" pattern="^[a-zA-Z0-9.]*$" autocomplete="off" required autofocus />
					<button>SEARCH</button>
				</form>
			</div>
		</div>
	</div>
<?php
if (isset($events) && ! is_null($events) && ! isset($events->eid)):
?>
	<form method="post">
<?php
	foreach ($events as $object):
?>
		<section class="gray">
			<div class="container_16 clearfix">
				<div class="grid_4">
					<button type="submit" name="eid" value="<?php echo $object->eid; ?>"><?php echo $object->label; ?></button>
				</div>
				<div class="grid_12">
<?php
		if ( ! is_null($object->name)):
?>
					<h3><?php echo $object->name; ?></h3>
<?php
		elseif (isset($instructions['genres']['E']) && ! is_null($instructions['genres']['E'][$object->eid]) && ! is_null($genres)):
			$data = array();
			foreach ($instructions['genres']['E'][$object->did] as $item):
				foreach ($genres as $thing):
					if ($thing->gid == $item->gid):
						$data[] = $thing->name;
					endif;
				endforeach;
			endforeach;
			sort($data);
?>
					<h3><?php echo implode(' &amp; ', $data); ?></h3>
<?php
		endif;
		if ( ! is_null($locations)):
			$data = array('C' => 'CLASS', 'P' => 'PARTY', 'S' => 'SPECIAL', 'R' => 'RENTAL', 'MIX' => 'MIXED');
			foreach ($locations as $item):
				if ($item->lid == $object->lid):
?>
					<p><?php echo $data[$object->category]; ?> &ndash; <?php echo $item->name; ?></p>
<?php
				endif;
			endforeach;
		endif;
?>
				</div>
			</div>
		</section>
<?php
	endforeach;
?>
	</form>
<?php
endif;
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Enter information for an event</h3>
		<form method="post">
			<datalist id="level">
				<option value="All Levels">
				<option value="Bronze">
				<option value="Bronze I">
				<option value="Bronze II">
				<option value="Bronze/ Silver">
				<option value="Silver">
				<option value="Silver I">
				<option value="Silver II">
				<option value="Silver/ Gold">
				<option value="Gold">
				<option value="Introductory">
				<option value="Beginning">
				<option value="Beginning/ Intermediate">
				<option value="Intermediate">
				<option value="Intermediate/ Advanced">
				<option value="Advanced">
			</datalist>
			<div class="grid_16">
<?php
if (isset($events) && ! is_null($events) && isset($events->eid)):
?>
				<input type="hidden" name="eid" value="<?php echo $events->eid; ?>" />
				<select name="category" required>
					<option value="" disabled>CATEGORY</option>
<?php
	$data = array('C' => 'CLASS', 'P' => 'PARTY', 'S' => 'SPECIAL', 'R' => 'RENTAL', 'MIX' => 'MIXED');
	foreach ($data as $object => $item):
		if ($object == $events->category):
?>
					<option value="<?php echo $object; ?>" selected><?php echo $item; ?> &bull;</option>
<?php
		else:
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
		endif;
	endforeach;
?>
				</select>
				<input type="text" value="<?php echo $events->label; ?>" name="label" placeholder="LABEL" maxlength="15" pattern="^[a-zA-Z0-9.]*$" required />
				<select name="lid" required>
					<option value="" disabled>LOCATION</option>
<?php
	if ( ! is_null($locations)):
		foreach ($locations as $object):
			if ($object->lid == $events->lid):
?>
					<option value="<?php echo $object->lid; ?>" selected><?php echo $object->name; ?> &bull;</option>
<?php
			else:
?>
					<option value="<?php echo $object->lid; ?>"><?php echo $object->name; ?></option>
<?php
			endif;
		endforeach;
	endif;
?>
				</select>
				<input list="level" name="level" value="<?php echo $events->level; ?>" placeholder="LEVEL" maxlength="30" pattern="^[a-zA-Z /\-'+]*$" />
				<input type="text" name="name" value="<?php echo $events->name; ?>" placeholder="NAME" maxlength="30" pattern="^[a-zA-Z0-9 /\-']*$" />
				<input type="text" name="price" value="<?php echo $events->price; ?>" placeholder="PRICE" maxlength="6" pattern="^\d{1,3}.\d{2}$" />
				<input type="text" name="discount" value="<?php echo $events->discount; ?>" placeholder="DISCOUNT" maxlength="6" pattern="^\d{1,3}.\d{2}$" />
				<input type="text" name="pricenote" value="<?php echo $events->pricenote; ?>" placeholder="PRICE NOTE" maxlength="100" pattern="^[a-zA-Z0-9 /\-'\(\)]*$" />
				<input type="text" name="discountnote" value="<?php echo $events->discountnote; ?>" placeholder="DISCOUNT NOTE" maxlength="100" pattern="^[a-zA-Z0-9 /\-'\(\)]*$" />
				<input type="text" name="account" value="<?php echo $events->account; ?>" placeholder="ACCOUNT" maxlength="5" pattern="^\d{3}[a-zA-Z]{0,2}$" />
				<select name="repetition">
<?php
	$data = array('' => 'ONCE', 'W' => 'WEEKLY', 'W1' => '1ST WEEK', 'W2' => '2ND WEEK', 'W3' => '3RD WEEK', 'W4' => '4TH WEEK', 'W5' => '5TH WEEK');
	foreach ($data as $object => $item):
		if ((empty($object) && is_null($events->repetition)) || ($object == $events->repetition)):
?>
					<option value="<?php echo $object; ?>" selected><?php echo $item; ?> &bull;</option>
<?php
		else:
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
		endif;
	endforeach;
?>
				</select>
				<select name="frequency">
<?php
	if (is_null($events->repetition)):
?>
					<option value="" selected disabled>FREQUENCY</option>
<?php
	else:
?>
					<option value="" disabled>FREQUENCY</option>
<?php
	endif;
	$data = array('MON' => 'MONDAY', 'TUE' => 'TUESDAY', 'WED' => 'WEDNESDAY', 'THU' => 'THURSDAY', 'FRI' => 'FRIDAY', 'SAT' => 'SATURDAY', 'SUN' => 'SUNDAY');
	foreach ($data as $object => $item):
		if ( ! is_null($events->repetition) && $object == $events->frequency):
?>
					<option value="<?php echo $object; ?>" selected><?php echo $item; ?> &bull;</option>
<?php
		else:
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
		endif;
	endforeach;
?>
				</select>
<?php
	if ( ! is_null($events->repetition)):
?>
				<input type="date" name="begindate" value="<?php echo date('Y-m-d', $events->begindate); ?>" />
				<input type="date" name="enddate" value="<?php echo date('Y-m-d', $events->enddate); ?>" />
				<input type="time" name="begintime" value="<?php echo date('H:i', $events->begintime); ?>" />
				<input type="time" name="endtime" value="<?php echo date('H:i', $events->endtime); ?>" />
<?php
	else:
?>
				<input type="date" name="begindate" />
				<input type="date" name="enddate" />
				<input type="time" name="begintime" />
				<input type="time" name="endtime" />
<?php
	endif;
else:
?>
				<select name="category" required>
					<option value="" selected disabled>CATEGORY</option>
<?php
	$data = array('C' => 'CLASS', 'P' => 'PARTY', 'S' => 'SPECIAL', 'R' => 'RENTAL', 'MIX' => 'MIXED');
	foreach ($data as $object => $item):
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
	endforeach;
?>
				</select>
				<input type="text" name="label" placeholder="LABEL" maxlength="15" pattern="^[a-zA-Z0-9.]*$" required />
				<select name="lid" required>
					<option value="" selected disabled>LOCATION</option>
<?php
	if ( ! is_null($locations)):
		foreach ($locations as $object):
?>
					<option value="<?php echo $object->lid; ?>"><?php echo $object->name; ?></option>
<?php
		endforeach;
	endif;
?>
				</select>
				<input list="level" name="level" placeholder="LEVEL" maxlength="30" pattern="^[a-zA-Z /\-'+]*$" />
				<input type="text" name="name" placeholder="NAME" maxlength="30" pattern="^[a-zA-Z0-9 /\-']*$" />
				<input type="text" name="price" placeholder="PRICE" maxlength="6" pattern="^\d{1,3}.\d{2}$" />
				<input type="text" name="discount" placeholder="DISCOUNT" maxlength="6" pattern="^\d{1,3}.\d{2}$" />
				<input type="text" name="pricenote" placeholder="PRICE NOTE" maxlength="100" pattern="^[a-zA-Z0-9 /\-'\(\)]*$" />
				<input type="text" name="discountnote" placeholder="DISCOUNT NOTE" maxlength="100" pattern="^[a-zA-Z0-9 /\-'\(\)]*$" />
				<input type="text" name="account" placeholder="ACCOUNT" maxlength="5" pattern="^\d{3}[a-zA-Z]{0,2}$" />
				<select name="repetition">
<?php
	$data = array('' => 'ONCE', 'W' => 'WEEKLY', 'W1' => '1ST WEEK', 'W2' => '2ND WEEK', 'W3' => '3RD WEEK', 'W4' => '4TH WEEK', 'W5' => '5TH WEEK');
	foreach ($data as $object => $item):
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
	endforeach;
?>
				</select>
				<select name="frequency">
					<option value="" selected disabled>FREQUENCY</option>
<?php
	$data = array('MON' => 'MONDAY', 'TUE' => 'TUESDAY', 'WED' => 'WEDNESDAY', 'THU' => 'THURSDAY', 'FRI' => 'FRIDAY', 'SAT' => 'SATURDAY', 'SUN' => 'SUNDAY');
	foreach ($data as $object => $item):
?>
					<option value="<?php echo $object; ?>"><?php echo $item; ?></option>
<?php
	endforeach;
?>
				</select>
				<input type="date" name="begindate" />
				<input type="date" name="enddate" />
				<input type="time" name="begintime" />
				<input type="time" name="endtime" />
<?php
endif;
?>
				<div class="clear"></div>
				<button type="submit" name="action" value="add">ADD</button>
<?php
if (isset($events) && ! is_null($events) && isset($events->eid)):
?>
				<button type="submit" name="action" value="edit">EDIT</button>
				<button type="submit" name="action" value="cancel">CANCEL</button>
<?php
endif;
?>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<?php
if (isset($events) && ! is_null($events) && isset($events->eid)):
?>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>INSTRUCTION</h3>
				<p>PERSON</p>
			</div>
			<div class="grid_12">
<?php
	if ( ! is_null($instructions['persons'])):
?>
				<h3><?php echo count($instructions['persons']); ?> RESULT(S)</h3>
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
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Maintain assigned person(s)</h3>
		<form method="post">
			<input type="hidden" name="extra" value="instructions[persons]" />
			<input type="hidden" name="eid" value="<?php echo $events->eid; ?>" />
			<div class="grid_16">
				<select name="pid[]" multiple>
<?php
	if ( ! is_null($instructions['persons'])):
?>
					<option value="">NONE</option>
<?php
	else:
?>
					<option value="" selected>NONE</option>
<?php
	endif;
	$data = array();
	if ( ! is_null($instructions['persons'])):
		foreach ($instructions['persons'] as $object):
			if (isset($persons[$object->pid])):
				$data[] = $object->pid;
			endif;
		endforeach;
	endif;
	if ( ! is_null($copartnerships)):
		foreach ($copartnerships as $object):
			if (array_search($object->pid, $data) !== FALSE):
?>
					<option value="<?php echo $object->pid; ?>" selected><?php echo $persons[$object->pid]->firstname.' '.$persons[$object->pid]->lastname; ?></option>
<?php
			else:
?>
					<option value="<?php echo $object->pid; ?>"><?php echo $persons[$object->pid]->firstname.' '.$persons[$object->pid]->lastname; ?></option>
<?php
			endif;
		endforeach;
	endif;
?>
				</select>
				<button type="submit" name="action" value="add/remove">ADD/ REMOVE</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>INSTRUCTION</h3>
				<p>GENRE (EVENT)</p>
			</div>
			<div class="grid_12">
<?php
	if ( ! is_null($instructions['genres']['E'])):
?>
				<h3><?php echo count($instructions['genres']['E']); ?> RESULT(S)</h3>
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
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Maintain assigned genre(s)</h3>
		<form method="post">
			<input type="hidden" name="extra" value="instructions[genres][E]" />
			<input type="hidden" name="eid" value="<?php echo $events->eid; ?>" />
			<div class="grid_16">
				<select name="gid[]" multiple>
<?php
	if ( ! is_null($instructions['genres']['E'])):
?>
					<option value="">NONE</option>
<?php
	else:
?>
					<option value="" selected>NONE</option>
<?php
	endif;
	$data = array();
	if ( ! is_null($instructions['genres']['E'])):
		foreach ($instructions['genres']['E'] as $object):
			$data[] = $object->gid;
		endforeach;
	endif;
	if ( ! is_null($genres)):
		foreach ($genres as $object):
			if (array_search($object->gid, $data) !== FALSE):
?>
					<option value="<?php echo $object->gid; ?>" selected><?php echo $object->name; ?></option>
<?php
			else:
?>
					<option value="<?php echo $object->gid; ?>"><?php echo $object->name; ?></option>
<?php
			endif;
		endforeach;
	endif;
?>
				</select>
				<button type="submit" name="action" value="add/remove">ADD/ REMOVE</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>DESIGNATION</h3>
			</div>
			<div class="grid_12">
<?php
	if ( ! is_null($designations)):
?>
				<h3><?php echo count($designations); ?> RESULT(S)</h3>
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
	if ( ! is_null($designations)):
?>
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Maintain current designation(s)</h3>
		<form method="post">
			<datalist id="reason">
				<option value="Mistake">
				<option value="Cancelled">
			</datalist>
			<input type="hidden" name="extra" value="designations" />
			<input type="hidden" name="eid" value="<?php echo $events->eid; ?>" />
<?php
		$count = 0;
		foreach ($designations as $object):
?>
			<div class="grid_4">
<?php
			if ( ! $object->cancelled):
?>
				<input type="hidden" name="did[]" value="<?php echo $object->did; ?>" />
				<input type="datetime-local" name="begin[<?php echo $object->did; ?>]" value="<?php echo date('Y-m-d\TH:i', $object->begin); ?>" required />
				<input type="datetime-local" name="end[<?php echo $object->did; ?>]" value="<?php echo date('Y-m-d\TH:i', $object->end); ?>" required />
				<textarea name="note[<?php echo $object->did; ?>]" maxlength="300" placeholder="NOTE"><?php echo $object->note; ?></textarea>
				<input list="reason" name="reason[<?php echo $object->did; ?>]" placeholder="REASON" maxlength="200" />
<?php
			else:
?>
				<table>
					<tr>
						<th><?php echo date('m/d/Y h:iA', $object->begin); ?></th>
					</tr>
					<tr>
						<th><?php echo date('m/d/Y h:iA', $object->end); ?></th>
					</tr>
				</table>
<?php
				if ( ! is_null($object->note)):
?>
				<table>
					<tr>
						<td><?php echo $object->note; ?></td>
					</tr>
				</table>
<?php
				endif;
?>
				<table>
					<tr>
						<td><?php echo $object->reason; ?></td>
					</tr>
				</table>
<?php
			endif;
?>
			</div>
<?php
			if ( ! (($count + 1) % 4) || ($count + 1) == count($designations)):
?>
			<div class="clear"></div>
<?php
			endif;
			$count++;
		endforeach;
?>
			<div class="grid_16">
				<button type="submit" name="action" value="edit/cancel">EDIT/ CANCEL</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
	<section class="gray">
		<div class="container_16 clearfix">
			<div class="grid_4">
				<h3>INSTRUCTION</h3>
				<p>GENRE (DESIGNATION)</p>
			</div>
			<div class="grid_12">
<?php
		if ( ! is_null($instructions['genres']['D'])):
?>
				<h3><?php echo count($instructions['genres']['D']); ?> RESULT(S)</h3>
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
	<div class="clear"></div>
	<div class="container_16 clearfix form">
		<h3>Maintain assigned genre(s) to designation</h3>
		<form method="post">
			<input type="hidden" name="extra" value="instructions[genres][D]" />
<?php
		$count = 0;
		foreach ($designation as $object):
?>
			<div class="grid_8">
				<select name="gid[<?php echo $object->did; ?>][]" multiple>
<?php
			if ( ! is_null($instructions['genres']['D'][$object->did])):
?>
					<option value="">NONE</option>
<?php
			else:
?>
					<option value="" selected>NONE</option>
<?php
			endif;
			$data = array();
			if ( ! is_null($instructions['genres']['D'][$object->did])):
				foreach ($instructions['genres']['D'] as $object):
					$data[] = $object->gid;
				endforeach;
			endif;
			if ( ! is_null($genres)):
				foreach ($genres as $object):
					if (array_search($object->gid, $data) !== FALSE):
?>
					<option value="<?php echo $object->gid; ?>" selected><?php echo $object->name; ?></option>
<?php
					else:
?>
					<option value="<?php echo $object->gid; ?>"><?php echo $object->name; ?></option>
<?php
					endif;
				endforeach;
			endif;
?>
				</select>
			</div>
<?php
			if ( ! (($count + 1) % 2) || ($count + 1) == count($designations)):
?>
			<div class="clear"></div>
<?php
			endif;
			$count++;
		endforeach;
?>
			<div class="grid_16">
				<button type="submit" name="action" value="add/remove">ADD/ REMOVE</button>
			</div>
		</form>
	</div>
	<div class="clear"></div>
<?php
	endif;
endif;
?>