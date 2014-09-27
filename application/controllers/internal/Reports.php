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

class Reports extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		if ($this->agent->is_browser('Internet Explorer') || ($this->agent->is_browser('Firefox') && ! $this->agent->is_mobile()) || $this->agent->is_browser('Safari'))
		{
			redirect('http://browsehappy.com');
		}
		else
		{
			switch ($this->session->userdata('version'))
			{
				case NULL:
					$this->session->set_userdata('version', 'external');
				case 'external':
					redirect(site_url());
					break;
				case 'internal':
					$this->load->model('Users');
					if (is_null($this->session->userdata('name')) || is_null($this->Users->status($this->session->userdata('name'))))
					{
						$this->session->set_userdata('version', 'external');
						redirect(site_url());
					}
			}
		}
	}

	function index()
	{
		// Get user permission
		$data['users'] = $this->Users->status($this->session->userdata('name'));
		switch ($data['users']->permission)
		{
			case 'D';
			case 'O';
			case 'S';
			case 'A':
				$this->load->model('Arrivals');
				$this->load->model('Copartnerships');
				$this->load->model('Designations');
				$this->load->model('Events');
				$this->load->model('Genres');
				$this->load->model('Instructions');
				$this->load->model('Locations');
				$this->load->model('Orders');
				$this->load->model('Persons');
				$this->load->model('Transactions');
				// POSTed: Search by date or default by current time
				if ( !! strlen($this->input->post('date')))
				{
					if ((date('G') >= 5 && strtotime($this->input->post('date')) <= strtotime('yesterday')) || (date('G') < 5 && strtotime($this->input->post('date')) <= strtotime('today')))
					{
						$begin = strtotime($this->input->post('date').'T05:00');
						$end = strtotime('+1 day', $begin);
					}
					else
					{
						$data['error'] = 'Out of range.';
					}
				}
				if ( ! isset($begin) && ! isset($end))
				{
					if (date('G') >= 17)
					{
						$begin = strtotime('today 5pm');
						$end = strtotime('tomorrow 5am');
					}
					elseif (date('G') >= 5)
					{
						$begin = strtotime('today 5am');
						$end = strtotime('today 5pm');
					}
					else
					{
						$begin = strtotime('yesterday 5pm');
						$end = strtotime('today 5am');
					}
				}
				$data['designations'] = $this->Designations->filter($begin, $end);
				// Count money and head in "event/designation"
				$data['arrivals']['total'] = array('CA/CHK' => 0.00, 'CC/DC' => 0.00);
				$data['arrivals']['subtotal']['E/D'] = array('CA/CHK' => 0.00, 'CC/DC' => 0.00);
				if ( ! is_null($data['designations']))
				{
					foreach ($data['designations'] as $object)
					{
						$data['instructions']['genres'][$object->did] = $this->Instructions->filter('G', NULL, $object->did);
						if ( ! isset($data['events'][$object->eid]))
						{
							$data['instructions']['persons'][$object->eid] = $this->Instructions->filter('P', $object->eid);
							$data['events'][$object->eid] = $this->Events->search($object->eid);
						}
						$standard = 0;
						$discounted = 0;
						$reversed = 0;
						$free = 0;
						$total = array('CA/CHK' => 0.00, 'CC/DC' => 0.00);
						$data['arrivals']['E/D']['count'][$object->did] = $this->Arrivals->history(array($begin, $end), 'E/D', NULL, $object->did);
						if ( ! is_null($data['arrivals']['E/D']['count'][$object->did]))
						{
							foreach ($data['arrivals']['E/D']['count'][$object->did] as $item)
							{
								if ( ! $item->reversed)
								{
									if ( ! is_null($item->amount))
									{
										switch ($item->amount)
										{
											case $data['events'][$object->eid]->price:
												$standard++;
												break;
											default:
												$discounted++;
										}
										$orders = $this->Orders->search($item->oid);
										if ( ! is_null($orders) && ! is_null($orders->tid))
										{
											$transactions = $this->Transactions->search($orders->tid);
											$total[$transactions->payment] += $item->amount;
											$data['arrivals']['subtotal']['E/D'][$transactions->payment] += $item->amount;
											if ($data['events'][$object->eid]->category != 'R' && ! is_null($data['instructions']['persons'][$object->eid]))
											{
												$pid = array();
												foreach ($data['instructions']['persons'][$object->eid] as $thing)
												{
													$pid[] = $thing->pid;
												}
												if ( !! count($pid))
												{
													sort($pid);
													$pid = serialize($pid);
													if ( ! isset($data['arrivals']['E/D']['split'][$pid]))
													{
														$data['arrivals']['E/D']['split'][$pid] = 0.00;
													}
													$data['arrivals']['E/D']['split'][$pid] += $item->amount * (50 / 100);
												}
											}
										}
									}
									else
									{
										$free++;
									}
								}
								else
								{
									$reversed++;
								}
							}
						}
						$data['arrivals']['E/D']['count'][$object->did] = new stdClass();
						$data['arrivals']['E/D']['count'][$object->did]->standard = $standard;
						$data['arrivals']['E/D']['count'][$object->did]->discounted = $discounted;
						$data['arrivals']['E/D']['count'][$object->did]->reversed = $reversed;
						$data['arrivals']['E/D']['count'][$object->did]->free = $free;
						$data['arrivals']['E/D']['count'][$object->did]->total = $total;
					}
					$data['arrivals']['total']['CA/CHK'] += $data['arrivals']['subtotal']['E/D']['CA/CHK'];
					$data['arrivals']['total']['CC/DC'] += $data['arrivals']['subtotal']['E/D']['CC/DC'];
				}
				// Count money and head in "floor"
				$data['arrivals']['subtotal']['FLOOR'] = array('CA/CHK' => 0.00, 'CC/DC' => 0.00);
				$data['arrivals']['FLOOR'] = $this->Arrivals->history(array($begin, $end), 'FLOOR');
				if ( ! is_null($data['arrivals']['FLOOR']))
				{
					foreach ($data['arrivals']['FLOOR'] as $object)
					{
						if ( ! is_null($object->pid) && ! isset($data['persons'][$object->pid]))
						{
							$data['persons'][$object->pid] = $this->Persons->search($object->pid);
						}
						if ( ! $object->reversed)
						{
							$data['orders'][$object->oid] = $this->Orders->search($object->oid);
							if ( ! is_null($data['orders'][$object->oid]) && ! is_null($data['orders'][$object->oid]->tid) && ! isset($data['transactions'][$data['orders'][$object->oid]->tid]))
							{
								$data['transactions'][$data['orders'][$object->oid]->tid] = $this->Transactions->search($data['orders'][$object->oid]->tid);
								$data['arrivals']['subtotal']['FLOOR'][$data['transactions'][$data['orders'][$object->oid]->tid]->payment] += $object->amount;
							}
						}
					}
					$data['arrivals']['total']['CA/CHK'] += $data['arrivals']['subtotal']['FLOOR']['CA/CHK'];
					$data['arrivals']['total']['CC/DC'] += $data['arrivals']['subtotal']['FLOOR']['CC/DC'];
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
						}
					}
				}
				// Get genres data
				$data['genres'] = $this->Genres->available();
				// Get locations data
				$data['locations'] = $this->Locations->available();
				$this->load->view('internal/header', $data);
				$this->load->view('internal/reports', $data);
				$this->load->view('internal/footer');
				break;
			default:
				show_404();
		}
	}
}


/* End of file Reports.php */
/* Location: ./application/controllers/internal/Reports.php */