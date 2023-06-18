<?php

namespace Safronik\Services\Visitor;

// Interfaces

// Templates
use LobsterTest\CodeTemplates\Singleton;

// Applied
use LobsterTest\Variables\Server;

/**
 * @method private registerVisitor( false|string $id, string $ip, false|int|string $ip_decimal, string $user_agent, string $browser_signature )
 * @method protected addIP()
 */
class Visitor{
	
	use Singleton;
    
	public string $id;
	public string $ip;
	public string $browser_signature;
	public string $user_agent;
    public int    $ip_decimal;
    
    protected function __construct()
    {
        $this->ip                = $this->addIP();
        $this->ip_decimal        = ip2long( $this->ip ) !== false ? ip2long( $this->ip ) : '0.0.0.0';
        $this->browser_signature = $this->addBrowserSignature();
        $this->user_agent        = $this->addUserAgent();
        $this->id                = $this->generateID( $this->ip, $this->browser_signature, $this->user_agent );
        //$this->gateway           = $gateway;
    }
    
	private function addIP(): string
	{
		return $this->ip ?? IP::get();
	}
	
	private function addBrowserSignature(): string
    {
		return $this->browser_signature ?? '';
	}
	
	private function addUserAgent(): string
    {
		return Server::get('HTTP_USER_AGENT');
	}
    
    private function generateID( $ip, $browser_signature, $user_agent ): string
    {
        return hash( 'sha256', $ip . $browser_signature . $user_agent );
    }
    
	public function getId()
	{
		return $this->id;
	}
}