<?php
require_once "php/config.inc.php";

#$title = $cfg['name'];
$title = "5.X-应用规则管理-5.X";
$version = $cfg['version'];
$frameworkDir = $cfg['framework']['dir'];

require_once "php/ModuleCache.php";

$_dc = "";
$_dcAppend = "";
// 有时要缓存，这样才能下断点调试
if($disableCacheMode){
	$_dcSeed = time();
	if(isset($_GET['cache'])){
		$_dcSeed = $_GET['cache'];
	}
	$_dc = "?$_dcSeed";
	$_dcAppend = "&$_dcSeed";
}
?>
<HTML>
<HEAD>
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Cache-Control" content="no-cache" >
<meta http-equiv="Cache-Control" content="must-revalidate" >
<meta http-equiv="Expires" content="-1">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<TITLE><?php echo $title; ?></TITLE>
<link rel="stylesheet" type="text/css" href="<?php echo $frameworkDir; ?>/ext/resources/css/ext-all.css<?php echo $_dc; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $frameworkDir; ?>/php/css.php?n=/style/ext-patch<?php echo $_dcAppend; ?>" />
<style type="text/css">
    #loading-mask{
        position:absolute;
        left:0;
        top:0;
        width:100%;
        height:100%;
        z-index:20000;
        background-color:white;
    }
    #loading{
        position:absolute;
        left:40%;
        top:40%;
        padding:2px;
        z-index:20001;
        height:auto;
        overflow: auto;
    }
    #loading #progress {
    	background:none repeat-x scroll 0 0 transparent;
		border:1px solid #41873A;
		padding:1px !important;
		position:relative;
        height: 8px;
        width: 200px;
        text-align: left;
    }
    #loading #progress-bar {
    	background-color:#41873A;
		background-image:none;
		border:medium none;
        height: 8px !important;
        width: 5px;
        font-size:6px;
    }
    #loading .loading-indicator{
        background:white;
        color:#444;
        font:bold 13px tahoma,arial,helvetica;
        padding:10px;
        margin:0;
        height:auto;
        overflow: auto;
        text-align: center;
    }
    #loading-msg {
        font: normal 12px arial,tahoma,sans-serif;
        padding:0 0 5px 0;
        text-align:left;
        display:block;
    }
</style>
<script type="text/javascript">

function load_status(percent){
	var str = percent+"%";
	var p = document.getElementById('progress-bar');
	p.style.width = str;
}

function load_finished(){
	var lm = document.getElementById('loading-mask');
	lm.style.display = 'none';
	var l = document.getElementById('loading');
	l.style.display = 'none';
}
</script>
</HEAD>

<BODY>
<div id="loading-mask" style=""></div>
<div id="loading">
	<div class="loading-indicator">
		<span id="loading-msg" style="">正在加载 ...</span>
		<div id="progress"> <div id="progress-bar"> </div> </div>
	</div>
</div>

<script type="text/javascript"> load_status(41); </script>
<script type="text/javascript" src="<?php echo $frameworkDir; ?>/php/js.php?n=ext/adapter/ext/ext-base-debug,js/ext-base-patch<?php echo $_dcAppend; ?>"></script>

<script type="text/javascript"> load_status(57); </script>
<script type="text/javascript" src="<?php echo $frameworkDir; ?>/php/js.php?n=ext/ext-all-debug,js/ext-patch<?php echo $_dcAppend; ?>"></script>
<script type="text/javascript" src="php/js.php?n=js/depends,js/mappers<?php echo $_dcAppend; ?>"></script>
<?php
	// 加上debug参数可以开启调试模式
	if(isset($_GET['debug'])){
		echo <<<Jscript
<script type="text/javascript">
	var SFDebugMode = true;
</script>
Jscript;
	}
	if(isset($_GET['local'])){
		echo <<<Jscript
<script type="text/javascript">
	var SFLocalMode = true;
</script>
Jscript;
	}
	if(isset($_GET['page'])){
		$defaultPageStr = json_encode($_GET['page']);
		echo <<<Jscript
<script type="text/javascript">
	var SFDefaultPage = $defaultPageStr;
</script>
Jscript;
	}
	if($disableCacheMode){
		$_dcSeedStr = json_encode($_dcSeed);
		echo <<<Jscript
<script type="text/javascript">
	var SFDisableCacheMode = $_dcSeedStr;
</script>
Jscript;
	}
?>

<script type="text/javascript"> load_status(72); </script>
<?php
	$jsReg = "#\.js$#";
	$cssReg = "#\.css#";
	foreach($cfg['caches'] as $cache){
		if(!isset($cache['entry']) || $cache['entry'] !== true){
			continue;
		}
		$jsFile = $cache['js'];
		$cssFile = $cache['css'];
		if(!empty($jsFile)){
			if(preg_match($jsReg, $jsFile)){
				$jsFile = "php/js.php?n=".preg_replace($jsReg, "", $jsFile).$_dcAppend;
			}
			echo "<script type=\"text/javascript\" src=\"{$jsFile}\"></script>\r\n";
		}
		if(!empty($cssFile)){
			if(preg_match($cssReg, $cssFile)){
				$cssFile = "php/css.php?n=".preg_replace($cssReg, "", $cssFile).$_dcAppend;
			}
			echo "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$cssFile}\" />\r\n";
		}
	}
?>
<script type="text/javascript"> load_finished(); </script>

</BODY>
</HTML>
