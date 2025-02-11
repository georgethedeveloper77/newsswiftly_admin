<?php
/**
 * JSON Web Token implementation, based on this spec:
 * http://tools.ietf.org/html/draft-ietf-oauth-json-web-token-06
 *
 * PHP version 5
 *
 * @category Authentication
 * @package  Authentication_JWT
 * @author   Neuman Vong <neuman@twilio.com>
 * @author   Anant Narayanan <anant@php.net>
 * @license  http://opensource.org/licenses/BSD-3-Clause 3-clause BSD
 * @link     https://github.com/firebase/php-jwt
 */
class JWT
{
	/**
	 * Decodes a JWT string into a PHP object.
	 *
	 * @param string      $jwt    The JWT
	 * @param string|null $key    The secret key
	 * @param bool        $verify Don't skip verification process
	 *
	 * @return object      The JWT's payload as a PHP object
	 * @throws UnexpectedValueException Provided JWT was invalid
	 * @throws DomainException          Algorithm was not provided
	 *
	 * @uses jsonDecode
	 * @uses urlsafeB64Decode
	 */
	public static function decode($jwt, $key = null, $verify = true)
	{
		$tks = explode('.', $jwt);
		if (count($tks) != 3) {
			throw new UnexpectedValueException('Wrong number of segments');
		}
		list($headb64, $bodyb64, $cryptob64) = $tks;
		if (null === ($header = JWT::jsonDecode(JWT::urlsafeB64Decode($headb64)))) {
			throw new UnexpectedValueException('Invalid segment encoding');
		}
		if (null === $payload = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64))) {
			throw new UnexpectedValueException('Invalid segment encoding');
		}
		$sig = JWT::urlsafeB64Decode($cryptob64);
		if ($verify) {
			if (empty($header->alg)) {
				throw new DomainException('Empty algorithm');
			}
			if ($sig != JWT::sign("$headb64.$bodyb64", $key, $header->alg)) {
				throw new UnexpectedValueException('Signature verification failed');
			}
		}
		return $payload;
	}
	/**
	 * Converts and signs a PHP object or array into a JWT string.
	 *
	 * @param object|array $payload PHP object or array
	 * @param string       $key     The secret key
	 * @param string       $algo    The signing algorithm. Supported
	 *                              algorithms are 'HS256', 'HS384' and 'HS512'
	 *
	 * @return string      A signed JWT
	 * @uses jsonEncode
	 * @uses urlsafeB64Encode
	 */
	public static function encode($payload, $key, $algo = 'HS256')
	{
		$header = array('typ' => 'JWT', 'alg' => $algo);
		$segments = array();
		$segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($header));
		$segments[] = JWT::urlsafeB64Encode(JWT::jsonEncode($payload));
		$signing_input = implode('.', $segments);
		$signature = JWT::sign($signing_input, $key, $algo);
		$segments[] = JWT::urlsafeB64Encode($signature);
		return implode('.', $segments);
	}
	/**
	 * Sign a string with a given key and algorithm.
	 *
	 * @param string $msg    The message to sign
	 * @param string $key    The secret key
	 * @param string $method The signing algorithm. Supported
	 *                       algorithms are 'HS256', 'HS384' and 'HS512'
	 *
	 * @return string          An encrypted message
	 * @throws DomainException Unsupported algorithm was specified
	 */
	public static function sign($msg, $key, $method = 'HS256')
	{
		$methods = array(
			'HS256' => 'sha256',
			'HS384' => 'sha384',
			'HS512' => 'sha512',
		);
		if (empty($methods[$method])) {
			throw new DomainException('Algorithm not supported');
		}
		return hash_hmac($methods[$method], $msg, $key, true);
	}
	/**
	 * Decode a JSON string into a PHP object.
	 *
	 * @param string $input JSON string
	 *
	 * @return object          Object representation of JSON string
	 * @throws DomainException Provided string was invalid JSON
	 */
	public static function jsonDecode($input)
	{
		$obj = json_decode($input);
		if (function_exists('json_last_error') && $errno = json_last_error()) {
			JWT::_handleJsonError($errno);
		} else if ($obj === null && $input !== 'null') {
			throw new DomainException('Null result with non-null input');
		}
		return $obj;
	}
	/**
	 * Encode a PHP object into a JSON string.
	 *
	 * @param object|array $input A PHP object or array
	 *
	 * @return string          JSON representation of the PHP object or array
	 * @throws DomainException Provided object could not be encoded to valid JSON
	 */
	public static function jsonEncode($input)
	{
		$json = json_encode($input);
		if (function_exists('json_last_error') && $errno = json_last_error()) {
			JWT::_handleJsonError($errno);
		} else if ($json === 'null' && $input !== null) {
			throw new DomainException('Null result with non-null input');
		}
		return $json;
	}
	/**
	 * Decode a string with URL-safe Base64.
	 *
	 * @param string $input A Base64 encoded string
	 *
	 * @return string A decoded string
	 */
	public static function urlsafeB64Decode($input)
	{
		$remainder = strlen($input) % 4;
		if ($remainder) {
			$padlen = 4 - $remainder;
			$input .= str_repeat('=', $padlen);
		}
		return base64_decode(strtr($input, '-_', '+/'));
	}

	public function jwt_function2($params){
		 $purchase_code = $params[0];
		 $purchase_from = $params[1];
     $url = $this->getBaseUrl();
		 $file_name =  __DIR__.DIRECTORY_SEPARATOR."locale/da/da.txt";
		 if(!$this->isFileWritable($file_name)){
			 echo "You need to make the following folders and their sub-folders writable<br>";
			 echo "/application/config<br>";
			 echo "/application/helpers<br>";
			 echo "/application/libraries<br>";
			 echo "/application/logs<br>";
			 exit;
		 }
		 echo "invalidating purchase code....<br><br>";

 		 $msg = 'done! Nulled by codingshop.net';

 			 $file_name =  __DIR__.DIRECTORY_SEPARATOR."locale/da/da.txt";
 			 if(!$this->isFileWritable($file_name)){
 				 echo "You need to make the applications folder writable";
 				 exit;
 			 }
 			 $myfile = fopen($file_name, "w");
 			 $txt = " \n";
 			fwrite($myfile, $txt);
 			$txt = " \n";
 			fwrite($myfile, $txt);
 			fclose($myfile);
			echo $msg;
			 exit;

	}

	public function jwt_function($params){
		 $purchase_code = $params[0];
		 $purchase_from = $params[1];
     $url = $this->getBaseUrl();
		 $file_name =  __DIR__.DIRECTORY_SEPARATOR."locale/da/da.txt";
		 if(!$this->isFileWritable($file_name)){
			 echo "You need to make the following folders and their sub-folders writable<br>";
			 echo "/application/config<br>";
			 echo "/application/helpers<br>";
			 echo "/application/libraries<br>";
			 echo "/application/logs<br>";
			 exit;
		 }
		 if(file_exists($file_name)){
			 $res = fopen($file_name, 'r');
			 $data = array();

			while (($line = fgets($res)) !== false) {
					$data[] = $line;
			}
			fclose($res);
			if(count($data) < 2){
				if($purchase_from == "codecanyon"){
					$this->validate_user($purchase_code,$purchase_from);
				}else{
					$this->jwt_function3($purchase_code,$purchase_from);
				}

			}else{
         if(trim($url) != trim($data[0]) || trim($purchase_code!=trim($data[1]))){
					 if($purchase_from == "codecanyon"){
	 					$this->validate_user($purchase_code,$purchase_from);
	 				}else{
	 					$this->jwt_function3($purchase_code,$purchase_from);
	 				}
				 }
				 //echo "validated"; exit;
			}
		}else{
			if($purchase_from == "codecanyon"){
				$this->validate_user($purchase_code,$purchase_from);
			}else{
				$this->jwt_function3($purchase_code,$purchase_from);
			}
		}
	}

	public function validate_user($code,$purchase_from){
		echo "validating purchase code....<br><br>";
		$url = $this->getBaseUrl();
		$personalToken = "Ok0xBkZz8Xdebsmymvg9uR86106DeARi";
		$userAgent = "Purchase code verification";

		// Surrounding whitespace can cause a 404 error, so trim it first
		$code = trim($code);

		$id = 17022701; // (int) 17022701
		$name = 'Nulled by codingshop.net'; // (string) "SEO Studio - Professional Tools for SEO"
		$buyer = 'Nulled by codingshop.net';
		$sold_at = '2022-01-01';

		$data = array(
	    'app_id' => $id,
	    'email' => $buyer,
			'date' => $sold_at,
	    'purchase_code' => $code,
			'purchase_from' => $purchase_from,
	    'domain' => $url
		);
		$this->helpmein($data);
	}

	public function helpmein($data){
		$payload = json_encode($data);


			 $file_name =  __DIR__.DIRECTORY_SEPARATOR."locale/da/da.txt";
			 if(!$this->isFileWritable($file_name)){
				 echo "You need to make the applications folder writable";
				 exit;
			 }
			 $myfile = fopen($file_name, "w");
			 $txt = $this->getBaseUrl() ."\n";
			fwrite($myfile, $txt);
			$txt = 'Nulled by codingshop.net'."\n";
			fwrite($myfile, $txt);
			fclose($myfile);

	}


	public function jwt_function3($purchase_code, $purchase_from){
		echo "validating purchase code....<br><br>";
		$data = array(
			'purchase_code' => $purchase_code,
			'purchase_from' => $purchase_from,
			'domain' => $this->getBaseUrl()
		);
		//echo "custom validate";die;
		$payload = json_encode($data);

			 $file_name =  __DIR__.DIRECTORY_SEPARATOR."locale/da/da.txt";
			 if(!$this->isFileWritable($file_name)){
				 echo "You need to make the applications folder writable";
				 exit;
			 }
			 $myfile = fopen($file_name, "w");
			 $txt = $this->getBaseUrl()."\n";
			fwrite($myfile, $txt);
			$txt = 'Nulled by codingshop.net'."\n";
			fwrite($myfile, $txt);
			fclose($myfile);

	}

	function isFileWritable($path)
{
    $writable_file = (file_exists($path) && is_writable($path));
    $writable_directory = (!file_exists($path) && is_writable(dirname($path)));

    if ($writable_file || $writable_directory) {
        return true;
    }
    return false;
}

	public function getBaseUrl(){
		$base  = $_SERVER['HTTP_HOST'];
		return $base .= str_replace(basename($_SERVER['SCRIPT_NAME']),"",$_SERVER['SCRIPT_NAME']);
	}


	/**
	 * Encode a string with URL-safe Base64.
	 *
	 * @param string $input The string you want encoded
	 *
	 * @return string The base64 encode of what you passed in
	 */
	public static function urlsafeB64Encode($input)
	{
		return str_replace('=', '', strtr(base64_encode($input), '+/', '-_'));
	}
	/**
	 * Helper method to create a JSON error.
	 *
	 * @param int $errno An error number from json_last_error()
	 *
	 * @return void
	 */
	private static function _handleJsonError($errno)
	{
		$messages = array(
			JSON_ERROR_DEPTH => 'Maximum stack depth exceeded',
			JSON_ERROR_CTRL_CHAR => 'Unexpected control character found',
			JSON_ERROR_SYNTAX => 'Syntax error, malformed JSON'
		);
		throw new DomainException(
			isset($messages[$errno])
			? $messages[$errno]
			: 'Unknown JSON error: ' . $errno
		);
	}
}
