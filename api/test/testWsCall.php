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

// First CLI argument: message to POST
$cliMsg = $argv[1];

// Second CLI argument: chat ID
$chatId = $argv[2];

$curl_handle = curl_init();

$headers = array();
$headers[] = 'Accept: application/json';
$headers[] = 'Content-Type: application/json';
$headers[] = generate_wsse_header('admin', 'adminpass');

echo implode('; ', $headers) . PHP_EOL;

curl_setopt($curl_handle, CURLOPT_URL, 'http://api.angular.local/app_dev.php/chatapi/' . $chatId);
curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl_handle, CURLOPT_POST, 1);
curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);

$message = new stdClass;
$message->content = $cliMsg;

$data = array(
    'message' => $message
);

echo json_encode($data) . PHP_EOL;
curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode($data));

curl_exec($curl_handle);
echo curl_getinfo($curl_handle, CURLINFO_HTTP_CODE); 

curl_close($curl_handle);