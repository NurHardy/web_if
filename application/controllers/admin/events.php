<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Events extends CI_Controller {

	public function index() {
		if ($this->load->check_session()) {
			$data['page_title'] = 'Event Organizer';
			$data['username_']	= $this->nativesession->get('user_name_');
			$this->load->template_admin('admin/event_calendar', $data, false, "&raquo; agenda");
		}
	}
	public function eventajax() {
		if ($this->load->check_session(true)) {
			$this->load->model ('web_event');
			$_m = $this->input->post('m');
			$_y = $this->input->post('y');
			$_json_ = $this->web_event->get_event_json($_m, $_y);
			$this->output->append_output($_json_);
		}
	}
	public function newevent() {
		if ($this->load->check_session()) {
			$data['page_title'] = $data['content_title'] = 'Create New Event';
			$data['username_']	= $this->nativesession->get('user_name_');
			$data['f_d'] = htmlentities($this->input->get('d'));
			$data['f_m'] = htmlentities($this->input->get('m'));
			$data['f_y'] = htmlentities($this->input->get('y'));
			$data['f_ev_name'] = $this->input->post('f_ev_name');
			$data['f_ev_desc'] = $this->input->post('f_ev_desc');
			
			$data['form_action']= base_url('/admin/events/newevent/'.($this->input->get('m')?"?m=".$this->input->get('m'):""));
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'EVENT_POST_FORM') {
				$data['f_date_str'] = $this->input->post('f_ev_date');
				if ((!$this->input->post('f_ev_name')) || (!$this->input->post('f_ev_date'))) {
					$data['errors'] = array('Mohon isi nama dan tanggal event...');
				} else {
					if ($this->input->post('f_ev_desc')) $_f_ev_desc = $this->input->post('f_ev_desc');
					else $_f_ev_desc = null;
					$f_ev_date_ = date_create($this->input->post('f_ev_date'));
					if (!$f_ev_date_) {
						$e = date_get_last_errors();
						foreach ($e['errors'] as $error) {
							$data['errors'][] = "Kesalahan format tanggal: ".$error;
						}
						goto selesai;
					} else $f_ev_date__ = date_format($f_ev_date_, "Y-m-d");
					$f_date_str = $f_ev_date__;
					
					//function save_event($_ev_date, $_name, $_id_creator, $_creator, $_desc = null, $_publish = true, $_id = -1)
					$this->load->model ('web_event');
					$_result = $this->web_event->save_event(
						$f_date_str,
						$this->input->post('f_ev_name'),
						$this->nativesession->get('user_id_'),
						$this->nativesession->get('user_name_'),
						$_f_ev_desc
					);
					if ($_result) {
						$data['infos']	 = array('Event berhasil dipublikasikan...');
						$data['no_form'] = true;
					}
					else $data['errors'] = array('Terjadi kesalahan. Silakan periksa konten dan ulangi lagi.');
				}
			} else {
				$data['f_date_str'] = $data['f_y']."/".$data['f_m']."/".$data['f_d'];
			}
selesai:
			$this->load->template_admin('admin/event_form', $data, false, "&raquo; <a href='".base_url("/admin/events")."'>Agenda</a> &raquo; agenda baru");
		}
	}
}