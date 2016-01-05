<?php
/**
 * Authentication Class
 *
 * Allows frontened users to login via thier email and a token link
 * 
 * @package   Prayer
 * @author 	  Kaleb Heitzman <kalebheitzman@gmail.com>
 * @link      https://github.com/kalebheitzman/prayer
 * @copyright 2015 Kaleb Heitzman
 * @license   GPL-3.0
 * @version   0.9.0
 */
class Prayer_Auth
{
	public function __construct()
	{

	}

	public function send_email()
	{

	}

	public function generate_token()
	{

		return $token;
	}

	public function validate_token( $token = null )
	{
		if ( is_null($token) ) return false;
		
		return true;
	}

	public function authorize()
	{
		
	}

}