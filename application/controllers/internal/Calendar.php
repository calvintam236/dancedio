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

class Calendar extends CI_Controller
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
			case 'O';
			case 'S';
			case 'A':
				if ( !! strlen($this->input->post('label')) || !! strlen($this->input->post('eid')) || !! strlen($this->input->post('action')))
				{
					$this->load->model('Copartnerships');
					$this->load->model('Designations');
					$this->load->model('Events');
					$this->load->model('Instructions');
					$this->load->model('Persons');
					// POSTed: Search
					if ( ! strlen($this->input->post('action')) && !! strlen($this->input->post('label')))
					{
						$data['events'] = $this->Events->search(NULL, $this->input->post('label'));
						if ( ! is_null($data['events']) && ! isset($data['events']->eid))
						{
							foreach ($data['events'] as $object)
							{
								$data['instructions']['genres']['E'][$object->eid] = $this->Instructions->filter('G', $object->eid);
							}
						}
						elseif (is_null($data['events']))
						{
							$data['error'] = 'No such event.';
						}
					}
					// POSTed: Select a event
					elseif ( ! strlen($this->input->post('action')) && !! strlen($this->input->post('eid')))
					{
						$data['events'] = $this->Events->search($this->input->post('eid'));
					}
					// POSTed: Event info changes
					elseif ( ! strlen($this->input->post('extra')))
					{
						switch ($this->input->post('action'))
						{
							case 'add':
								switch ($this->input->post('repetition'))
								{
									case NULL;
									case '':
										if ( !! strlen($this->input->post('category')) && !! strlen($this->input->post('label')) && !! strlen($this->input->post('lid')))
										{
											if ( ! ( ! strlen($this->input->post('price')) && !! strlen($this->input->post('discount'))))
											{
												if ( ! ( !! strlen($this->input->post('discount')) && $this->input->post('price') < $this->input->post('discount')))
												{
													if ( ! (( ! strlen($this->input->post('price')) & !! strlen($this->input->post('pricenote'))) || ( ! strlen($this->input->post('discount')) & !! strlen($this->input->post('discountnote')))))
													{
														$eid = $this->Events->add(
															$this->input->post('category'),
															$this->input->post('label'),
															$this->input->post('lid'),
															$this->input->post('level'),
															$this->input->post('name'),
															$this->input->post('price'),
															$this->input->post('discount'),
															$this->input->post('pricenote'),
															$this->input->post('discountnote'),
															$this->input->post('account'),
															$this->input->post('repetition')
														);
													}
													else
													{
														$data['error'] = 'You cannot set note when price/ discount is not set.';
													}
												}
												else
												{
													$data['error'] = 'You cannot set discount larger than price.';
												}
											}
											else
											{
												$data['error'] = 'You cannot set discount if price is not set.';
											}
										}
										else
										{
											$data['error'] = 'No data received as expected.';
										}
										break;
									case 'W';
									case 'W1';
									case 'W2';
									case 'W3';
									case 'W4';
									case 'W5':
										if ( !! strlen($this->input->post('category')) && !! strlen($this->input->post('label')) && !! strlen($this->input->post('lid')) && !! strlen($this->input->post('frequency')) && !! strlen($this->input->post('begindate')) && !! strlen($this->input->post('enddate')) && !! strlen($this->input->post('begintime')) && !! strlen($this->input->post('endtime')))
										{
											if ( ! ( ! strlen($this->input->post('price')) && !! strlen($this->input->post('discount'))))
											{
												if ( ! ( !! strlen($this->input->post('discount')) && $this->input->post('price') < $this->input->post('discount')))
												{
													if ( ! (( ! strlen($this->input->post('price')) & !! strlen($this->input->post('pricenote'))) || ( ! strlen($this->input->post('discount')) & !! strlen($this->input->post('discountnote')))))
													{
														$eid = $this->Events->add(
															$this->input->post('category'),
															$this->input->post('label'),
															$this->input->post('lid'),
															$this->input->post('level'),
															$this->input->post('name'),
															$this->input->post('price'),
															$this->input->post('discount'),
															$this->input->post('pricenote'),
															$this->input->post('discountnote'),
															$this->input->post('account'),
															$this->input->post('repetition'),
															$this->input->post('frequency'),
															$this->input->post('begindate'),
															$this->input->post('enddate'),
															$this->input->post('begintime'),
															$this->input->post('endtime')
														);
													}
													else
													{
														$data['error'] = 'You cannot set note when price/ discount is not set.';
													}
												}
												else
												{
													$data['error'] = 'You cannot set discount larger than price.';
												}
											}
											else
											{
												$data['error'] = 'You cannot set discount if price is not set.';
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
								if (isset($eid))
								{
									$data['events'] = $this->Events->search($eid);
									$data['done'][] = 'You added this event.';
								}
								break;
							case 'edit':
								if ( !! strlen($this->input->post('eid')))
								{
									switch ($this->input->post('repetition'))
									{
										case NULL;
										case '':
											if ( !! strlen($this->input->post('category')) && !! strlen($this->input->post('label')) && !! strlen($this->input->post('lid')))
											{
												if ( ! ( ! strlen($this->input->post('price')) && !! strlen($this->input->post('discount'))))
												{
													if ( ! ( !! strlen($this->input->post('discount')) && $this->input->post('price') < $this->input->post('discount')))
													{
														$return = $this->Events->edit(
															$this->input->post('eid'),
															$this->input->post('category'),
															$this->input->post('label'),
															$this->input->post('lid'),
															$this->input->post('level'),
															$this->input->post('name'),
															$this->input->post('price'),
															$this->input->post('discount'),
															$this->input->post('pricenote'),
															$this->input->post('discountnote'),
															$this->input->post('account'),
															$this->input->post('repetition')
														);
														if ( !! $return)
														{
															$data['done'][] = 'You edited this event.';
														}
														else
														{
															$data['error'] = 'You cannot edit/ cancel this event/ no changes.';
														}
													}
													else
													{
														$data['error'] = 'You cannot set discount larger than price.';
													}
												}
												else
												{
													$data['error'] = 'You cannot set discount if price is not set.';
												}
												$data['events'] = $this->Events->search($this->input->post('eid'));
											}
											else
											{
												$data['error'] = 'No data received as expected.';
											}
											break;
										case 'W';
										case 'W1';
										case 'W2';
										case 'W3';
										case 'W4';
										case 'W5':
											if ( !! strlen($this->input->post('category')) && !! strlen($this->input->post('label')) && !! strlen($this->input->post('lid')) && !! strlen($this->input->post('frequency')) && !! strlen($this->input->post('begindate')) && !! strlen($this->input->post('enddate')) && !! strlen($this->input->post('begintime')) && !! strlen($this->input->post('endtime')))
											{
												if ( ! ( ! strlen($this->input->post('price')) && !! strlen($this->input->post('discount'))))
												{
													if ( ! ( !! strlen($this->input->post('discount')) && $this->input->post('price') < $this->input->post('discount')))
													{
														$return = $this->Events->edit(
															$this->input->post('eid'),
															$this->input->post('category'),
															$this->input->post('label'),
															$this->input->post('lid'),
															$this->input->post('level'),
															$this->input->post('name'),
															$this->input->post('price'),
															$this->input->post('discount'),
															$this->input->post('pricenote'),
															$this->input->post('discountnote'),
															$this->input->post('account'),
															$this->input->post('repetition'),
															$this->input->post('frequency'),
															$this->input->post('begindate'),
															$this->input->post('enddate'),
															$this->input->post('begintime'),
															$this->input->post('endtime')
														);
														if ( !! $return)
														{
															$data['done'][] = 'You edited this event.';
														}
														else
														{
															$data['error'] = 'You cannot edit/ cancel this event/ no changes.';
														}
													}
													else
													{
														$data['error'] = 'You cannot set discount larger than price.';
													}
												}
												else
												{
													$data['error'] = 'You cannot set discount if price is not set.';
												}
												$data['events'] = $this->Events->search($this->input->post('eid'));
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
								else
								{
									$data['error'] = 'No data received as expected.';
								}
								break;
							case 'cancel':
								if ( !! strlen($this->input->post('eid')))
								{
									$return = $this->Events->cancel($this->input->post('eid'));
									if ( !! $return)
									{
										$data['done'][] = 'You cancelled this event.';
									}
									else
									{
										$data['error'] = 'You cannot edit/ cancel this event.';
									}
								}
								else
								{
									$data['error'] = 'No data received as expected.';
								}
								break;
							default:
								$data['error'] = 'No such action.';
						}
						if (isset($data['events']) && ! is_null($data['events']))
						{
							switch ($this->input->post('action'))
							{
								case 'add';
								case 'edit':
									switch ($data['events']->repetition)
									{
										case NULL;
										case '':
											if ( !! strlen($this->input->post('begindate')) && !! strlen($this->input->post('enddate')) && !! strlen($this->input->post('begintime')) && !! strlen($this->input->post('endtime')))
											{
												$begin = $this->input->post('begindate').'T'.$this->input->post('begintime');
												$end = $this->input->post('enddate').'T'.$this->input->post('endtime');
												if ($begin <= $end)
												{
													if (is_null($this->Designations->check($data['events']->eid, strtotime($begin), strtotime($end))))
													{
														$this->Designations->add(
															$data['events']->eid,
															$begin,
															$end
														);
														$data['done'][] = 'You generated designation(s).';
													}
												}
												else
												{
													$data['error'] = 'You cannot set end time earlier than begin time.';
												}
											}
											elseif ($this->input->post('action') == 'add')
											{
												$data['error'] = 'No data received as expected.';
											}
											break;
										case 'W':
											if (date('G') >= 5)
											{
												$pointer = strtotime('today 5am');
											}
											else
											{
												$pointer = strtotime('yesterday 5am');
											}
											if ($pointer < $data['events']->begindate)
											{
												$pointer = $data['events']->begindate;
											}
											while ($pointer <= $data['events']->enddate)
											{
												if (strtoupper(date('D', $pointer)) == $data['events']->frequency)
												{
													if ($data['events']->endtime >= $data['events']->begintime)
													{
														$begin = date('Y-m-d', $pointer).'T'.date('H:i', $data['events']->begintime);
														$end = date('Y-m-d', $pointer).'T'.date('H:i', $data['events']->endtime);
													}
													else
													{
														$begin = date('Y-m-d', $pointer).'T'.date('H:i', $data['events']->begintime);
														$end = date('Y-m-d', strtotime('+1 day', $pointer)).'T'.date('H:i', $data['events']->endtime);
													}
													if (is_null($this->Designations->check($data['events']->eid, strtotime($begin), strtotime($end))))
													{
														$this->Designations->add(
															$data['events']->eid,
															$begin,
															$end
														);
														$data['done'][] = 'You generated designation(s).';
													}
													$pointer = strtotime('+1 week', $pointer);
												}
												else
												{
													$pointer = strtotime('+1 day', $pointer);
												}
											}
											break;
										case 'W1';
										case 'W2';
										case 'W3';
										case 'W4';
										case 'W5':
											if (date('G') >= 5)
											{
												$pointer = strtotime('today 5am');
											}
											else
											{
												$pointer = strtotime('yesterday 5am');
											}
											if ($pointer < $data['events']->begindate)
											{
												$pointer = $data['events']->begindate;
											}
											while ($pointer <= $data['events']->enddate)
											{
												if (strtoupper(date('D', $pointer)) == $data['events']->frequency)
												{
													if (ceil(date('j', $pointer) / 7) == $data['events']->repetition[1])
													{
														if ($data['events']->endtime >= $data['events']->begintime)
														{
															$begin = date('Y-m-d', $pointer).'T'.date('H:i', $data['events']->begintime);
															$end = date('Y-m-d', $pointer).'T'.date('H:i', $data['events']->endtime);
														}
														else
														{
															$begin = date('Y-m-d', $pointer).'T'.date('H:i', $data['events']->begintime);
															$end = date('Y-m-d', strtotime('+1 day', $pointer)).'T'.date('H:i', $data['events']->endtime);
														}
														if (is_null($this->Designations->check($data['events']->eid, strtotime($begin), strtotime($end))))
														{
															$this->Designations->add(
																$data['events']->eid,
																$begin,
																$end
															);
															$data['done'][] = 'You generated designation(s).';
														}
													}
													$pointer = strtotime('+1 week', $pointer);
												}
												else
												{
													$pointer = strtotime('+1 day', $pointer);
												}
											}
									}
							}
						}
					}
					// POSTed: Related info changes
					elseif ( !! strlen($this->input->post('eid')))
					{
						$data['events'] = $this->Events->search($this->input->post('eid'));
						if ( ! is_null($data['events']))
						{
							switch ($this->input->post('extra'))
							{
								case 'instructions[persons]':
									switch ($this->input->post('action'))
									{
										case 'add/remove':
											if ( ! empty($this->input->post('pid')))
											{
												foreach ($this->input->post('pid') as $object)
												{
													if ( !! strlen($object) && ! $this->Instructions->filter('P', $data['events']->eid, NULL, $object))
													{
														$this->Instructions->add(
															'P',
															$data['events']->eid,
															NULL,
															$object
														);
														$data['done'][] = 'You added person(s) for instruction.';
													}
												}
												$instructions['persons'] = $this->Instructions->filter('P', $data['events']->eid);
												if ( ! is_null($instructions['persons']))
												{
													foreach ($instructions['persons'] as $object)
													{
														if (array_search($object->pid, $this->input->post('pid')) === FALSE)
														{
															$return = $this->Instructions->remove($object->iid);
															if ( !! $return)
															{
																$data['done'][] = 'You removed person(s) for instruction.';
															}
															else
															{
																$data['error'] = 'You cannot remove person(s) for instruction.';
															}
														}
													}
												}
											}
											else
											{
												$data['error'] = 'No data received as expected.';
											}
											break;
										default:
											$data['error'] = 'No such action.';
									}
									break;
								case 'instructions[genres][E]':
									switch ($this->input->post('action'))
									{
										case 'add/remove':
											if ( ! empty($this->input->post('gid')))
											{
												foreach ($this->input->post('gid') as $object)
												{
													if ( !! strlen($object) && ! $this->Instructions->filter('G', $data['events']->eid, NULL, NULL, $object))
													{
														$this->Instructions->add(
															'G',
															$data['events']->eid,
															NULL,
															NULL,
															$object
														);
														$data['done'][] = 'You added genre(s) for instruction.';
													}
												}
												$instructions['genres']['E'] = $this->Instructions->filter('G', $data['events']->eid);
												if ( ! is_null($instructions['genres']['E']))
												{
													foreach ($instructions['genres']['E'] as $object)
													{
														if (array_search($object->gid, $this->input->post('gid')) === FALSE)
														{
															$return = $this->Instructions->remove($object->iid);
															if ( !! $return)
															{
																$data['done'][] = 'You removed genre(s) for instruction.';
															}
															else
															{
																$data['error'] = 'You cannot remove genre(s) for instruction.';
															}
														}
													}
												}
											}
											else
											{
												$data['error'] = 'No data received as expected.';
											}
											break;
										case 'instructions[genres][D]':
											// unfinish
											break;
										default:
											$data['error'] = 'No such action.';
									}
									break;
								case 'designations':
									switch ($this->input->post('action'))
									{
										case 'edit/cancel':
											if ( ! empty($this->input->post('did')))
											{
												foreach ($this->input->post('did') as $object)
												{
													if ( ! strlen($this->input->post('reason')[$object]))
													{
														if ( !! strlen($this->input->post('begin')[$object]) && !! strlen($this->input->post('end')[$object]))
														{
															$return = $this->Designations->edit(
																$object,
																$this->input->post('begin')[$object],
																$this->input->post('end')[$object],
																$this->input->post('note')[$object]
															);
															if ( !! $return)
															{
																$data['done'][] = 'You edited this designation.';
															}
															else
															{
																$data['error'] = 'You cannot edit/ cancel this designation/ no changes.';
															}
														}
														else
														{
															$data['error'] = 'No data received as expected.';
														}
													}
													else
													{
														$return = $this->Designations->cancel(
															$object,
															$this->input->post('reason')[$object]
														);
														if ( !! $return)
														{
															$data['done'][] = 'You cancelled this designation.';
														}
														else
														{
															$data['error'] = 'You cannot edit/ cancel this designation/ no changes.';
														}
													}
												}
											}
											else
											{
												$data['error'] = 'No data received as expected.';
											}
											break;
										default:
											$data['error'] = 'No such action.';
									}
									break;
								default:
									$data['error'] = 'No data received as expected.';
							}
						}
						else
						{
							$data['error'] = 'No such event.';
						}
					}
					else
					{
						$data['error'] = 'No data received as expected.';
					}
					// Get updated event and related info
					if (isset($data['events']) && ! is_null($data['events']) && isset($data['events']->eid))
					{
						$data['instructions']['persons'] = $this->Instructions->filter('P', $data['events']->eid);
						$data['instructions']['genres']['E'] = $this->Instructions->filter('G', $data['events']->eid);
						$data['designations'] = $this->Designations->history($data['events']->eid);
						if ( ! is_null($data['designations']))
						{
							foreach ($data['designations'] as $object)
							{
								$data['instructions']['genres']['D'][$object->did] = $this->Instructions->filter('G', NULL, $object->did);
							}
						}
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
					}
				}
				elseif ( ! empty($this->input->post()))
				{
					$data['error'] = 'No data received as expected.';
				}
				$this->load->model('Genres');
				$this->load->model('Locations');
				// Get genres data
				$data['genres'] = $this->Genres->available();
				// Get locations data
				$data['locations'] = $this->Locations->available();
				if (isset($data['done']))
				{
					$data['done'] = array_unique($data['done']);
				}
				$this->load->view('internal/header', $data);
				$this->load->view('internal/calendar', $data);
				$this->load->view('internal/footer');
				break;
			default:
				show_404();
		}
	}
}


/* End of file Calendar.php */
/* Location: ./application/controllers/internal/Calendar.php */