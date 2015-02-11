<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slider extends CI_Controller {
	private $_cpmask = 64;
	
	public function index() { /*melihat slider keseluruhan*/
		if ($this->load->check_session($this->_cpmask)) {
			$this->load->model ('web_slider');
			$data['page_title'] = 'Daftar Slider';
			$data['_sliders']	= $this->web_slider->get_slides(-1);
			$this->load->template_admin('admin/slider_list', $data);
		}
	}
	public function setprop() {
		if (!$this->load->check_session($this->_cpmask, true)) {
			$this->load->showForbidden();
			return;
		}
		$_actn = $this->input->post('prop');
		$_slideid = $this->input->post('id');
		if ($_slideid <= 0) {$this->output->append_output("Valid slide ID expected."); return; }
		if ($_actn === 'caption') {
			$_newcap  = $this->input->post('newcaption');
			$_sdata = array(
				'desc' => htmlentities($_newcap)
			);
		} else if ($_actn === 'published') {
			$_newstat  = $this->input->post('status');
			$_sdata = array(
				'status' => ($_newstat==1?1:0)
			);
		} else if ($_actn === 'order') {
			$_newpos  = $this->input->post('order');
			$_sdata = array(
				'order' => intval($_newpos)
			);
		} else if ($_actn === 'delete') {
			$this->load->model ('web_slider');
			$_uresult = $this->web_slider->delete_slide($_slideid);
			if ($_uresult) $this->output->append_output("OK");
			else $this->output->append_output("No row change!");
			return;
		} else {
			$this->output->append_output("Unknown action: ".htmlentities($_actn));
			return;
		}
		$this->load->model ('web_slider');
		$_uresult = $this->web_slider->update_slide($_slideid,$_sdata);
		if ($_uresult) $this->output->append_output("OK");
		else $this->output->append_output("No row change!");
	}
	
	public function newslider(){
		if ($this->load->check_session($this->_cpmask)) {
            $this->load->model('model_website'); 
			
			$isi_url			=$this->input->post('url_gambar');
			$isi_narasi			=$this->input->post('narasi');
			$isi_efek_narasi	=$this->input->post('efek_narasi');
			$isi_status_slider	=$this->input->post('status_slider');
				if ((!$isi_url=='' &&	!$isi_narasi=='' && 	!$isi_efek_narasi=='' &&	!$isi_status_slider=='')){
						$this->model_website->save_slider(	
							$isi_url,
							$isi_narasi,
							$isi_efek_narasi,
							$isi_status_slider	
						);
						$data['success'] = array('Tambah Slider Berhasil');
						$data['form']=array('yes');
					}
				else {
					$data['errors'] = array('Gagal, silahkan isi semua form');
				}
			$this->load->template_admin('admin/slider_form',$data);
		}
	}
	public function editslider(){
		if ($this->load->check_session($this->_cpmask)) {
            $this->load->model('model_website'); 
			$data['page_title'] = 'Edit Tampil';
			$data['_sliders']	= $this->model_website->get_slider_id($id);
			$this->load->template_admin('admin/slider_list', $data);
		}
	}
	public function upload() {
		if ($this->load->check_session($this->_cpmask, true)) {
			$this->load->model ('web_media');
			$data['username_']	= $this->nativesession->get('user_name_');
			
			$_submitter = $this->input->post('form_submit');
			if ($_submitter == 'MEDIA_POST_FORM') {
				// proses UPLOAD =============================================
				$tanggal = date("Y-m-d H:i:s");

				$file_type_id = -1;
				$validexts_image = array("png","jpeg","jpg","gif");
				
				$maxsize = 5 * 1024 * 1024; //1048576; // = 1 Mb // Silakan diubah sesuai kebutuhan

				if (!isset($_FILES['f_file_'])) {
					$this->output->append_output('Nothing Uploaded!');
					return;
				}
				$uploader_ = $_SERVER['REMOTE_ADDR'];
				$id_g = date('dmY');
				
				if (!empty($_FILES['f_file_']['name'])) {
					$filesize = $_FILES['f_file_']['size'];
					$ekstensi = strtolower(end(explode(".", $_FILES['f_file_']['name'])));
					if 		(in_array($ekstensi, $validexts_image))	$file_type_id = 1;
					
					if (($file_type_id != -1) && ($filesize <= $maxsize)) {
						// memastikan tidak ada nama file yang sama
						$uploadedfile = sprintf("/assets/media/m%s_%s",$id_g,$_FILES['f_file_']['name']);
						$file_c = 1;
						while (file_exists(FCPATH.$uploadedfile)) {
							$uploadedfile = sprintf("/assets/media/m%s_%d_%s",$id_g,$file_c,$_FILES['f_file_']['name']);
							$file_c++;
						}
						//$thumbimg    = sprintf("assets/thumbs/th_asset%d.cox",$id_g);
						if (move_uploaded_file($_FILES['f_file_']['tmp_name'], FCPATH.$uploadedfile)) 
						{
							//list($width_, $height_) = getimagesize($uploadedfile);
							//make_thumb($uploadedfile,$thumbimg,$ekstensi);
							$_result = $this->web_media->save_media(
								array(
									$_FILES['f_file_']['name'],
									$uploadedfile,
									$ekstensi,
									$file_type_id,
									$filesize),
								$uploader_,
								$this->nativesession->get('user_id_'),
								$this->nativesession->get('user_name_')
							);
							
							if ($_result) {
								$this->load->model ('web_slider');
								$_result = $this->web_slider->insert_newslide(
									$uploadedfile,
									$this->nativesession->get('user_id_'),
									$this->nativesession->get('user_name_')
								);
								if ($_result) $this->output->append_output("OK");
								else $this->output->append_output("Query insert error...");
								return;
							} else {
								$this->output->append_output("[Query failed] Error mengupload ".$_FILES['f_file_']['name'].". Silakan coba lagi.");
								return;
							}
						} else {
							$this->output->append_output("[Move error] Error mengupload ".$_FILES['f_file_']['name'].". Silakan coba lagi.");
							return;
						}
					} else { // jika tidak valid / terlalu besar
						$this->output->append_output("Error mengupload ".$_FILES['f_file_']['name'].". Ukuran dan jenis file harus sesuai.");
						return;
					}
				} // end is empty f_file_
			}
			selesai:
			$this->output->append_output('Invalid operation.');
		} else {
			$this->load->showForbidden();
		}
	}
}