<?php 

define("ROOTPATH", dirname(__FILE__));
define("APPPATH", ROOTPATH."/php/");

define("ISCONSOLE", PHP_SAPI == 'cli');

if (!ISCONSOLE) {
    header("HTTP/1.0 404 Not Found");
    exit;
}

require_once ROOTPATH . '/includes/config.php';
require_once ROOTPATH . '/includes/lib/idiorm.php';
require_once ROOTPATH . '/includes/db.php';

require_once ROOTPATH . '/includes/functions/func.global.php';
require_once ROOTPATH . '/includes/functions/func.email.php';
require_once ROOTPATH . '/includes/functions/func.admin.php';
require_once ROOTPATH . '/includes/functions/func.users.php';
require_once ROOTPATH . '/includes/functions/func.app.php';

// run_cron_job();

require_once APPPATH . 'managers/Manager.php';
require_once APPPATH . 'managers/orders/OrderManager.php';
require_once APPPATH . 'managers/orders/OrderCronManager.php';

$orderCronManager = new OrderCronManager();
$orderCronManager->overdue_detected();
