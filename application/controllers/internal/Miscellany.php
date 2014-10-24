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

class Miscellany extends CI_Controller
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
				$this->load->model('Files');
				$this->load->model('Genres');
				$this->load->model('Notices');
				$this->load->model('Reminders');
				if ( !! strlen($this->input->post('section')))
				{
					switch ($this->input->post('section'))
					{
						case 'reminders':
							switch ($this->input->post('action'))
							{
								case 'edit':
									if ( !! strlen($this->input->post('rid')) && !! strlen($this->input->post('url')) && !! strlen($this->input->post('expiration')))
									{
										if ((date('G') >= 5 && strtotime($this->input->post('expiration')) >= strtotime('tomorrow')) || (date('G') < 5 && strtotime($this->input->post('expiration')) >= strtotime('today')))
										{
											$this->load->library('upload', array('upload_path' => sys_get_temp_dir(), 'allowed_types' => 'jpg'));
											if ( !! $this->upload->do_upload('poster'))
											{
												if (is_null($this->Files->search(file_get_contents($this->upload->data()['full_path']))))
												{
													$return = $this->Reminders->edit(
														$this->input->post('rid'),
														$this->input->post('url'),
														$this->input->post('expiration'),
														$this->Files->write(file_get_contents($this->upload->data()['full_path']))
													);
												}
												else
												{
													$return = $this->Reminders->edit(
														$this->input->post('rid'),
														$this->input->post('url'),
														$this->input->post('expiration'),
														$this->Files->search(file_get_contents($this->upload->data()['full_path']))->fid
													);
												}
											}
											else
											{
												$return = $this->Reminders->edit(
													$this->input->post('rid'),
													$this->input->post('url'),
													$this->input->post('expiration')
												);
											}
											if ( !! $return)
											{
												$data['done'][] = 'You edited this reminder.';
											}
											else
											{
												$data['error'] = 'You cannot edit/ remove this reminder.';
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
								case 'remove':
									if ( !! strlen($this->input->post('rid')))
									{
										$return = $this->Reminders->remove($this->input->post('rid'));
										if ( !! $return)
										{
											$data['done'][] = 'You removed this reminder.';
										}
										else
										{
											$data['error'] = 'You cannot edit/ remove this reminder.';
										}
									}
									else
									{
										$data['error'] = 'No data received as expected.';
									}
									break;
								case 'add':
									if ( !! strlen($this->input->post('url')) && !! strlen($this->input->post('expiration')))
									{
										if ((date('G') >= 5 && strtotime($this->input->post('expiration')) >= strtotime('tomorrow')) || (date('G') < 5 && strtotime($this->input->post('expiration')) >= strtotime('today')))
										{
											$this->load->library('upload', array('upload_path' => sys_get_temp_dir(), 'allowed_types' => 'jpg'));
											if ( !! $this->upload->do_upload('poster'))
											{
												if (is_null($this->Files->search(file_get_contents($this->upload->data()['full_path']))))
												{
													$this->Reminders->add(
														$this->input->post('url'),
														$this->input->post('expiration'),
														$this->Files->write(file_get_contents($this->upload->data()['full_path']))
													);
												}
												else
												{
													$this->Reminders->add(
														$this->input->post('url'),
														$this->input->post('expiration'),
														$this->Files->search(file_get_contents($this->upload->data()['full_path']))->fid
													);
												}
												$data['done'][] = 'You added a reminder.';
											}
											else
											{
												$data['error'] = $this->upload->display_errors('', '');
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
						case 'genres':
							switch ($this->input->post('action'))
							{
								case 'edit/remove':
									if ( ! is_null($this->input->post('gid')) && count($this->input->post('gid')) > 0)
									{
										foreach ($this->input->post('gid') as $object)
										{
											if ( !! strlen($this->input->post('name')[$object]))
											{
												$return = $this->Genres->edit(
													$object,
													$this->input->post('name')[$object]
												);
												if ( !! $return)
												{
													$data['done'][] = 'You edited this genre.';
												}
												else
												{
													$data['error'] = 'You cannot edit/ remove this genre/ no changes.';
												}
											}
											else
											{
												$this->Genres->remove($object);
												$data['done'][] = 'You cancelled this genre.';
											}
										}
									}
									else
									{
										$data['error'] = 'No data received as expected.';
									}
									break;
								case 'add':
									if ( !! strlen($this->input->post('name')))
									{
										$this->Genres->add($this->input->post('name'));
										$data['done'][] = 'You added a genre.';
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
						case 'notices':
							switch ($this->input->post('action'))
							{
								case 'edit':
									if ( !! strlen($this->input->post('nid')) && !! strlen($this->input->post('title')) && !! strlen($this->input->post('message')))
									{
										$return = $this->Notices->edit(
											$this->input->post('nid'),
											$this->input->post('title'),
											$this->input->post('message')
										);
										if ( !! $return)
										{
											$data['done'][] = 'You edited this notice.';
										}
										else
										{
											$data['error'] = 'You cannot edit/ remove this notice.';
										}
									}
									else
									{
										$data['error'] = 'No data received as expected.';
									}
									break;
								case 'remove':
									if ( !! strlen($this->input->post('nid')))
									{
										$return = $this->Notices->remove($this->input->post('nid'));
										if ( !! $return)
										{
											$data['done'][] = 'You removed this notice.';
										}
										else
										{
											$data['error'] = 'You cannot edit/ remove this notice.';
										}
									}
									else
									{
										$data['error'] = 'No data received as expected.';
									}
									break;
								case 'add':
									if ( !! strlen($this->input->post('title')) && !! strlen($this->input->post('message')))
									{
										$this->Notices->add(
											$this->input->post('title'),
											$this->input->post('message')
										);
										$data['done'][] = 'You added a notice.';
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
				// Get notice data
				$data['notices'] = $this->Notices->available();
				// Get reminder data
				$data['reminders'] = $this->Reminders->available();
				// If set, get reminder photo
				if ( ! is_null($data['reminders']))
				{
					foreach ($data['reminders'] as $object)
					{
						if ( ! isset($data['files'][$object->fid]))
						{
							$data['files'][$object->fid] = $this->Files->read($object->fid);
						}
					}
				}
				// Get genre data
				$data['genres'] = $this->Genres->available();
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
				$this->load->view('internal/miscellany', $data);
				$this->load->view('internal/footer');
				break;
			default:
				show_404();
		}
	}
}


/* End of file Miscellany.php */
/* Location: ./application/controllers/internal/Miscellany.php */