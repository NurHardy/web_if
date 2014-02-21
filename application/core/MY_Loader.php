<?php
/**
 *	system/core/MY_Loader.php
 *
 */

class MY_Loader extends CI_Loader {
	public function append_output($text, $return = FALSE) {
		$this->output->append_output($text);
		if ($return) return $text;
	}
    public function template_home($template_name, $vars = array(), $return = FALSE )
    {
		$_vars = $vars;
		$_vars['is_home'] = true;
        $content  = $this->view('skin/header', $_vars, $return);
		$content .= $this->append_output("<div id='site_content'>\n<div id='site_content_left'>");
		$content .= $this->view($template_name, $vars, $return);
		$content .= $this->append_output("</div>\n<div id='site_content_right'>");
		$content .= $this->view('skin/sidebar', $vars, $return);
		$content .= $this->append_output("</div>");
        $content .= $this->view('skin/footer', $vars, $return);
		
        if ($return) {
            return $content;
        }
    }
	
	public function template_posting($template_name, $vars = array(), $return = FALSE, $_preview = false, $_nav = '')
    {
		$_vars = $vars;
		if ($_preview) $_vars['is_preview'] = true;
        $content  = $this->view('skin/header', $_vars, $return);
		$content .= $this->append_output("<div id='site_content'>\n<div id='site_content_left'>");
		$content .= $this->append_output("<div id='content_nav'><a href='".base_url("/")."'>Home</a> {$_nav}</div>");
		$content .= $this->view($template_name, $_vars, $return);
		$content .= $this->append_output("</div>\n<div id='site_content_right'>");
		$content .= $this->view('skin/sidebar_sec', $vars, $return);
		$content .= $this->append_output("</div>");
        $content .= $this->view('skin/footer', $vars, $return);
		
        if ($return) {
            return $content;
        }
    }
	
	public function template_admin($template_name, $vars = array(), $return = FALSE, $_nav = '')
    {
        $content  = $this->view('admin/admin_header', $vars, $return);
		$content .= $this->append_output("<div id='admin_content_left'>\n");
		$content .= $this->append_output("<div id='admin_content_nav'><a href='".base_url("/admin/")."'>Dasbor</a> {$_nav}</div>");
		$content .= $this->view($template_name, $vars, $return);
		$content .= $this->append_output("</div>\n<div id='admin_content_right'>\n");
		$content .= $this->view('admin/admin_sidebar', $vars, $return);
		$content .= $this->append_output("</div>");
        $content .= $this->view('admin/admin_footer', $vars, $return);
		
        if ($return) {
            return $content;
        }
    }
	
	public function template_admin_simple($template_name, $vars = array(), $return = FALSE)
    {
		$_vars = $vars;
		$_vars['no_bodyhead'] = true;
        $content  = $this->view('admin/admin_header', $_vars, $return);
		$content .= $this->view($template_name, $vars, $return);
		// tidak ada footer. Ditutup secara manual
		$content .= $this->append_output("\n</div>\n</body>\n</html>");
		
        if ($return) {
            return $content;
        }
    }
	public function template_profil($template_name, $vars = array(), $return = FALSE, $_nav = '')
    {
        $content  = $this->view('skin/header', $vars, $return);
		$content .= $this->append_output("<div id='site_content'>\n<div id='site_content_left'>");
		$content .= $this->append_output("<div id='content_nav'><a href='".base_url('/')."'>Home</a> {$_nav}</div>");
		$content .= $this->view($template_name, $vars, $return);
		$content .= $this->append_output("</div>\n<div id='site_content_right'>");
		$content .= $this->view('skin/sidebar_profil', $vars, $return);
		$content .= $this->append_output("</div>");
        $content .= $this->view('skin/footer', $vars, $return);
		
        if ($return) {
            return $content;
        }
    }
	public function template_akademik($template_name, $vars = array(), $return = FALSE, $_nav = '')
    {
        $content  = $this->view('skin/header', $vars, $return);
		$content .= $this->append_output("<div id='site_content'>\n<div id='site_content_left'>");
		$content .= $this->append_output("<div id='content_nav'><a href='".base_url('/')."'>Home</a> {$_nav}</div>");
		$content .= $this->view($template_name, $vars, $return);
		$content .= $this->append_output("</div>\n<div id='site_content_right'>");
		$content .= $this->view('skin/sidebar_akademik', $vars, $return);
		$content .= $this->append_output("</div>");
        $content .= $this->view('skin/footer', $vars, $return);
		
        if ($return) {
            return $content;
        }
    }
	public function check_session($_no_redir = false, $_err_msg = null) {
		$ci =& get_instance();
		
		if (!$ci->nativesession->get('user_id_')) {
			if ($_no_redir) {
				$this->append_output(($_err_msg?$_err_msg:"Sorry, you must logged in to continue..."));
			} else $ci->output->set_header('Location: '.base_url('/admin/auth/authenticate?next='.urlencode($_SERVER['REQUEST_URI'])));
			return false;
		}
		return true;
	}
	public function get_session_key() {
		return $this->nativesession->get('user_id_');
	}
}