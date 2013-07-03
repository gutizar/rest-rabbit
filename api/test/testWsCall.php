<?php

function generate_wsse_header($username, $secret)
{
    // date_default_timezone_set('Europe/Paris');
    $nonce = md5(rand(), true);
    $created = gmdate('Y-m-d\TH:i:s\Z');

    $digest = base64_encode(sha1($nonce.$created.$secret,true));
    $b64nonce = base64_encode($nonce);

    return sprintf('X-WSSE: UsernameToken Username="%s", PasswordDigest="%s", Nonce="%s", Created="%s"',
        $username,
        $digest,
        $b64nonce,
        $created
    );
}

echo generate_wsse_header('admin', 'adminpass');

$curl_handle = curl_init();

curl_setopt($curl_handle, CURLOPT_URL, 'http://api.angular.local/app_dev.php/bookapi/2');
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, array(generate_wsse_header('admin', 'adminpass')));

curl_exec($curl_handle);
echo curl_getinfo($curl_handle, CURLINFO_HTTP_CODE); 

curl_close($curl_handle);