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

class Jobs extends CI_Model
{
	function check($category, $pid)
	{
		$jobs = $this->db->where('pid', $pid)->where('removed', FALSE)->order_by('jid', 'desc')->limit(1)->get('jobs');
		switch ($jobs->num_rows())
		{
			case 0:
				return NULL;
			case 1:
				if ((date('G') >= 5 && $jobs->result()[0]->expiration >= strtotime('today 5am')) || (date('G') < 5 && $jobs->result()[0]->expiration >= strtotime('yesterday 5am')))
				{
					return $jobs->result()[0];
				}
				else
				{
					return FALSE;
				}
			default:
				return $jobs->result();
		}
	}
	
	function history($category = NULL, $pid = NULL)
	{
		if ( !! strlen($category))
		{
			$this->db->where('category', strtoupper($category));
		}
		if ( !! strlen($pid))
		{
			$this->db->where('pid', $pid);
		}
		$jobs = $this->db->order_by('jid', 'desc')->get('jobs');
		switch ($jobs->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $jobs->result();
		}
	}

	function filter($category = NULL, $pid = NULL)
	{
		if ( !! strlen($category))
		{
			$this->db->where('category', strtoupper($category));
		}
		if ( !! strlen($pid))
		{
			$this->db->where('pid', $pid);
		}
		$jobs = $this->db->where('removed', FALSE)->order_by('jid', 'desc')->get('jobs');
		switch ($jobs->num_rows())
		{
			case 0:
				return NULL;
			default:
				return $jobs->result();
		}
	}

	function add($category, $pid, $expiration, $title = NULL, $bio = NULL)
	{
		$this->db->set('category', strtoupper($category))->set('pid', $pid)->set('expiration', strtotime($expiration.'T05:00'));
		if ( !! strlen($title))
		{
			$this->db->set('title', strtoupper($title));
		}
		if ( !! strlen($bio))
		{
			$this->db->set('bio', $bio);
		}
		$this->db->insert('jobs');
		return $this->db->insert_id();
	}

	function edit($jid, $expiration, $title = NULL, $bio = NULL)
	{
		$this->db->where('jid', $jid)->where('removed', FALSE)->set('expiration', strtotime($expiration.'T05:00'));
		if ( !! strlen($title))
		{
			$this->db->set('title', strtoupper($title));
		}
		else
		{
			$this->db->set('title', NULL);
		}
		if ( !! strlen($bio))
		{
			$this->db->set('bio', $bio);
		}
		else
		{
			$this->db->set('bio', NULL);
		}
		$this->db->update('jobs');
		return $this->db->affected_rows();
	}

	function remove($jid)
	{
		$this->db->where('jid', $jid)->where('removed', FALSE)->set('removed', TRUE)->update('jobs');
		return $this->db->affected_rows();
	}
}


/* End of file Jobs.php */
/* Location: ./application/models/Jobs.php */