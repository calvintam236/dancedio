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

class Welcome extends CI_Controller
{
	function index()
	{
		switch ($this->session->userdata('version'))
		{
			case NULL:
				$this->session->set_userdata('version', 'external');
			case 'external':
				if (($this->agent->is_browser('Internet Explorer') && $this->agent->version() <= 9))
				{
					redirect('http://browsehappy.com');
				}
				else
				{
					$this->external();
				}
				break;
			case 'internal':
				if ($this->agent->is_browser('Internet Explorer') || ($this->agent->is_browser('Firefox') && ! $this->agent->is_mobile()) || $this->agent->is_browser('Safari'))
				{
					redirect('http://browsehappy.com');
				}
				elseif (is_null($this->session->userdata('name')))
				{
					$this->session->set_userdata('version', 'external');
					$this->external();
				}
				else
				{
					$this->load->model('Users');
					if (is_null($this->Users->status($this->session->userdata('name'))))
					{
						$this->session->set_userdata('version', 'external');
						$this->external();
					}
					else
					{
						$this->internal();
					}
				}
		}
	}
	
	private function external()
	{
		$this->load->model('Designations');
		$this->load->model('Events');
		$this->load->model('Files');
		$this->load->model('Genres');
		$this->load->model('Instructions');
		$this->load->model('Locations');
		$this->load->model('Notices');
		$this->load->model('Persons');
		$this->load->model('Reminders');
		$fid = array();
		// Get calendar data
		if (date('G') >= 5)
		{
			$begin = strtotime('today 5am');
			$end = strtotime('tomorrow 5am');
		}
		else
		{
			$begin = strtotime('yesterday 5am');
			$end = strtotime('today 5am');
		}
		$data['designations'] = $this->Designations->filter($begin, $end);
		if ( ! is_null($data['designations']))
		{
			foreach ($data['designations'] as $object)
			{
				$data['instructions']['genres'][$object->did] = $this->Instructions->filter('G', NULL, $object->did);
				if ( ! isset($data['events'][$object->eid]))
				{
					$data['instructions']['persons'][$object->eid] = $this->Instructions->filter('P', $object->eid);
					if ( ! is_null($data['instructions']['persons'][$object->eid]))
					{
						foreach ($data['instructions']['persons'][$object->eid] as $item)
						{
							$data['persons'][$item->pid] = $this->Persons->search($item->pid);
						}
					}
					$data['events'][$object->eid] = $this->Events->search($object->eid);
				}
			}
		}
		// Get reminders data
		$data['reminders'] = $this->Reminders->available();
		if ( ! is_null($data['reminders']))
		{
			foreach ($data['reminders'] as $object)
			{
				$fid[] = $object->fid;
			}
		}
		// Get genres data
		$data['genres'] = $this->Genres->available();
		// Get location data
		$data['locations'] = $this->Locations->available();
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
		$this->load->view('external/welcome', $data);
		$this->load->view('external/footer');
	}
	
