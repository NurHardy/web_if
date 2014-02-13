<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Links extends CI_Controller {
	public function index() {
		if ($this->load->check_session()) {
			$this->load->model ('web_link');
			$data['page_title'] = 'Daftar Tautan';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['_links']		= $this->web_link->get_links();
			$this->load->template_admin('admin/link_list', $data);
		}
	}
	
	public function newlink() {
		if ($this->load->check_session()) {
			$data['page_title'] = $data['content_title'] = 'Tulis Posting Baru';
			$data['form_action']= '/admin/links/newlink';
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
			$this->load->template_admin('admin/link_form', $data);
		}
	}
	public function editlink($id_link = -1) {
		if (!is_numeric($id_link)) $this->output->set_header('Location: /admin/links');
		else {
			$data['page_title']		= $data['content_title'] = 'Edit Tautan';
			$data['form_action']	= '/admin/links/editlink/'.$id_link;
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
					$this->output->set_header('Location: /admin/links');
					return;
				}	
				$data['f_lnk_name']	= $_dump[0]->f_name;
				$data['f_lnk_url']	= htmlentities($_dump[0]->f_url);
			}
			$this->load->template_admin('admin/link_form', $data);
		}
	}
}