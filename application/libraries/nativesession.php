<?php if ( ! defined('BASEPATH') ) exit( 'No direct script access allowed' );

// Kode sumber: http://www.moreofless.co.uk/using-native-php-sessions-with-codeigniter

class Nativesession {
    public function __construct()
    {
		if (!session_id()) session_start();
        //session_start();
    }

    public function set( $key, $value )
    {
        $_SESSION[$key] = $value;
    }

    public function get( $key )
    {
        return isset( $_SESSION[$key] ) ? $_SESSION[$key] : null;
    }

    public function regenerateId( $delOld = false )
    {
        session_regenerate_id( $delOld );
    }

    public function delete( $key )
    {
        unset( $_SESSION[$key] );
    }
}