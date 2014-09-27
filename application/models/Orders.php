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

class Orders extends CI_Model
{
	function search($oid)
	{
		$orders = $this->db->where('oid', $oid)->where('cancelled', FALSE)->limit(1)->get('orders');
		switch ($orders->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $orders->result()[0];
		}
	}
	
	function filter($category = NULL)
	{
		if ( !! strlen($category))
		{
			$this->db->where('category', strtoupper($category));
		}
		$orders = $this->db->where('cancelled', 0)->order_by('oid', 'desc')->get('orders');
		switch ($orders->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $orders->result();
		}
	}

	function add($category, $tid = NULL)
	{
		$this->db->set('category', strtoupper($category));
		if ( !! strlen($tid))
		{
			$this->db->set('tid', $tid);
		}
		$this->db->insert('orders');
		return $this->db->insert_id();
	}

	function edit($oid, $category, $tid = NULL)
	{
		$this->db->where('oid', $oid)->where('cancelled', FALSE)->set('category', strtoupper($category));
		if ( !! strlen($tid))
		{
			$this->db->set('tid', $tid);
		}
		$this->db->update('orders');
		return $this->db->affected_rows();
	}

	function cancel($oid)
	{
		$this->db->where('oid', $oid)->where('cancelled', FALSE)->set('cancelled', TRUE)->update('orders');
		return $this->db->affected_rows();
	}
}


/* End of file Orders.php */
/* Location: ./application/models/Orders.php */