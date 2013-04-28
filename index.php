<?php
/**
-------------------------
GNU GPL COPYRIGHT NOTICES
-------------------------
This file is part of Open-School.

/**
 * $Id$
 *
 * @author Open-School team <contact@Open-School.org>
 * @link http://www.Open-School.org/
 * @copyright Copyright &copy; 2009-2012 wiwo inc.
 * @Matthew George,@Rajith Ramachandran,@Arun Kumar,
 * @Anupama,@Laijesh V Kumar.
 * @license http://www.Open-School.org/
 */
 
 
// If no environment info or no system settings, go install
if (file_exists(dirname(__FILE__).'/protected/config/environment.php') === false 
	) {
	header('location:install.php');exit;
}


// change the following paths if necessary
$yii=dirname(__FILE__).'/core/yii.php';
$config=dirname(__FILE__).'/protected/config/common.php';
//echo $config;exit;
// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

require_once($yii);
Yii::createWebApplication($config)->run();