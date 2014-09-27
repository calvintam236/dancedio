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

class Memberships extends CI_Model
{
	function check($pid)
	{
		$memberships = $this->db->where('pid', $pid)->where('cancelled', FALSE)->order_by('mid', 'desc')->limit(1)->get('memberships');
		switch ($memberships->num_rows())
		{
			case 0:
				return NULL;
			case 1:
				if ((date('G') >= 5 && $memberships->result()[0]->expiration >= strtotime('today 5am')) || (date('G') < 5 && $memberships->result()[0]->expiration >= strtotime('yesterday 5am')))
				{
					return $memberships->result()[0];
				}
				else
				{
					return FALSE;
				}
		}
	}

	function history($type = NULL, $pid = NULL)
	{
		if ( !! strlen($type))
		{
			$this->db->where('type', strtoupper($type));
		}
		if ( !! strlen($pid))
		{
			$this->db->where('pid', $pid);
		}
		$memberships = $this->db->order_by('mid', 'desc')->get('memberships');
		switch ($memberships->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $memberships->result();
		}
	}

	function filter($type = NULL)
	{
		if ( !! strlen($type))
		{
			$this->db->where('type', strtoupper($type));
		}
		if (date('G') >= 5)
		{
			$this->db->where('expiration >=', strtotime('today 5am'));
		}
		else
		{
			$this->db->where('expiration >=', strtotime('yesterday 5am'));
		}
		$memberships = $this->db->get('memberships');
		switch ($memberships->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $memberships->result();
		}
	}

	function add($type, $pid, $since, $expiration, $oid = NULL, $amount = NULL)
	{
		$this->db->set('type', strtoupper($type))->set('pid', $pid)->set('since', strtotime($since.'T05:00'))->set('expiration', strtotime($expiration.'T05:00'));
		if ( !! strlen($oid))
		{
			$this->db->set('oid', $oid);
		}
		if ( !! strlen($amount))
		{
			$this->db->set('amount', $amount);
		}
		$this->db->insert('memberships');
		return $this->db->insert_id();
	}

	function cancel($mid, $reason)
	{
		$this->db->where('mid', $mid)->where('cancelled', FALSE)->set('reason', $reason)->set('cancelled', TRUE)->update('memberships');
		return $this->db->affected_rows();
	}
}


/* End of file Memberships.php */
/* Location: ./application/models/Memberships.php */