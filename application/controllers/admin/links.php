<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Links extends CI_Controller {
	private $_cpmask = 16;
	
	public function index() {
		if ($this->load->check_session($this->_cpmask)) {
			$this->load->model ('web_link');
			$data['page_title'] = 'Daftar Tautan';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_links_pub']		= $this->web_link->get_links(-1, 1);
			$data['_links_unpub']		= $this->web_link->get_links(-1, 0);
			$this->load->template_admin('admin/link_list', $data, false, "&raquo; tautan");
		}
	}
	
	public function newlink() {
		if ($this->load->check_session($this->_cpmask)) {
			$data['page_title'] = $data['content_title'] = 'Tulis Posting Baru';
			$data['form_action']= base_url('/admin/links/newlink');
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['f_lnk_name']	= htmlentities($this->input->post('f_lnk_name'));
			$data['f_lnk_url']	= $this->input->post('f_lnk_url');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'LINK_POST_FORM') {
				if ((!$this->input->post('f_lnk_name')) || (!$this->input->post('f_lnk_url'))) {
					$data['errors'] = array('Mohon isi nama link dan alamat URL');
				} else {
					if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$data['f_lnk_url'])) {
						$data['errors'][] = "URL tidak valid. Gunakan alamat URL yang valid (Misal: http://www.undip.ac.id)";
						goto selesai;
					}
					$this->load->model ('web_link');
					$_result = $this->web_link->save_link(
						$this->input->post('f_lnk_name'),
						$this->input->post('f_lnk_url'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('Link berhasil ditambahkan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			selesai:
			$this->load->template_admin('admin/link_form', $data, false, "&raquo; <a href='".base_url("/admin/links")."'>tautan</a> &raquo; tautan baru");
		}
	}
	public function editlink($id_link = -1) {
		if (!$this->load->check_session($this->_cpmask)) return;
		if (!is_numeric($id_link)) $this->output->set_header('Location: '.base_url("/admin/links"));
		else {
			$data['page_title']		= $data['content_title'] = 'Edit Tautan';
			$data['form_action']	= base_url('/admin/links/editlink/'.$id_link);
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['f_lnk_name']	= htmlentities($this->input->post('f_lnk_name'));
			$data['f_lnk_url']	= $this->input->post('f_lnk_url');
			
			$this->load->model ('web_link');
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'LINK_POST_FORM') {
				if ((!$this->input->post('f_lnk_name')) || (!$this->input->post('f_lnk_url'))) {
					$data['errors'] = array('Mohon isi nama link dan alamat URL');
				} else {
					$_result = $this->web_link->save_link(
						$this->input->post('f_lnk_name'),
						$this->input->post('f_lnk_url'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						$id_link
					);
					if ($_result) {
						$data['infos']	 = array('Tautan berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->web_link->get_link($id_link);
				if (empty($_dump)) {
					$this->output->set_header('Location: '.base_url("/admin/links"));
					return;
				}	
				$data['f_lnk_name']	= $_dump[0]->f_name;
				$data['f_lnk_url']	= htmlentities($_dump[0]->f_url);
			}
			$this->load->template_admin('admin/link_form', $data, false, "&raquo; <a href='".base_url("/admin/links")."'>tautan</a> &raquo; edit tautan");
		}
	}
	// AJAX
	public function updatelinks_pub() {
		if (!$this->load->check_session($this->_cpmask, true)) {
			$this->load->showForbidden();
			return;
		}
		$_orderdata = $this->input->post('order_');
		$_publishdata = $this->input->post('hide_');
		if (!$_orderdata || !is_array($_orderdata)) {
			$this->output->append_output("Invalid data structure.");
		} else {
			if ($_publishdata === false) $_publishdata = array();
			$this->load->model ('web_link');
			foreach ($_orderdata as $key => $val) {
				$pub = true;
				if (isset($_publishdata[$key]))
					if ($_publishdata[$key]=='1') {
						$pub = false;
					}
				$this->web_link->update_order($key, $val, $pub);
			}
			$this->output->append_output("OK");
		}
	}
	// AJAX
	public function updatelinks_unpub() {
		if (!$this->load->check_session($this->_cpmask, true)) {
			$this->load->showForbidden();
			return;
		}
		$_orderdata = $this->input->post('order_');
		$_publishdata = $this->input->post('show_');
		if (!$_orderdata || !is_array($_orderdata)) {
			$this->output->append_output("Invalid data structure.");
		} else {
			if ($_publishdata === false) $_publishdata = array();
			$this->load->model ('web_link');
			foreach ($_orderdata as $key => $val) {
				$pub = false;
				if (isset($_publishdata[$key]))
					if ($_publishdata[$key]=='1') {
						$pub = true;
					}
				$this->web_link->update_order($key, $val, $pub);
			}
			$this->output->append_output("OK");
		}
	}
}