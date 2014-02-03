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
    public function template($template_name, $vars = array(), $return = FALSE)
    {
        $content  = $this->view('skin/header', $vars, $return);
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
	
	public function template_posting($template_name, $vars = array(), $return = FALSE)
    {
        $content  = $this->view('skin/header_sec', $vars, $return);
		$content .= $this->append_output("<div id='site_content'>\n<div id='site_content_left'>");
		$content .= $this->view($template_name, $vars, $return);
		$content .= $this->append_output("</div>\n<div id='site_content_right'>");
		$content .= $this->view('skin/sidebar_sec', $vars, $return);
		$content .= $this->append_output("</div>");
        $content .= $this->view('skin/footer', $vars, $return);
		
        if ($return) {
            return $content;
        }
    }
	
	public function template_admin($template_name, $vars = array(), $return = FALSE)
    {
        $content  = $this->view('admin/admin_header', $vars, $return);
		$content .= $this->append_output("<div id='admin_content_left'>");
		$content .= $this->view($template_name, $vars, $return);
		$content .= $this->append_output("</div>\n<div id='admin_content_right'>");
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
	
}