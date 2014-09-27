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

class Reminders extends CI_Model
{
	function available()
	{
		if (date('G') >= 5)
		{
			$this->db->where('expiration >=', strtotime('today 5am'));
		}
		else
		{
			$this->db->where('expiration >=', strtotime('yesterday 5am'));
		}
		$reminders = $this->db->where('removed', FALSE)->order_by('rid', 'desc')->get('reminders');
		switch ($reminders->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $reminders->result();
		}
	}

	function add($url, $expiration, $fid)
	{
		$this->db->set('url', $url)->set('expiration', strtotime($expiration.'T05:00'))->set('fid', $fid)->insert('reminders');
		return $this->db->insert_id();
	}

	function edit($rid, $url, $expiration, $fid = NULL)
	{
		$this->db->where('rid', $rid)->where('removed', FALSE)->set('url', $url)->set('expiration', strtotime($expiration.'T05:00'));
		if ( !! strlen($fid))
		{
			$this->db->set('fid', $fid);
		}
		$this->db->insert('reminders');
		return $this->db->insert_id();
	}

	function remove($rid)
	{
		$this->db->where('rid', $rid)->where('removed', FALSE)->set('removed', TRUE)->update('reminders');
		return $this->db->affected_rows();
	}
}


/* End of file Reminders.php */
/* Location: ./application/models/Reminders.php */