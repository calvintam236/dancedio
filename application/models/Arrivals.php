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

class Arrivals extends CI_Model
{
	function available($category = NULL)
	{
		if ( !! strlen($category))
		{
			$this->db->where('category', strtoupper($category));
		}
		$arrivals = $this->db->where('time >=', strtotime('-30 minutes'))->where('reversed', FALSE)->order_by('aid', 'desc')->get('arrivals');
		switch ($arrivals->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $arrivals->result();
		}
	}
	
	function search($aid)
	{
		$arrivals = $this->db->where('aid', $aid)->where('reversed', FALSE)->limit(1)->get('arrivals');
		switch ($arrivals->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $arrivals->result()[0];
		}
	}

	function check($category, $pid, $did = NULL, $type = NULL)
	{
		$this->db->where('category', strtoupper($category))->where('pid', $pid);
		if ( !! strlen($did))
		{
			$this->db->where('did', $did);
		}
		if ( !! strlen($type))
		{
			$this->db->where('type', $type);
		}
		$arrivals = $this->db->where('reversed', FALSE)->order_by('aid', 'desc')->limit(1)->get('arrivals');
		switch ($arrivals->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $arrivals->result()[0];
		}
	}

	function history($time = NULL, $category = NULL, $pid = NULL, $did = NULL)
	{
		if ( ! empty($time) && is_array($time))
		{
			$this->db->where('time >=', $time[0])->where('time <=', $time[1]);
		}
		if ( !! strlen($category))
		{
			$this->db->where('category', strtoupper($category));
		}
		if ( !! strlen($pid))
		{
			$this->db->where('pid', $pid);
		}
		if ( !! strlen($did))
		{
			$this->db->where('did', $did);
		}
		$arrivals = $this->db->order_by('aid', 'desc')->get('arrivals');
		switch ($arrivals->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $arrivals->result();
		}
	}

	function filter($time = NULL, $oid = NULL, $category = NULL, $pid = NULL, $did = NULL)
	{
		if ( ! empty($time) && is_array($time))
		{
			$this->db->where('time >=', $time[0])->where('time <=', $time[1]);
		}
		if ( !! strlen($oid))
		{
			$this->db->where('oid', $oid);
		}
		if ( !! strlen($category))
		{
			$this->db->where('category', strtoupper($category));
		}
		if ( !! strlen($pid))
		{
			$this->db->where('pid', $pid);
		}
		if ( !! strlen($did))
		{
			$this->db->where('did', $did);
		}
		$arrivals = $this->db->where('reversed', FALSE)->order_by('aid', 'desc')->get('arrivals');
		switch ($arrivals->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $arrivals->result();
		}
	}

	function add($oid, $category, $amount = NULL, $pid = NULL, $fullname = NULL, $did = NULL, $type = NULL)
	{
		$this->db->set('time', microtime(TRUE))->set('oid', $oid)->set('category', strtoupper($category));
		if ( !! strlen($amount))
		{
			$this->db->set('amount', $amount);
		}
		if ( !! strlen($pid))
		{
			$this->db->set('pid', $pid);
		}
		if ( !! strlen($fullname))
		{
			$this->db->set('fullname', strtoupper($fullname));
		}
		if ( !! strlen($did))
		{
			$this->db->set('did', $did);
		}
		if ( !! strlen($type))
		{
			$this->db->set('type', $type);
		}
		$this->db->insert('arrivals');
		return $this->db->insert_id();
	}

	function edit($aid, $oid)
	{
		$this->db->where('aid', $aid)->where('reversed', FALSE)->set('oid', $oid)->update('arrivals');
		return $this->db->insert_id();
	}

	function reverse($aid, $reason)
	{
		$this->db->where('aid', $aid)->where('time >=', strtotime('-30 minutes'))->where('reversed', FALSE)->set('reason', $reason)->set('reversed', TRUE)->update('arrivals');
		return $this->db->affected_rows();
	}
}


/* End of file Arrivals.php */
/* Location: ./application/models/Arrivals.php */