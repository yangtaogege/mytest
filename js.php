<?php
/*
 * 对基础框架的js.php的简单包装与配置，使它支持2个不同目录的css文件请求。
 * @author zhangzhang
 * @date 2012/09
 */
require_once "config.inc.php";
$frameworkPath = $cfg['framework']['dir'];
$__js__baseDir = realpath("..");

require_once "../{$frameworkPath}/php/js.php";
?>