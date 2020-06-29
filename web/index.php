<?php


/**
 * Для отладки на локальной машине
 */
if (in_array(@$_SERVER['REMOTE_ADDR'], ['127.0.0.1', '192.168.83.1', '::1'])) {

    defined('YII_DEBUG') or define('YII_DEBUG', true);
    defined('YII_ENV') or define('YII_ENV', 'dev');
}

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/yiisoft/yii2/Yii.php';

$config = require __DIR__ . '/../config/web.php';

(new yii\web\Application($config))->run();
