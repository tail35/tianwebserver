<?php
include("mysql_config.php");

$utag=file_get_contents("php://input"); //取得json数据
//$arr = json_decode($data);   //格式化
//echo $arr->signature;
if (!$utag) {
    echo json_encode(array("code" => 1, "msg" => "no context."));
    die;
}
$utag = json_decode($utag); 
if (!$utag) {
    echo json_encode(array("code" => 1, "msg" => "not json."));
    die;
}
$utag = $utag->signature;

if( !$utag ){
    echo json_encode(array("code"=>1,"msg"=>"signature null."));
    die;
}

$sql = "select * from utag WHERE signature=".$utag;

$stmt = $pdo->prepare($sql);
$rs = $stmt->execute();
$num= $stmt->rowCount(); 

if (0!=$num) {
    // PDO::FETCH_ASSOC 关联数组形式
    // PDO::FETCH_NUM 数字索引数组形式
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
    {
        $data = $row;
    }
    if( !($data['utype']) )
    {
        echo json_encode(array("code"=>1,"msg"=>"First item Not utype"));
        die;
    }
}else
{
    echo json_encode(array("code"=>1,"msg"=>"No query utype"));
    die;
}

function isInString1($haystack, $needle) 
{ 
    //防止$needle 位于开始的位置 
    $haystack = '-_-!' . $haystack; 
    return (bool)strpos($haystack, $needle); 
}

function get_extension($file)
{
    return pathinfo($file, PATHINFO_EXTENSION);
}

function delfirstslash($rdir){

    $res = strpos($rdir,"/");
    if(-1!=$res){
        $str = substr($rdir, $res + 1, strlen($rdir) - $res - 1);
    }
    return $str;
}

function searchDir($path,&$data){
    $dp=dir($path);
    while($file=$dp->read()){

        $dir1=$path . '/' . $file;

        if(is_dir($dir1)) {
            if ($file != '.' && $file != '..') {
                searchDir($dir1, $data);
            }
        }else{
            $exten = get_extension($file);
            $subffix =  '.tls.tgz.mp3.mp4';
            if( isInString1($subffix,$exten) ){
                if( strtoupper(substr(PHP_OS,0,3))==='WIN' ) {
                    $fl =iconv('GB2312', 'UTF-8', $dir1);
                    $tmpdir =  delfirstslash($fl);
                    $size = filesize($dir1);
                    $hash = hash_file('md5',$dir1);
                    $ob = array("rdir"=>$tmpdir,"size"=>$size,"hash"=>$hash);
                    //$data[]=delfirstslash($fl);
                    $data[] = $ob;
                }else{
                    $tmpdir =  delfirstslash($dir1);
                    $size = filesize($dir1);
                    $hash = hash_file('md5',$dir1);
                    $ob = array("rdir"=>$tmpdir,"size"=>$size,"hash"=>$hash);
                    //$data[]=delfirstslash($fl);
                    $data[] = $ob;
                }
            }
        }
    }
    $dp->close();
    //if(is_file($path))
}

function getDir($dir){    
    $data=array();
    searchDir($dir,$data);
    return   $data;
}

$files = getDir($data['utype']);

if( !$files ){
    echo json_encode(array("code"=>1,"msg"=>"no any folder for this utype."));
    die;
}
$ret = [
    "code"=>0,
    "utype"=>$data['utype'],
    "filelist"=>$files,
    "msg"=>"sucess"
];

echo json_encode($ret,JSON_UNESCAPED_UNICODE);
$stmt = null;
$pdo = null;//关闭连接

?>