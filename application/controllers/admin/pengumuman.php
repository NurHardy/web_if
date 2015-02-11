<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pengumuman extends CI_Controller {
	private $_cpmask = 256;
	
	public function index() {
		if ($this->load->check_session($this->_cpmask)) {
			$this->load->model ('web_pengumuman');
			$data['page_title'] = 'Daftar Pengumuman';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['list_pengumuman']	= $this->web_pengumuman->get_published_nounce();
			$data['list_pengumuman1']	= $this->web_pengumuman->get_unpublished_nounce();
			$this->load->template_admin('admin/list_pengumuman', $data, false, "&raquo; pengumuman");
		}
	}
	
	public function newpengumuman() {
		if ($this->load->check_session($this->_cpmask)) {
			$data['page_title'] = $data['content_title'] = 'Tulis Pengumuman Baru';
			$data['form_action']= base_url('/admin/pengumuman/newpengumuman');
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['judul']	= $this->input->post('judul');
			$data['isi']	= $this->input->post('isi');
			$data['tgl_akhir']	= $this->input->post('tgl_akhir');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'LINK_POST_FORM') {
				if ((!$this->input->post('judul')) || (!$this->input->post('isi')) || (!$this->input->post('tgl_akhir'))){
					$data['errors'] = array('Mohon isi dengan lengkap');
				} else {
					$this->load->model ('web_pengumuman');
					$_result = $this->web_pengumuman->save_pengumuman(
						$this->input->post('judul'),
						$this->input->post('isi'),
						$this->input->post('tgl_akhir'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('pengumuman berhasil ditambahkan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			selesai:
			$this->load->template_admin('admin/form_pengumuman', $data, false, "&raquo; <a href='".base_url("/admin/pengumuman")."'>pengumuman</a> &raquo; pengumuman baru");
		}
	}
	
	public function editpengumuman($id_p) {
		if (!$this->load->check_session($this->_cpmask)) return;
		if (!is_numeric($id_p)) $this->output->set_header('Location: '.base_url("/admin/pengumuman"));
		else {
			$data['page_title']		= $data['content_title'] = 'Edit Pengumuman';
			$data['form_action']	= base_url('/admin/pengumuman/editpengumuman/'.$id_p);
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['nama']			= htmlentities($this->input->post('nama'));
			$data['judul']			= $this->input->post('judul');
			$data['isi']			= $this->input->post('isi');
			$data['tgl_akhir']			= $this->input->post('tgl_akhir');
			
			$this->load->model ('web_pengumuman');
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'LINK_POST_FORM') {
				if ((!$this->input->post('judul')) || (!$this->input->post('isi')) || (!$this->input->post('tgl_akhir'))) {
					$data['errors'] = array('Mohon isi dengan lengkap');
				} else {
					$_result = $this->web_pengumuman->update_pengumuman(
						$this->input->post('judul'),
						$this->input->post('isi'),
						$this->input->post('tgl_akhir'),
						$id_p,
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
						
					);
					if ($_result) {
						$data['infos']	 = array('Pengumuman berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->web_pengumuman->get_pengumuman_id($id_p);
				if (empty($_dump)) {
					$this->output->set_header('Location: '.base_url("/admin/pengumuman"));
					return;
				}	
				$data['judul']	= $_dump->judul;
				$data['isi']	= $_dump->isi;
				$data['tgl_akhir']	= $_dump->tgl_berakhir;
			}
			$this->load->template_admin('admin/form_pengumuman', $data, false, "&raquo; <a href='".base_url("/admin/pengumuman")."'>pengumuman</a> &raquo; edit pengumuman");
		}
	}
}