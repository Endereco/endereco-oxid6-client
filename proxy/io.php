<?php

if ('GET' === $_SERVER['REQUEST_METHOD']) {
    die('We expect a POST request here.');
}

include("../metadata.php");
$pluginVersion = $aModule['version'] ?? '0.0.0';
$agent_info  = "Endereco Oxid6 Client v" . $pluginVersion;
$post_data   = json_decode(file_get_contents('php://input'), true);

if (empty($_SERVER['HTTP_X_REMOTE_API_URL'])) {
    http_response_code(400);
    die('Missing or blank remote API URL header.');
}
$remote_url = trim($_SERVER['HTTP_X_REMOTE_API_URL']);

// Strip protocol, path, and query parameters to extract the domain.
$remote_domain = preg_replace('#^https?://#', '', $remote_url);
if ($remote_domain === null) {
    http_response_code(400);
    die('Invalid URL format.');
}
$remote_domain = explode('/', $remote_domain)[0];
$remote_domain = explode('?', $remote_domain)[0];
$remote_domain = trim(strtolower($remote_domain));

$allowed_remote_domain_pattern = '/^(([a-z0-9]([a-z0-9\-]{0,61}[a-z0-9])?\.)+)?endereco-service\.de$/';
if (!preg_match($allowed_remote_domain_pattern, $remote_domain)) {
    http_response_code(400);
    die('Invalid remote API url.');
}

$api_key     = trim($_SERVER['HTTP_X_AUTH_KEY']);
$data_string = json_encode($post_data);
$ch          = curl_init($remote_url);

if ($_SERVER['HTTP_X_TRANSACTION_ID']) {
    $tid = $_SERVER['HTTP_X_TRANSACTION_ID'];
} else {
    $tid = 'not_set';
}

curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    [
        'Content-Type: application/json',
        'X-Auth-Key: ' . $api_key,
        'X-Transaction-Id: ' . $tid,
        'X-Agent: ' . $agent_info,
        'X-Transaction-Referer: ' . $_SERVER['HTTP_X_TRANSACTION_REFERER'],
        'Content-Length: ' . strlen($data_string)]
);

$result = curl_exec($ch);

header('Content-Type: application/json');
echo $result;
die();
