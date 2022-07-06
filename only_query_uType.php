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

$ret = [
    "code"=>0,
    "utype"=>$data['utype'],
    "msg"=>"sucess"
];

echo json_encode($ret,JSON_UNESCAPED_UNICODE);
$stmt = null;//也要关闭
$pdo = null;//关闭连接


?>