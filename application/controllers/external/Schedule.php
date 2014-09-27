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

class Schedule extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if (($this->agent->is_browser('Internet Explorer') && $this->agent->version() <= 9))
		{
			redirect('http://browsehappy.com');
		}
		else
		{
			switch ($this->session->userdata('version'))
			{
				case NULL:
					$this->session->set_userdata('version', 'external');
					break;
				case 'internal':
					redirect(site_url());
			}
		}
	}

	function index()
	{
		$this->load->model('Copartnerships');
		$this->load->model('Designations');
		$this->load->model('Events');
		$this->load->model('Files');
		$this->load->model('Genres');
		$this->load->model('Instructions');
		$this->load->model('Notices');
		$this->load->model('Persons');
		$fid = array();
		// Get calendar data
		$pointer = strtotime('first day of last month 5am');
		while ($pointer <= strtotime('last day of next month 5am'))
		{
			$data['designations'][date('m-d-Y', $pointer)] = $this->Designations->filter($pointer, strtotime('+1 day', $pointer));
			if ( ! is_null($data['designations'][date('m-d-Y', $pointer)]))
			{
				foreach ($data['designations'][date('m-d-Y', $pointer)] as $object)
				{
					//$data['instructions']['genres'][$object->did] = $this->Instructions->filter('G', NULL, $object->did);
					if ( ! isset($data['events'][$object->eid]))
					{
						$data['instructions']['genres'][$object->eid] = $this->Instructions->filter('G', $object->eid);
						$data['instructions']['persons'][$object->eid] = $this->Instructions->filter('P', $object->eid);
						$data['events'][$object->eid] = $this->Events->search($object->eid);
					}
				}
			}
			$pointer = strtotime('+1 day', $pointer);
		}
		// Get teacher and persons data
		$data['copartnerships'] = $this->Copartnerships->available();
		if ( ! is_null($data['copartnerships']))
		{
			foreach ($data['copartnerships'] as $object)
			{
				if ( ! isset($data['persons'][$object->pid]))
				{
					$data['persons'][$object->pid] = $this->Persons->search($object->pid);
					if ( ! is_null($data['persons'][$object->pid]->fid))
					{
						$fid[] = $data['persons'][$object->pid]->fid;
					}
				}
			}
		}
		// Get genre data
		$data['genres'] = $this->Genres->available();
		// Get notice data
		$data['notices'] = $this->Notices->available();
		if (isset($fid) && !! count($fid))
		{
			$fid = array_unique($fid);
			foreach ($fid as $object)
			{
				$data['files'][$object] = $this->Files->read($object);
			}
		}
		$this->load->view('external/header', $data);
		$this->load->view('external/schedule', $data);
		$this->load->view('external/footer');
	}
}


/* End of file Schedule.php */
/* Location: ./application/controllers/external/Schedule.php */