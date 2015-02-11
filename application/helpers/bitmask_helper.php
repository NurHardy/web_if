<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('bitmask_to_array')) {
	// Mengubah bentuk bitmask		: 0010110
	// Menjadi array				: (2, 3, 5)
    function bitmask_to_array($_bitmask) {
		$_arrret = array();
		$_tempmask = $_bitmask;
		$_idcur = 1;
		while ($_tempmask > 0) {
			if ($_tempmask & 1) $_arrret[] = $_idcur;
			$_tempmask = $_tempmask >> 1;
			$_idcur++;
		}
		return $_arrret;
	}
}