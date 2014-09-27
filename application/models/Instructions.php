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

class Instructions extends CI_Model
{
	function filter($category = NULL, $eid = NULL, $did = NULL, $pid = NULL, $gid = NULL)
	{
		if ( !! strlen($category))
		{
			$this->db->where('category', strtoupper($category));
		}
		if ( !! strlen($eid))
		{
			$this->db->where('eid', $eid);
		}
		if ( !! strlen($did))
		{
			$this->db->where('did', $did);
		}
		if ( !! strlen($pid))
		{
			$this->db->where('pid', $pid);
		}
		if ( !! strlen($gid))
		{
			$this->db->where('gid', $gid);
		}
		$instructions = $this->db->where('removed', FALSE)->order_by('iid', 'desc')->get('instructions');
		switch ($instructions->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $instructions->result();
		}
	}

	function add($category, $eid = NULL, $did = NULL, $pid = NULL, $gid = NULL)
	{
		$this->db->set('category', strtoupper($category));
		if ( !! strlen($eid))
		{
			$this->db->set('eid', $eid);
		}
		if ( !! strlen($did))
		{
			$this->db->set('did', $did);
		}
		if ( !! strlen($pid))
		{
			$this->db->set('pid', $pid);
		}
		if ( !! strlen($gid))
		{
			$this->db->set('gid', $gid);
		}
		$this->db->insert('instructions');
		return $this->db->insert_id();
	}

	function remove($iid)
	{
		$this->db->where('iid', $iid)->where('removed', FALSE)->set('removed', TRUE)->update('instructions');
		return $this->db->affected_rows();
	}
}


/* End of file Instructions.php */
/* Location: ./application/models/Instructions.php */