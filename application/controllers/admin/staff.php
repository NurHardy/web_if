<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Staff extends CI_Controller {
	private $_cpmask = 128;
	
	public function index() {
		if ($this->load->check_session($this->_cpmask)) {
			$this->load->model ('web_staff');
			$data['page_title'] = 'Daftar Staff';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['list_staff']		= $this->web_staff->get_staff();
			$this->load->template_admin('admin/staff_list', $data, false, "&raquo; staff");
		}
	}
	
	public function newstaff() {
		if ($this->load->check_session($this->_cpmask)) {
			$data['page_title'] = $data['content_title'] = 'Tambah Staff Baru';
			$data['form_action']= base_url('/admin/staff/newstaff');
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['nama']	= $this->input->post('nama');
			$data['nip']	= $this->input->post('nip');
			$data['alamat']	= $this->input->post('alamat');
			$data['ttl']	= $this->input->post('ttl');
			$data['pddk']	= $this->input->post('pddk');
			$data['email']	= $this->input->post('email');
			$data['web']	= $this->input->post('web');
			$data['bidilmu']	= $this->input->post('bidilmu');
			$data['lab']	= $this->input->post('lab');
			$data['matkul']	= $this->input->post('matkul');
			$data['hp']	= $this->input->post('hp');
			$data['nidn']	= $this->input->post('nidn');
			$data['foto']	= $this->input->post('foto');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'LINK_POST_FORM') {
				if ((!$this->input->post('nama')) || (!$this->input->post('nip'))) {
					$data['errors'] = array('Mohon isi dengan lengkap');
				} else {
					$this->load->model ('web_staff');
					$_result = $this->web_staff->save_staff(
						$this->input->post('nama'),
						$this->input->post('nip'),
						$this->input->post('alamat'),
						$this->input->post('ttl'),
						$this->input->post('pddk'),
						$this->input->post('email'),
						$this->input->post('web'),
						$this->input->post('bidilmu'),
						$this->input->post('lab'),
						$this->input->post('matkul'),
						$this->input->post('hp'),
						$this->input->post('nidn'),
						$this->input->post('foto'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('staff berhasil ditambahkan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			$this->load->template_admin('admin/staff_form', $data, false, "&raquo; <a href='".base_url("/admin/staff")."'>staff</a> &raquo; staff baru");
		}
	}
	
	public function editstaff($nip) {
		if (!$this->load->check_session($this->_cpmask)) return;
		if (!is_numeric($nip)) $this->output->set_header('Location: '.base_url("/admin/staff"));
		else {
			$data['page_title']		= $data['content_title'] = 'Edit Tautan';
			$data['form_action']	= base_url('/admin/staff/editstaff/'.$nip);
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['nama']			= htmlentities($this->input->post('nama'));
			$data['nip']			= $this->input->post('nip');
			$data['alamat']			= $this->input->post('alamat');
			$data['ttl']			= $this->input->post('ttl');
			$data['pddk']			= $this->input->post('pddk');
			$data['email']			= $this->input->post('email');
			$data['web']			= $this->input->post('web');
			$data['bidilmu']		= $this->input->post('bidilmu');
			$data['lab']			= $this->input->post('lab');
			$data['matkul']			= $this->input->post('matkul');
			$data['hp']				= $this->input->post('hp');
			$data['nidn']			= $this->input->post('nidn');
			$data['foto']			= $this->input->post('foto');
			
			$this->load->model ('web_staff');
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'LINK_POST_FORM') {
				if ((!$this->input->post('nama')) || (!$this->input->post('nip'))) {
					$data['errors'] = array('Mohon isi dengan lengkap');
				} else {
						$_result = $this->web_staff->update_staff(
						$this->input->post('nama'),
						$this->input->post('nip'),
						$this->input->post('alamat'),
						$this->input->post('ttl'),
						$this->input->post('pddk'),
						$this->input->post('email'),
						$this->input->post('web'),
						$this->input->post('bidilmu'),
						$this->input->post('lab'),
						$this->input->post('matkul'),
						$this->input->post('hp'),
						$this->input->post('nidn'),
						$this->input->post('foto'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('Staff berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->web_staff->get_staff_id($nip);
				if (empty($_dump)) {
					$this->output->set_header('Location: '.base_url("/admin/staff"));
					return;
				}	
				$data['nama']	= $_dump->nama;
				$data['nip']	= $_dump->nip;
				$data['alamat']	= $_dump->alamat;
				$data['ttl']	=  htmlentities($_dump->ttl);
				$data['pddk']	= $_dump->pddk;
				$data['email']	= $_dump->email;
				$data['web']	= $_dump->website;
				$data['bidilmu']= $_dump->bidangilmu;
				$data['lab']	= $_dump->lab;
				$data['matkul']	= $_dump->matkul;
				$data['hp']	    = $_dump->hp;
				$data['nidn']	= $_dump->nidn;
				$data['foto']	= $_dump->link_foto;
			}
			$this->load->template_admin('admin/staff_form', $data, false, "&raquo; <a href='".base_url("/admin/staff")."'>staff</a> &raquo; edit staff");
		}
	}
}