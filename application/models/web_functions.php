<?php
class web_functions extends CI_Model {
/* ------------------------------------------ GENERAL FUNCTIONS ------------------- */
	function pagination($_maxpage, $_page, $_range = 2, $_url = '', $_opts = '') {
		$_output = "";
		$max_p = $_maxpage;//ceil($_count/$_items)-1;
		if ($_page>0) {
			$_output .= "<a href='$_url?$_opts&amp;p=0&amp;x=$max_p'>&laquo;&laquo; First</a>";
			$_output .= "<a href='$_url?$_opts&amp;p=".($_page-1)."&amp;x=$max_p'>&laquo; Before</a>";
		} else {
			$_output .= "<span>&laquo;&laquo; First</span>";
			$_output .= "<span>&laquo; Before</span>";
		}
		$lowpage  = $_page-$_range; if ($lowpage < 0) $lowpage = 0;
		$highpage = $lowpage+(2*$_range); if ($highpage > $max_p) $highpage = $max_p;

		if ($lowpage>0) $_output .= "<a href='$_url?$_opts&amp;p=".($lowpage-1)."&amp;x=$max_p'>...</a>";
		for ($c_=$lowpage;$c_<=$highpage;$c_++) {
			if ($c_!=$_page) $_output .= "<a href='$_url?$_opts&amp;p=".($c_)."&amp;x=$max_p'>".($c_+1)."</a>";
			else $_output .= "<span>".($c_+1)."</span>";
		}
		if ($highpage!=$max_p) $_output .= "<a href='$_url?$_opts&amp;p=".($highpage+1)."&amp;x=$max_p'>...</a>";
		if ($_page<$max_p) {
			$_output .= "<a href='$_url?$_opts&amp;p=".($_page+1)."&amp;x=$max_p'>Next &raquo;</a>";
			$_output .= "<a href='$_url?$_opts&amp;p=$max_p&amp;x=$max_p'>Last &raquo;&raquo;</a>";
		} else {
			$_output .= "<span>Next &raquo;</span>";
			$_output .= "<span>Last &raquo;&raquo;</span>";
		}
		return $_output;
	}
	
	function check_pagination(&$n, &$p, &$x) {
		if ($n <= 0) $n = 10;
		if ($p <  0) $p = 0;
		if ($x != false)
			if ((!is_numeric($x))||($x < 0)) $x = 0;
	}
}