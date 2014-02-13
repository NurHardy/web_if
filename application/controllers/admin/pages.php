<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Pages extends CI_Controller {
	public function index() {
		if ($this->load->check_session()) {
			$this->load->model ('web_page');
			$this->load->model ('web_functions');
			
			$data['page_title'] = 'Daftar Halaman';
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$_ipp = $this->input->get('n'); // item per page
			$_cur = $this->input->get('p'); // current page (zero-based)
			$_maxpage = $this->input->get('x');

			$this->web_functions->check_pagination($_ipp, $_cur, $_maxpage);
			if ($_maxpage === false) {
				$_n = $this->web_page->count_pages();
				$_maxpage = ($_n==0?0:ceil($_n/$_ipp)-1);
			}
			
			//$data['_drafts']	= $this->web_draft->get_drafts();
			$data['_pages']		= $this->web_page->get_pages($_ipp, $_cur+1);
			$data['_paging']	= $this->web_functions->pagination(
				$_maxpage,
				$_cur,
				2,
				'/admin/pages',
				'n='.$_ipp
			);
			$data['_ctr'] = $_cur*$_ipp;
			$data['_ipp'] = $_ipp;
			
			$this->load->template_admin('admin/page_list', $data);
		}
	}
	public function editpage($id_page = -1) {
		if ($this->load->check_session()) {
			if (!is_numeric($id_page)) $this->output->set_header('Location: /admin/pages');
			$data['page_title']		= $data['content_title'] = 'Edit Halaman';
			$data['form_action']	= '/admin/pages/editpage/'.$id_page;
			$data['username_']		= $this->nativesession->get('user_name_');
			$data['f_title']		= htmlentities($this->input->post('f_title'));
			$data['f_content']		= $this->input->post('f_content');
			$data['f_permalink']	= $this->input->post('f_permalink');
			
			$this->load->model ('web_page');
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'PAGE_POST_FORM') {
				if ((!$this->input->post('f_title')) || (!$this->input->post('f_content')) || (!$this->input->post('f_permalink'))) {
					$data['errors'] = array('Mohon isi judul, permalink dan konten halaman...');
				} else {
					$_result = $this->web_page->save_page(
						$this->input->post('f_title'),
						$this->input->post('f_permalink'),
						$this->input->post('f_content'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						true, // published?
						$id_page
					);
					if ($_result) {
						$data['infos']	 = array('Halaman berhasil diperbaharui...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$_dump = $this->web_page->get_page($id_page);
				if (empty($_dump)) {
					$this->output->set_header('Location: /admin/pages');
					return;
				}	
				$data['f_title']	= $_dump[0]->f_title;
				$data['f_content']	= $_dump[0]->f_content;
				$data['f_permalink']= $_dump[0]->f_permalink;
			}
			$this->load->template_admin('admin/page_form', $data);
		}
	}
	
	public function newpage() {
		if ($this->load->check_session()) {
			$data['page_title'] = $data['content_title'] = 'Tulis Halaman Baru';
			$data['form_action']= '/admin/pages/newpage';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['f_title']	= htmlentities($this->input->post('f_title'));
			$data['f_content']	= $this->input->post('f_content');
			$data['f_permalink']= $this->input->post('f_permalink');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'PAGE_POST_FORM') {
				if ((!$this->input->post('f_title')) || (!$this->input->post('f_content')) || (!$this->input->post('f_permalink'))) {
					$data['errors'] = array('Mohon isi judul, permalink dan konten halaman...');
				} else {
					$this->load->model ('web_page');
					$_result = $this->web_page->save_page(
						$this->input->post('f_title'),
						$this->input->post('f_permalink'),
						$this->input->post('f_content'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_')
					);
					if ($_result) {
						$data['infos']	 = array('Halaman berhasil dipublikasikan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			}
			$this->load->template_admin('admin/page_form', $data);
		}
	}
}