	private function internal()
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
				$this->load->model('Values');
				$fid = array();
				if ( !! strlen($this->input->post('pid/card/code')))
				{
					$this->load->model('Files');
					$this->load->model('Jobs');
					$this->load->model('Memberships');
					$this->load->model('Values');
					// POSTed: Search (Search by pid, if not found search by card, if not by value code)
					$data['persons']['request'] = $this->Persons->search($this->input->post('pid/card/code'));
					if (is_null($data['persons']['request']))
					{
						$data['persons']['request'] = $this->Persons->search(NULL, NULL, NULL, NULL, $this->input->post('pid/card/code'));
					}
					if ( ! is_null($data['persons']['request']))
					{
						if ( ! is_null($data['persons']['request']->fid))
						{
							$fid[] = $data['persons']['request']->fid;
						}
						$data['memberships'] = $this->Memberships->check($data['persons']['request']->pid);
						$data['jobs'] = $this->Jobs->check(NULL, $data['persons']['request']->pid);
					}
					else
					{
						$data['values'] = $this->Values->check($this->input->post('pid/card/code'));
						if (is_null($data['values'])) // no balance?
						{
							$data['error'] = 'No such person/ value.';
						}
					}
				}
				// POSTed: Enter new arrival record
				elseif ( !! strlen($this->input->post('category')))
				{
					switch ($this->input->post('category'))
					{
						case 'E/D':
							if ( ! empty($this->input->post('did')))
							{
								$amount = 0.00;
								foreach ($this->input->post('did') as $object)
								{
									switch ($this->input->post('payment'))
									{
										case 'CA/CHK';
										case 'CC/DC':
											if ( ! ( !! strlen($this->input->post('pid')) && ! is_null($this->Arrivals->check('E/D', $this->input->post('pid'), $object))) && isset($this->input->post('amount')[$object]))
											{
												$amount += $this->input->post('amount')[$object];
											}
									}
								}
								if ($amount > 0.00)
								{
									if ( !! strlen($this->input->post('vid')))
									{
										// check value still usable, if not:
										// $data['error'] = 'No balance.';
										$oid = $this->Orders->add(
											'A',
											$this->Transactions->add(
												$this->input->post('payment'),
												$amount,
												NULL,
												$this->input->post('vid')
											)
										);
									}
									else
									{
										$oid = $this->Orders->add(
											'A',
											$this->Transactions->add(
												$this->input->post('payment'),
												$amount
											)
										);
									}
								}
								else
								{
									$oid = $this->Orders->add('A');
								}
								foreach ($this->input->post('did') as $object)
								{
									switch ($this->input->post('payment'))
									{
										case 'CA/CHK';
										case 'CC/DC':
											// If there's a person id
											if ( !! strlen($this->input->post('pid')))
											{
												if (is_null($this->Arrivals->check('E/D', $this->input->post('pid'), $object)))
												{
													$return = $this->Arrivals->add(
														$oid,
														'E/D',
														$this->input->post('amount')[$object],
														$this->input->post('pid'),
														NULL,
														$object
													);
													if ( !! $return)
													{
														$data['done'][] = 'You registered this person.';
													}
													else
													{
														$data['error'] = 'You cannot register this person.';
													}
												}
												else
												{
													$data['error'] = 'You cannot re-register this person in this event.';
												}
											}
											// If there's a value id/ no id
											else
											{
												$return = $this->Arrivals->add(
													$oid,
													'E/D',
													$this->input->post('amount')[$object],
													NULL,
													NULL,
													$object
												);
												if ( !! $return)
												{
													$data['done'][] = 'You registered this person.';
												}
												else
												{
													$data['error'] = 'You cannot register this person.';
												}
											}
											break;
										case NULL;
										case '':
											if ( !! strlen($this->input->post('pid')))
											{
												if (is_null($this->Arrivals->check('E/D', $this->input->post('pid'), $object)))
												{
													$return = $this->Arrivals->add(
														$oid,
														'E/D',
														NULL,
														$this->input->post('pid'),
														NULL,
														$object
													);
													if ( !! $return)
													{
														$data['done'][] = 'You registered this person.';
													}
													else
													{
														$data['error'] = 'You cannot register this person.';
													}
												}
												else
												{
													$data['error'] = 'You cannot re-register this person in this event.';
												}
											}
											// If there's a value id/ no id
											else
											{
												$return = $this->Arrivals->add(
													$oid,
													'E/D',
													NULL,
													NULL,
													NULL,
													$object
												);
												if ( !! $return)
												{
													$data['done'][] = 'You registered this person.';
												}
												else
												{
													$data['error'] = 'You cannot register this person.';
												}
											}
											break;
										default:
											$data['error'] = 'No such payment.';
									}
								}
							}
							else
							{
								$data['error'] = 'No data received as expected.';
							}
							break;
						case 'FLOOR':
							if ( !! strlen($this->input->post('type')))
							{
								switch ($this->input->post('type'))
								{
									case 'P';
									case 'PL';
									case 'RR':
										switch ($this->input->post('payment'))
										{
											case 'CA/CHK';
											case 'CC/DC':
												if ( !! strlen($this->input->post('amount')))
												{
													// If there's a person id
													if ( !! strlen($this->input->post('pid')))
													{
														if (is_null($this->Arrivals->check('FLOOR', $this->input->post('pid'), NULL, $this->input->post('type'))))
														{
															$return = $this->Arrivals->add(
																$this->Orders->add(
																	'A',
																	$this->Transactions->add(
																		$this->input->post('payment'),
																		$this->input->post('amount')
																	)
																),
																'FLOOR',
																$this->input->post('amount'),
																$this->input->post('pid'),
																NULL,
																NULL,
																$this->input->post('type')
															);
															if ( !! $return)
															{
																$data['done'][] = 'You registered this person.';
															}
															else
															{
																$data['error'] = 'You cannot register this person.';
															}
														}
														else
														{
															$data['error'] = 'You cannot re-register this person.';
														}
													}
													// If no id
													elseif ( !! strlen($this->input->post('fullname')))
													{
														$return = $this->Arrivals->add(
															$this->Orders->add(
																'A',
																$this->Transactions->add(
																	$this->input->post('payment'),
																	$this->input->post('amount')
																)
															),
															'FLOOR',
															$this->input->post('amount'),
															NULL,
															$this->input->post('fullname'),
															NULL,
															$this->input->post('type')
														);
														if ( !! $return)
														{
															$data['done'][] = 'You registered this person.';
														}
														else
														{
															$data['error'] = 'You cannot register this person.';
														}
													}
													else
													{
														$data['error'] = 'No data received as expected.';
													}
												}
												else
												{
													$data['error'] = 'No data received as expected.';
												}
												break;
											case NULL;
											case '':
												// If there's a person id
												if ( !! strlen($this->input->post('pid')))
												{
													if (is_null($this->Arrivals->check('FLOOR', $this->input->post('pid'), NULL, $this->input->post('type'))))
													{
														$return = $this->Arrivals->add(
															$this->Orders->add('A'),
															'FLOOR',
															NULL,
															$this->input->post('pid'),
															NULL,
															NULL,
															$this->input->post('type')
														);
														if ( !! $return)
														{
															$data['done'][] = 'You registered this person.';
														}
														else
														{
															$data['error'] = 'You cannot register this person.';
														}
													}
													else
													{
														$data['error'] = 'You cannot re-register this person.';
													}
												}
												// If no id
												elseif ( !! strlen($this->input->post('fullname')))
												{
													$return = $this->Arrivals->add(
														$this->Orders->add('A'),
														'FLOOR',
														NULL,
														NULL,
														$this->input->post('fullname'),
														NULL,
														$this->input->post('type')
													);
													if ( !! $return)
													{
														$data['done'][] = 'You registered this person.';
													}
													else
													{
														$data['error'] = 'You cannot register this person.';
													}
												}
												else
												{
													$data['error'] = 'No data received as expected.';
												}
												break;
											default:
												$data['error'] = 'No such payment.';
										}
										break;
									default:
										$data['error'] = 'No such type.';
								}
							}
							else
							{
								$data['error'] = 'No data received as expected.';
							}
							break;
						default:
							$data['error'] = 'No data received as expected.';
					}
				}
				// POSTed: Reverse arrival record
				elseif ( ! empty($this->input->post('aid')))
				{
					foreach ($this->input->post('aid') as $object)
					{
						if ( !! strlen($this->input->post('reason')[$object]))
						{
							$arrivals = $this->Arrivals->search($object);
							if ( ! is_null($arrivals))
							{
								$return = $this->Arrivals->reverse($object, $this->input->post('reason')[$object]);
								if ( !! $return)
								{
									$orders = $this->Orders->search($arrivals->oid);
									if ( ! is_null($orders))
									{
										if ( ! is_null($orders->tid))
										{
											$transactions = $this->Transactions->search($orders->tid);
											if ( ! is_null($transactions))
											{
												$return = $this->Orders->cancel($arrivals->oid);
												if ( !! $return)
												{
													// vid
													if ($transactions->amount - $arrivals->amount > 0.00)
													{
														$oid = $this->Orders->add(
															$orders->category,
															$this->Transactions->add(
																$transactions->payment,
																$transactions->amount - $arrivals->amount
															)
														);
														$return = $this->Arrivals->edit($arrivals->aid, $oid);
														if ( !! $return)
														{
															$data['done'][] = 'You reversed this person.';
														}
														else
														{
															$data['error'] = 'You cannot reverse this person.';
														}
													}
													else
													{
														$data['done'][] = 'You reversed this person.';
													}
												}
												else
												{
													$data['error'] = 'You cannot reverse this person.';
												}
											}
											else
											{
												$data['error'] = 'You cannot reverse this person.';
											}
										}
										else
										{
											$return = $this->Orders->cancel($arrivals->oid);
											if ( !! $return)
											{
												$data['done'][] = 'You reversed this person.';
											}
											else
											{
												$data['error'] = 'You cannot reverse this person.';
											}
										}
									}
									else
									{
										$data['error'] = 'You cannot reverse this person.';
									}
								}
								else
								{
									$data['error'] = 'You cannot reverse this person after exceeded 30 minutes limit.';
								}
							}
							else
							{
								$data['error'] = 'You cannot reverse this person.';
							}
						}
					}
				}
				elseif ( ! empty($this->input->post()))
				{
					$data['error'] = 'No data received as expected.';
				}
				// Get current calendar data
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
				$data['designations'] = NULL;
				$designations = $this->Designations->filter($begin, $end);
				// Get related info and count head
				if ( ! is_null($designations))
				{
					foreach ($designations as $object)
					{
						$data['designations'][$object->did] = $object;
					}
					foreach ($data['designations'] as $object)
					{
						$data['instructions']['genres'][$object->did] = $this->Instructions->filter('G', NULL, $object->did);
						if ( ! isset($data['events'][$object->eid]))
						{
							$data['instructions']['persons'][$object->eid] = $this->Instructions->filter('P', $object->eid);
							$data['events'][$object->eid] = $this->Events->search($object->eid);
						}
						$data['arrivals']['count'][$object->did] = $this->Arrivals->filter(array($begin, $end), NULL, 'E/D', NULL, $object->did);
						if ( ! is_null($data['arrivals']['count'][$object->did]))
						{
							$data['arrivals']['count'][$object->did] = count($data['arrivals']['count'][$object->did]);
						}
						else
						{
							$data['arrivals']['count'][$object->did] = 0;
						}
					}
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
				// Get arrivals history and transactions data within 30 minutes
				$data['arrivals']['available'] = $this->Arrivals->available();
				if ( ! is_null($data['arrivals']['available']))
				{
					foreach ($data['arrivals']['available'] as $object)
					{
						if ( ! is_null($object->did) && ! is_null($data['designations'][$object->did]) && ! isset($data['events'][$data['designations'][$object->did]->eid]))
						{
							$data['events'][$data['designations'][$object->did]->eid] = $this->Events->search($data['designations'][$object->did]->eid);
						}
						if ( ! is_null($object->pid) && ! isset($data['persons'][$object->pid]))
						{
							$data['persons'][$object->pid] = $this->Persons->search($object->pid);
						}
						if ( ! is_null($object->oid))
						{
							$data['orders'][$object->oid] = $this->Orders->search($object->oid);
							if ( ! is_null($data['orders'][$object->oid]) && ! is_null($data['orders'][$object->oid]->tid) && ! isset($data['transactions'][$data['orders'][$object->oid]->tid]))
							{
								$data['transactions'][$data['orders'][$object->oid]->tid] = $this->Transactions->search($data['orders'][$object->oid]->tid);
							}
						}
					}
				}
				if (isset($fid) && !! count($fid))
				{
					$fid = array_unique($fid);
					foreach ($fid as $object)
					{
						$data['files'][$object] = $this->Files->read($object);
					}
				}
				if (isset($data['done']))
				{
					$data['done'] = array_unique($data['done']);
				}
				$this->load->view('internal/header', $data);
				$this->load->view('internal/welcome', $data);
				$this->load->view('internal/footer');
				break;
			default:
				show_404();
		}
	}
}


/* End of file Welcome.php */
/* Location: ./application/controllers/Welcome.php */