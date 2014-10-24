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

class Relationships extends CI_Controller
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
				if ( !! strlen($this->input->post('pid/lastname/card')) || !! strlen($this->input->post('pid')) || !! strlen($this->input->post('action')))
				{
					$this->load->model('Arrivals');
					$this->load->model('Copartnerships');
					$this->load->model('Files');
					$this->load->model('Jobs');
					$this->load->model('Persons');
					$this->load->model('Memberships');
					$fid = array();
					// POSTed: Search (Search by pid, if not found search by last name, if not by card)
					if ( ! strlen($this->input->post('action')) && !! strlen($this->input->post('pid/lastname/card')))
					{
						$data['persons'] = $this->Persons->search($this->input->post('pid/lastname/card'));
						if (is_null($data['persons']))
						{
							$data['persons'] = $this->Persons->search(NULL, NULL, $this->input->post('pid/lastname/card'));
						}
						if (is_null($data['persons']))
						{
							$data['persons'] = $this->Persons->search(NULL, NULL, NULL, NULL, $this->input->post('pid/lastname/card'));
						}
						if (is_null($data['persons']))
						{
							$data['error'] = 'No such person.';
						}
					}
					// POSTed: Select a person
					elseif ( ! strlen($this->input->post('action')) && !! strlen($this->input->post('pid')))
					{
						$data['persons'] = $this->Persons->search($this->input->post('pid'));
					}
					// POSTed: Persons info changes
					elseif ( ! strlen($this->input->post('extra')))
					{
						switch ($this->input->post('action'))
						{
							case 'add':
								if ( !! strlen($this->input->post('firstname')) && !! strlen($this->input->post('lastname')) && !! strlen($this->input->post('email')) && !! strlen($this->input->post('cellphone')))
								{
									$this->load->library('upload', array('upload_path' => sys_get_temp_dir(), 'allowed_types' => 'jpg'/*, 'min_width' => 640, 'min_height' => 480*/));
									if ( !! $this->upload->do_upload('photo'))
									{
										if (is_null($this->Files->search(file_get_contents($this->upload->data()['full_path']))))
										{
											$pid = $this->Persons->add(
												NULL,
												$this->input->post('firstname'),
												$this->input->post('lastname'),
												$this->input->post('address'),
												$this->input->post('city'),
												$this->input->post('state'),
												$this->input->post('zipcode'),
												$this->input->post('email'),
												$this->input->post('cellphone'),
												$this->input->post('homephone'),
												$this->input->post('emergencyphone'),
												$this->input->post('birthmonth'),
												$this->input->post('note'),
												$this->input->post('card'),
												$this->Files->write(file_get_contents($this->upload->data()['full_path']))
											);
										}
										else
										{
											$pid = $this->Persons->add(
												NULL,
												$this->input->post('firstname'),
												$this->input->post('lastname'),
												$this->input->post('address'),
												$this->input->post('city'),
												$this->input->post('state'),
												$this->input->post('zipcode'),
												$this->input->post('email'),
												$this->input->post('cellphone'),
												$this->input->post('homephone'),
												$this->input->post('emergencyphone'),
												$this->input->post('birthmonth'),
												$this->input->post('note'),
												$this->input->post('card'),
												$this->Files->search(file_get_contents($this->upload->data()['full_path']))->fid
											);
										}
										$data['done'][] = 'You added this person with photo.';
									}
									elseif ($this->upload->display_errors('', '') == 'You did not select a file to upload.')
									{
										$pid = $this->Persons->add(
											NULL,
											$this->input->post('firstname'),
											$this->input->post('lastname'),
											$this->input->post('address'),
											$this->input->post('city'),
											$this->input->post('state'),
											$this->input->post('zipcode'),
											$this->input->post('email'),
											$this->input->post('cellphone'),
											$this->input->post('homephone'),
											$this->input->post('emergencyphone'),
											$this->input->post('birthmonth'),
											$this->input->post('note'),
											$this->input->post('card')
										);
										$data['done'][] = 'You added this person without photo.';
									}
									else
									{
										$data['error'] = $this->upload->display_errors('', '');
									}
									if (isset($pid))
									{
										$data['persons'] = $this->Persons->search($pid);
									}
								}
								else
								{
									$data['error'] = 'No data received as expected.';
								}
								break;
							case 'edit/disable':
								if ( !! strlen($this->input->post('pid')))
								{
									if ( ! strlen($this->input->post('reason')))
									{
										if ( !! strlen($this->input->post('firstname')) && !! strlen($this->input->post('lastname')) && !! strlen($this->input->post('email')) && !! strlen($this->input->post('cellphone')))
										{
											$this->load->library('upload', array('upload_path' => sys_get_temp_dir(), 'allowed_types' => 'jpg'/*, 'min_width' => 640, 'min_height' => 480*/));
											if ( !! $this->upload->do_upload('photo'))
											{
												if (is_null($this->Files->search(file_get_contents($this->upload->data()['full_path']))))
												{
													$return = $this->Persons->edit(
														$this->input->post('pid'),
														$this->input->post('firstname'),
														$this->input->post('lastname'),
														$this->input->post('address'),
														$this->input->post('city'),
														$this->input->post('state'),
														$this->input->post('zipcode'),
														$this->input->post('email'),
														$this->input->post('cellphone'),
														$this->input->post('homephone'),
														$this->input->post('emergencyphone'),
														$this->input->post('birthmonth'),
														$this->input->post('note'),
														$this->input->post('card'),
														$this->Files->write(file_get_contents($this->upload->data()['full_path']))
													);
												}
												else
												{
													$return = $this->Persons->edit(
														$this->input->post('pid'),
														$this->input->post('firstname'),
														$this->input->post('lastname'),
														$this->input->post('address'),
														$this->input->post('city'),
														$this->input->post('state'),
														$this->input->post('zipcode'),
														$this->input->post('email'),
														$this->input->post('cellphone'),
														$this->input->post('homephone'),
														$this->input->post('emergencyphone'),
														$this->input->post('birthmonth'),
														$this->input->post('note'),
														$this->input->post('card'),
														$this->Files->search(file_get_contents($this->upload->data()['full_path']))->fid
													);
												}
											}
											elseif ($this->upload->display_errors('', '') == 'You did not select a file to upload.')
											{
												$return = $this->Persons->edit(
													$this->input->post('pid'),
													$this->input->post('firstname'),
													$this->input->post('lastname'),
													$this->input->post('address'),
													$this->input->post('city'),
													$this->input->post('state'),
													$this->input->post('zipcode'),
													$this->input->post('email'),
													$this->input->post('cellphone'),
													$this->input->post('homephone'),
													$this->input->post('emergencyphone'),
													$this->input->post('birthmonth'),
													$this->input->post('note'),
													$this->input->post('card')
												);
											}
											else
											{
												$data['error'] = $this->upload->display_errors('', '');
											}
											$data['persons'] = $this->Persons->search($this->input->post('pid'));
											if (isset($return) && !! $return)
											{
												$data['done'][] = 'You edited this person with/ without new photo.';
											}
											else
											{
												$data['error'] = 'You cannot edit this person/ no changes.';
											}
										}
										else
										{
											$data['error'] = 'No data received as expected.';
										}
									}
									else
									{
										$return = $this->Persons->disable($this->input->post('pid'), $this->input->post('reason'));
										if ( !! $return)
										{
											$data['done'][] = 'You disabled this person.';
										}
										else
										{
											$data['error'] = 'You cannot disable this person.';
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
					}
					// POSTed: Related info changes
					elseif ( !! strlen($this->input->post('pid')))
					{
						$data['persons'] = $this->Persons->search($this->input->post('pid'));
						if ( ! is_null($data['persons']))
						{
							switch ($this->input->post('extra'))
							{
								case 'memberships':
									switch ($this->input->post('action'))
									{
										case 'cancel':
											if ( !! strlen($this->input->post('mid')) && !! strlen($this->input->post('reason')))
											{
												$return = $this->Memberships->cancel(
													$this->input->post('mid'),
													$this->input->post('reason')
												);
												$data['done'][] = 'You cancelled membership.';
											}
											else
											{
												$data['error'] = 'No data received as expected.';
											}
											break;
										case 'add':
											if ( !! strlen($this->input->post('type')) && !! strlen($this->input->post('since')) && !! strlen($this->input->post('expiration')))
											{
												if ( !! strlen($this->input->post('mid')))
												{
													$return = $this->Copartnerships->cancel($this->input->post('mid'), 'Renewal');
													if ( !! $return)
													{
														if ((date('G') >= 5 && strtotime($this->input->post('expiration')) >= strtotime('+1 year', strtotime('yesterday'))) || (date('G') < 5 && strtotime($this->input->post('expiration')) >= strtotime('+1 year', strtotime('-1 day', strtotime('yesterday')))))
														{
															$this->Memberships->add(
																$this->input->post('type'),
																$this->input->post('pid'),
																$this->input->post('since'),
																$this->input->post('expiration')
															);
															$data['done'][] = 'You cancelled &amp; added membership.';
														}
														else
														{
															$data['error'] = 'Out of range.';
														}
													}
													else
													{
														$data['error'] = 'You cannot cancel membership.';
													}
												}
												elseif ((date('G') >= 5 && strtotime($this->input->post('since')) >= strtotime('-1 month', strtotime('today')) && strtotime($this->input->post('expiration')) >= strtotime('+1 year', strtotime('yesterday'))) || (date('G') < 5 && strtotime($this->input->post('since')) >= strtotime('-1 year', strtotime('yesterday')) && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))))
												{
													$this->Memberships->add(
														$this->input->post('type'),
														$this->input->post('pid'),
														$this->input->post('since'),
														$this->input->post('expiration')
													);
													$data['done'][] = 'You added membership.';
												}
												else
												{
													$data['error'] = 'Out of range.';
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
								case 'copartnerships':
									switch ($this->input->post('action'))
									{
										case 'edit/cancel':
											if ( !! strlen($this->input->post('cid')))
											{
												if ( ! strlen($this->input->post('reason')))
												{
													if ( !! strlen($this->input->post('expiration')))
													{
														if ((date('G') >= 5 && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('yesterday'))) || (date('G') < 5 && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))))
														{
															$return = $this->Copartnerships->edit(
																$this->input->post('cid'),
																$this->input->post('expiration'),
																$this->input->post('bio'),
																$this->input->post('url')
															);
															if ( !! $return)
															{
																$data['done'][] = 'You edited copartnership.';
															}
															else
															{
																$data['error'] = 'You cannot edit/ cancel copartnership.';
															}
														}
														else
														{
															$data['error'] = 'Out of range.';
														}
													}
													else
													{
														$data['error'] = 'No data received as expected.';
													}
												}
												else
												{
													$return = $this->Copartnerships->cancel(
														$this->input->post('cid'),
														$this->input->post('reason')
													);
													$data['done'][] = 'You cancelled copartnership.';
												}
											}
											else
											{
												$data['error'] = 'No data received as expected.';
											}
											break;
										case 'add':
											if ( !! strlen($this->input->post('since')) && !! strlen($this->input->post('expiration')))
											{
												if ((date('G') >= 5 && strtotime($this->input->post('since')) >= strtotime('-1 month', strtotime('today')) && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('yesterday'))) || (date('G') < 5 && strtotime($this->input->post('since')) >= strtotime('-1 month', strtotime('yesterday')) && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))))
												{
													if ( !! strlen($this->input->post('cid')))
													{
														$return = $this->Copartnerships->cancel($this->input->post('cid'), 'Renewal');
														if ( !! $return)
														{
															$this->Copartnerships->add(
																$this->input->post('pid'),
																$this->input->post('since'),
																$this->input->post('expiration'),
																$this->input->post('bio'),
																$this->input->post('url')
															);
															$data['done'][] = 'You cancelled &amp; added copartnership.';
														}
														else
														{
															$data['error'] = 'You cannot edit/ cancel copartnership.';
														}
													}
													else
													{
														$this->Copartnerships->add(
															$this->input->post('pid'),
															$this->input->post('since'),
															$this->input->post('expiration'),
															$this->input->post('bio'),
															$this->input->post('url')
														);
														$data['done'][] = 'You added copartnership.';
													}
												}
												else
												{
													$data['error'] = 'Out of range.';
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
								case 'jobs':
									switch ($this->input->post('action'))
									{
										case 'edit/cancel':
											if ( ! is_null($this->input->post('jid')) && count($this->input->post('jid')) > 0)
											{
												foreach ($this->input->post('jid') as $object)
												{
													if ( ! strlen($this->input->post('reason')[$object]))
													{
														if ( !! strlen($this->input->post('expiration')[$object]))
														{
															if ((date('G') >= 5 && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('yesterday'))) || (date('G') < 5 && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))))
															{
																$return = $this->Jobs->edit(
																	$object,
																	$this->input->post('expiration')[$object],
																	$this->input->post('title')[$object],
																	$this->input->post('bio')[$object]
																);
																if ( !! $return)
																{
																	$data['done'][] = 'You edited this job.';
																}
																else
																{
																	$data['error'] = 'You cannot edit/ cancel this job/ no changes.';
																}
															}
															else
															{
																$data['error'] = 'Out of range.';
															}
														}
														else
														{
															$data['error'] = 'No data received as expected.';
														}
													}
													else
													{
														$return = $this->Jobs->cancel(
															$object,
															$this->input->post('reason')[$object]
														);
														if ( !! $return)
														{
															$data['done'][] = 'You cancelled this job.';
														}
														else
														{
															$data['error'] = 'You cannot edit/ cancel this job/ no changes.';
														}
													}
												}
											}
											else
											{
												$data['error'] = 'No data received as expected.';
											}
											break;
										case 'add':
											if ( !! strlen($this->input->post('category')) && !! strlen($this->input->post('expiration')))
											{
												if ((date('G') >= 5 && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('yesterday'))) || (date('G') < 5 && strtotime($this->input->post('expiration')) >= strtotime('+1 month', strtotime('-1 day', strtotime('yesterday')))))
												{
													$this->Jobs->add(
														$this->input->post('category'),
														$this->input->post('pid'),
														$this->input->post('expiration'),
														$this->input->post('title'),
														$this->input->post('bio')
													);
													$data['done'][] = 'You added this job.';
												}
												else
												{
													$data['error'] = 'Out of range.';
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
							$data['error'] = 'No such person.';
						}
					}
					else
					{
						$data['error'] = 'No data received as expected.';
					}
					// Get updated info
					if (isset($data['persons']) && ! is_null($data['persons']))
					{
						if ( ! isset($data['persons']->pid))
						{
							foreach ($data['persons'] as $object)
							{
								$fid[] = $object->fid;
							}
						}
						else
						{
							if ( ! is_null($data['persons']->fid))
							{
								$fid[] = $data['persons']->fid;
							}
							$data['memberships'] = $this->Memberships->history(NULL, $data['persons']->pid);
							$data['copartnerships'] = $this->Copartnerships->history($data['persons']->pid);
							$data['jobs'] = $this->Jobs->history(NULL, $data['persons']->pid);
							//$data['arrivals']['E/D'] = $this->Arrivals->filter(NULL, NULL, 'E/D', $data['persons']->pid);
							//$data['arrivals']['FLOOR'] = $this->Arrivals->filter(NULL, NULL, 'FLOOR', $data['persons']->pid);
						}
					}
				}
				elseif (count($this->input->post()) > 0)
				{
					$data['error'] = 'No data received as expected.';
				}
				if (isset($data))
				{
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
					$this->load->view('internal/relationships', $data);
				}
				else
				{
					$this->load->view('internal/header');
					$this->load->view('internal/relationships');
				}
				$this->load->view('internal/footer');
				break;
			default:
				show_404();
		}
	}
}


/* End of file Relationships.php */
/* Location: ./application/controllers/internal/Relationships.php */