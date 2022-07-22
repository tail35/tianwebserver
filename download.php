<?php

function logError($content)
{
	$logfile = '/home/wwwroot/dabiaoqian/public_html/phplog/debuglog'.date('Ymd').'.txt';
	if(!file_exists(dirname($logfile)))
	{
		@File_Util::mkdirr(dirname($logfile));
	}
	error_log(date("[Y-m-d H:i:s]")." -[".$_SERVER['REQUEST_URI']."] :".$content."\n", 3,$logfile);
}

$hash = $_REQUEST['hash'];
$rdir = $_REQUEST['rdir'];
$rdir = urldecode($rdir);
logError($rdir);
$uType = $_REQUEST['uType'];

if(null == $hash || null == $rdir || null ==  $uType){
    //@header('HTTP/1.0 404 Not Found');
    header('code:1');//param error.HASH_PARAM_ERROR
    die;
}
$fullName=  $_SERVER['DOCUMENT_ROOT'].'/'.$uType.'/'.$rdir;



if( strtoupper(substr(PHP_OS,0,3))==='WIN' ) {
    //$fullName = iconv('GB2312', 'UTF-8', $fullName);
    $fullName = iconv('utf-8', 'gbk', $fullName);
}

if(!file_exists ($fullName)){
    header('code:2');//file is not exist.HASH_SERVER_NO_FILE
    die;
}

$hashtemp = hash_file('md5',$fullName);


if("NEED_DOWN_IMEDIAE" == $hash){
//do nothing.
    $test=1;
    $test2=2;
}
else if( $hashtemp == $hash){
    //has exist at client.
    header('code:3');//aready exist.HASH_EQUAL
    die;
}

$file = fopen ( $fullName, "r" );
//输入文件标签
Header ( "Content-type: application/octet-stream" );
Header ( "Accept-Ranges: bytes" );
Header ( "Accept-Length: " . $fullName );
header('code:4');//success,HASH_WILL_DOWNLOAD
//输出文件内容
echo fread ( $file, filesize ( $fullName ) );
fclose ( $file );

?>