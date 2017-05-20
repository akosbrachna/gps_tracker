<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class myencryption 
{
    public function generate_keys()
    {
        $keys = array();
        $config = array(
 		'config' => 'e:/xampp/php/extras/openssl/openssl.cnf',
                'private_key_bits' => 1024,
		'private_key_type' => OPENSSL_KEYTYPE_RSA);

        $res = openssl_pkey_new($config);
        
        openssl_pkey_export($res, $private_key);
        $keys["private"] = $private_key;
        
        $public_key = openssl_pkey_get_details($res);
        $keys["public"] = $public_key["key"];
        
        return $keys;
    }
    
    public function decrypt($message, $privkey)
    {        
        openssl_private_decrypt(base64_decode($message), $output, $privkey, OPENSSL_SSLV23_PADDING);
        
        return $output;
    }
    
    public function xor_crypt($password, $message)
    {
	$a_p = str_split($password);
	$a_m = str_split($message);
	$lp = count($a_p);
	$lm = count($a_m);
	
	if ($lm < $lp) 
        {
            $lp = $lm;
        }
	$mod = $lm%$lp;
	$lm = ((int)($lm/$lp))*$lp + $mod;
	$c = array();
	$j = 0;
	while ($j*$lp < $lm)
	{
		for ($i = 0; $i < $lp; $i++ )
		{
			if ($j*$lp+$i >= $lm) break;
			$c[] = $a_m[$j*$lp+$i]^$a_p[$i];
		}
		$j++;
	}
	return implode('', $c);
    }
}
