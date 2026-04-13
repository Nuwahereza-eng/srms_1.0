<?php

class WAF
{
private $blockedIPs = [];
private $rateLimit = [];
private $maxRequestsPerMinute = 60;


private $sqlInjectionPatterns = [
'/union\s+select/i',
'/select.*from/i',
'/insert\s+into/i',
'/update.*set/i',
'/delete\s+from/i',
'/drop\s+table/i',
'/or\s+1=1/i',
'/exec(\s|\()+/i',
'/--\s+/',
'/;/',
'/\/\*.*\*\//'
];

private $xssPatterns = [
'/<script.*?>.*?<\/script>/is',
'/javascript:/i',
'/onload\s*=/i',
'/onerror\s*=/i',
'/onclick\s*=/i',
'/<iframe.*?>/is',
'/<object.*?>/is',
'/<embed.*?>/is'
];

private $rcePatterns = [
'/system\s*\(/i',
'/exec\s*\(/i',
'/shell_exec\s*\(/i',
'/eval\s*\(/i',
'/passthru\s*\(/i',
'/`.*`/',
'/\$\{.*\}/'
];

public function __construct($config = [])
{
if (isset($config['maxRequestsPerMinute'])) {
$this->maxRequestsPerMinute = $config['maxRequestsPerMinute'];
}

$this->runSecurityChecks();
}

private function runSecurityChecks()
{
$this->checkRateLimit();

if (!empty($_GET)) {
$this->scanInput($_GET, 'GET');
}

if (!empty($_POST)) {
$this->scanInput($_POST, 'POST');
}

if (!empty($_COOKIE)) {
$this->scanInput($_COOKIE, 'COOKIE');
}

$this->checkHeaders();
}

private function checkRateLimit()
{
$clientIP = $this->getClientIP();
$currentTime = time();
$minuteWindow = floor($currentTime / 60);

if (!isset($this->rateLimit[$clientIP])) {
$this->rateLimit[$clientIP] = [
'window' => $minuteWindow,
'count' => 1
];
return;
}

if ($this->rateLimit[$clientIP]['window'] != $minuteWindow) {
$this->rateLimit[$clientIP] = [
'window' => $minuteWindow,
'count' => 1
];
return;
}

$this->rateLimit[$clientIP]['count']++;

if ($this->rateLimit[$clientIP]['count'] > $this->maxRequestsPerMinute) {
$this->blockRequest('Rate limit exceeded', 429);
}
}

private function scanInput($input, $type)
{
foreach ($input as $key => $value) {
if (is_array($value)) {
$this->scanInput($value, $type);
} else {
$this->checkForMaliciousContent($value, $type . ' parameter: ' . $key);
}
}
}

private function checkForMaliciousContent($input, $context)
{

foreach ($this->sqlInjectionPatterns as $pattern) {
if (preg_match($pattern, $input)) {
$this->blockRequest("SQL injection detected in $context", 403);
}
}

foreach ($this->xssPatterns as $pattern) {
if (preg_match($pattern, $input)) {
$this->blockRequest("XSS attempt detected in $context", 403);
}
}

foreach ($this->rcePatterns as $pattern) {
if (preg_match($pattern, $input)) {
$this->blockRequest("RCE attempt detected in $context", 403);
}
}

if (preg_match('/\.\.\//', $input) || preg_match('/\.\.\\\/', $input)) {
$this->blockRequest("Path traversal attempt detected in $context", 403);
}
}

private function checkHeaders()
{
$headers = $this->getAllHeaders();

foreach ($headers as $header => $value) {
$lowerHeader = strtolower($header);
if (in_array($lowerHeader, [
'sec-ch-ua',
'sec-ch-ua-mobile',
'sec-ch-ua-platform',
'user-agent',
'accept',
'accept-language',
'accept-encoding',
'connection',
'cache-control',
'cookie',
'content-type',
'content-length',
'origin',
'referer',
'sec-fetch-site',
'sec-fetch-mode',
'sec-fetch-dest',
'upgrade-insecure-requests'
])) {
continue;
}

$this->checkForMaliciousContent($value, "Header: $header");
}
}

private function getAllHeaders()
{
if (function_exists('getallheaders')) {
return getallheaders();
}

$headers = [];
foreach ($_SERVER as $name => $value) {
if (substr($name, 0, 5) == 'HTTP_') {
$headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
}
}
return $headers;
}

private function getClientIP()
{
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
$ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
return trim($ips[0]);
} elseif (!empty($_SERVER['HTTP_X_REAL_IP'])) {
return $_SERVER['HTTP_X_REAL_IP'];
} else {
return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
}
}

private function blockRequest($reason, $httpCode = 403)
{
$this->logAttackAttempt($reason);

http_response_code($httpCode);

echo "<!DOCTYPE html>
<html>
<head>
<title>Security Violation Detected</title>
<style>
body {
    font-family: consolas;
    text-align: center;
    padding: 50px;
    background-color:#667eea;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
}
.security-alert {
    background: white;
    color: #2d3436;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    max-width: 500px;
    width: 100%;
}
.security-alert h1 {
    color: #d63031;
    margin-bottom: 15px;
    font-size: 1.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.security-alert h1:before {
    content: '🛡️';
    font-size: 1.3rem;
}
.security-alert p {
    margin: 10px 0;
    line-height: 1.5;
    color: #636e72;
}
.reason {
    background: #fff9f9;
    border: 1px solid #ffebee;
    padding: 15px;
    border-radius: 8px;
    margin: 15px 0;
    font-family: 'Courier New', monospace;
    font-size: 0.9rem;
    color: #d63031;
}
.contact {
    font-size: 0.8rem;
    color: #636e72;
    margin-top: 20px;
    padding-top: 15px;
    border-top: 1px solid #dfe6e9;
}
</style>
</head>
<body>
<div class='security-alert'>
    <h1>Security Violation Detected</h1>
    <p>Your request has been blocked by our security system.</p>
    <div class='reason'><strong>Reason:</strong> $reason</div>
    <p>If this is an error, please contact support.</p>
    <div class='contact'>Reference: " . uniqid() . " | " . date('Y-m-d H:i:s') . "</div>
</div>
</body>
</html>";

exit;
}

private function logAttackAttempt($reason)
{
$clientIP = $this->getClientIP();
$timestamp = date('Y-m-d H:i:s');
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
$requestUri = $_SERVER['REQUEST_URI'] ?? 'Unknown';

$logEntry = "[$timestamp] IP: $clientIP | Reason: $reason | URI: $requestUri | User-Agent: $userAgent" . PHP_EOL;

$logFile = __DIR__ . '/logs/' . date('Y-m-d') . '.log';
if (!is_dir(dirname($logFile))) {
mkdir(dirname($logFile), 0755, true);
}

file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
}

public function blockIP($ip, $reason = "Manual block")
{
$this->blockedIPs[$ip] = [
'timestamp' => time(),
'reason' => $reason
];

$clientIP = $this->getClientIP();
if ($clientIP === $ip) {
$this->blockRequest($reason, 403);
}
}

public function isIPBlocked($ip)
{
return isset($this->blockedIPs[$ip]);
}
}


?>
