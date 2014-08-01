<?php
namespace Nodefortytwo\Crypt;

class Crypt{
	private static $key = "this is a key!";


	public static function encrypt($input){
		$input = trim($input);
	    $td = mcrypt_module_open('tripledes', '', 'ecb', '');
	    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	    mcrypt_generic_init($td, self::$key, $iv);
	    $encrypted_data = mcrypt_generic($td, $input);
	    mcrypt_generic_deinit($td);
	    mcrypt_module_close($td);

	    return base64_encode($encrypted_data);

	}

	public static function decrypt($input){
		$input = base64_decode($input);
		$td = mcrypt_module_open('tripledes', '', 'ecb', '');
	    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
	    mcrypt_generic_init($td, self::$key, $iv);
	    $decrypted = mdecrypt_generic($td, $input);
	    mcrypt_generic_deinit($td);
	    mcrypt_module_close($td);

	    $decrypted = trim($decrypted);
	    return $decrypted;
	}

	public static function setKey($key){
		self::$key = $key;
	}
}