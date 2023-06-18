<?php

namespace LobsterTest\Visitor;

use LobsterTest\CodeTemplates\Singleton;
use LobsterTest\Variables\Server;
use LobsterTest\Variables\Request;

class IP{
	
	use Singleton;
	
	private $ip;
	
	public static function get()
	{
        return self::getInstance()->getIp();
	}
    
    /**
     * @return mixed
     */
    private function getIp()
    {
        if( $this->ip ){
			return $this->ip;
		}
		
		// X-Forwarded-For
        $headers = Request::getHTTPHeaders();
        if( isset( $headers['X-Forwarded-For'] ) ){
	        $tmp = explode( ',', trim( $headers['X-Forwarded-For'] ) );
	        $this->ip = trim( $tmp[0] );
        }
		$this->ip = $this->validate( $this->ip ) ? $this->ip : null;
		
		// Remote address
		if( ! $this->ip ){
            $this->ip = Server::get( 'REMOTE_ADDR' );
		}
		$this->ip = $this->validate( $this->ip ) ? $this->ip : null;
		
		return $this->ip ?: '0.0.0.0';
    }
    
	private function validate( $ip )
	{
		if( ! $ip ){
			return false;
		}
		
		if( filter_var( $ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ){
			return 'v4';
		}
		
		return false;
	}
}