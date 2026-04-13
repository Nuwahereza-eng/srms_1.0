<?php
session_start();
require_once 'waf/autoload.php';

$wafConfig = [
'maxRequestsPerMinute' => 100
];

$waf = new WAF($wafConfig);

require_once 'models/utility.php';

$utility = new utility;

require_once 'models/database.php';

foreach(glob('controllers/*.php') as $file) {

require_once($file);

}
?>
