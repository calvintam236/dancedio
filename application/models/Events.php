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

class Events extends CI_Model
{
	function search($eid, $label = NULL)
	{
		if ( !! strlen($eid))
		{
			$this->db->where('eid', $eid);
		}
		if ( !! strlen($label))
		{
			$this->db->like('label', strtoupper($label), 'after');
		}
		$events = $this->db->where('cancelled', FALSE)->order_by('eid', 'desc')->get('events');
		switch ($events->num_rows())
		{
			case 0:
				return NULL;
			case 1:
				return $events->result()[0];
			default:
				return $events->result();
		}
	}

	function filter($category = NULL, $lid = NULL, $repetition = NULL)
	{
		if ( !! strlen($category))
		{
			$this->db->where('category', strtoupper($category));
		}
		if ( !! strlen($lid))
		{
			$this->db->where('lid', $lid);
		}
		if ( !! strlen($repetition))
		{
			$this->db->where('repetition', strtoupper($repetition));
		}
		$events = $this->db->order_by('eid', 'desc')->get('events');
		switch ($events->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $events->result();
		}
	}

	function add($category, $label, $lid, $level = NULL, $name = NULL, $price = NULL, $discount = NULL, $pricenote = NULL, $discountnote = NULL, $account = NULL, $repetition = NULL, $frequency = NULL, $begindate = NULL, $enddate = NULL, $begintime = NULL, $endtime = NULL)
	{
		$this->db->set('category', strtoupper($category))->set('label', strtoupper($label))->set('lid', $lid);
		if ( !! strlen($level))
		{
			$this->db->set('level', $level);
		}
		if ( !! strlen($name))
		{
			$this->db->set('name', $name);
		}
		if ( !! strlen($price))
		{
			$this->db->set('price', $price);
		}
		if ( !! strlen($discount))
		{
			$this->db->set('discount', $discount);
		}
		if ( !! strlen($pricenote))
		{
			$this->db->set('pricenote', strtoupper($pricenote));
		}
		if ( !! strlen($discountnote))
		{
			$this->db->set('discountnote', strtoupper($discountnote));
		}
		if ( !! strlen($account))
		{
			$this->db->set('account', strtoupper($account));
		}
		if ( !! strlen($repetition))
		{
			$this->db->set('repetition', strtoupper($repetition));
		}
		if ( !! strlen($frequency))
		{
			$this->db->set('frequency', strtoupper($frequency));
		}
		if ( !! strlen($begindate))
		{
			$this->db->set('begindate', strtotime($begindate.'T05:00'));
		}
		if ( !! strlen($enddate))
		{
			$this->db->set('enddate', strtotime($enddate.'T05:00'));
		}
		if ( !! strlen($begintime))
		{
			$this->db->set('begintime', strtotime('1970-01-01T'.$begintime));
		}
		if ( !! strlen($endtime))
		{
			$this->db->set('endtime', strtotime('1970-01-01T'.$endtime));
		}
		$this->db->insert('events');
		return $this->db->insert_id();
	}

	function edit($eid, $category, $label, $lid, $level = NULL, $name = NULL, $price = NULL, $discount = NULL, $pricenote = NULL, $discountnote = NULL, $account = NULL, $repetition = NULL, $frequency = NULL, $begindate = NULL, $enddate = NULL, $begintime = NULL, $endtime = NULL)
	{
		$this->db->where('eid', $eid)->where('cancelled', FALSE)->set('category', strtoupper($category));
		if ( !! strlen($label))
		{
			$this->db->set('label', strtoupper($label));
		}
		$this->db->set('lid', $lid);
		if ( !! strlen($level))
		{
			$this->db->set('level', $level);
		}
		else
		{
			$this->db->set('level', NULL);
		}
		if ( !! strlen($name))
		{
			$this->db->set('name', $name);
		}
		else
		{
			$this->db->set('name', NULL);
		}
		if ( !! strlen($price))
		{
			$this->db->set('price', $price);
		}
		else
		{
			$this->db->set('price', NULL);
		}
		if ( !! strlen($discount))
		{
			$this->db->set('discount', $discount);
		}
		else
		{
			$this->db->set('discount', NULL);
		}
		if ( !! strlen($pricenote))
		{
			$this->db->set('pricenote', strtoupper($pricenote));
		}
		else
		{
			$this->db->set('pricenote', NULL);
		}
		if ( !! strlen($discountnote))
		{
			$this->db->set('discountnote', strtoupper($discountnote));
		}
		else
		{
			$this->db->set('discountnote', NULL);
		}
		if ( !! strlen($account))
		{
			$this->db->set('account', strtoupper($account));
		}
		else
		{
			$this->db->set('account', NULL);
		}
		if ( !! strlen($repetition))
		{
			$this->db->set('repetition', strtoupper($repetition));
		}
		else
		{
			$this->db->set('repetition', NULL);
		}
		if ( !! strlen($frequency))
		{
			$this->db->set('frequency', strtoupper($frequency));
		}
		else
		{
			$this->db->set('frequency', NULL);
		}
		if ( !! strlen($begindate))
		{
			$this->db->set('begindate', strtotime($begindate.'T05:00'));
		}
		else
		{
			$this->db->set('begindate', NULL);
		}
		if ( !! strlen($enddate))
		{
			$this->db->set('enddate', strtotime($enddate.'T05:00'));
		}
		else
		{
			$this->db->set('enddate', NULL);
		}
		if ( !! strlen($begintime))
		{
			$this->db->set('begintime', strtotime('1970-01-01T'.$begintime));
		}
		else
		{
			$this->db->set('begintime', NULL);
		}
		if ( !! strlen($endtime))
		{
			$this->db->set('endtime', strtotime('1970-01-01T'.$endtime));
		}
		else
		{
			$this->db->set('endtime', NULL);
		}
		$this->db->update('events');
		return $this->db->affected_rows();
	}

	function cancel($eid)
	{
		$this->db->where('eid', $eid)->where('cancelled', FALSE)->set('cancelled', TRUE)->update('events');
		return $this->db->affected_rows();
	}
}


/* End of file Events.php */
/* Location: ./application/models/Events.php */