<?php
//引入连接mysql配置
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
    echo json_encode(array("code" => 1, "msg" => "Parameter error"));
    die;
}
//$utag = array("signature"=>"33333","utype"=>"Admins");
$sql = "select * from utag WHERE signature="."$utag->signature";

$stmt = $pdo->prepare($sql);
$rs = $stmt->execute();
$num= $stmt->rowCount(); 

if (0!=$num) {//has the record.
    // PDO::FETCH_ASSOC 关联数组形式
    // PDO::FETCH_NUM 数字索引数组形式
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $data = $row;
    }
    if($data['utype']==$utag->utype){
        echo json_encode(array("code" => "0", "msg" => "You have added this tag"));
        die;
    }else{
        $update = $pdo->prepare('update utag set utype = ? where signature = ?');
        $update->bindParam(1, $utag->utype, PDO::PARAM_STR);
        $update->bindParam(2,  $utag->signature, PDO::PARAM_INT);
        $result = $update->execute();
        if( $result ){
            mkdir($utag->utype);
            echo $data->utype;
            //echo $utag->signature." ".$utag->utype;
            echo json_encode(array("code" => "0", "msg" => "success"));
            die;
        }else{
            echo json_encode(array("code" => "2", "msg" => "Update failure"));
            die;
        }
    }
}else {

    $time = time();
    $insert = $pdo->prepare('insert into utag(signature,utype,ctime,utime) values(:signature,:utype,:ctime,:utime)');
    $insert->bindParam(':signature', $utag->signature, PDO::PARAM_INT);
    $insert->bindParam(':utype', $utag->utype, PDO::PARAM_STR);
    $insert->bindParam(':ctime', $time, PDO::PARAM_INT);
    $insert->bindParam(':utime', $time, PDO::PARAM_INT);
    $result = $insert->execute();
    if ($result) {
	    if (@scandir($utag->utype)) {
	    }else{
        	mkdir($utag->utype);
    	}
        echo $utag->signature." ".$utag->utype;
        echo json_encode(array("code" => "0", "msg" => "success"));
        die;
    } else {
        echo json_encode(array("code" => "4", "msg" => "creat fail"));
        die;
    }
}
$stmt = null;
$pdo = null;//关闭连接

?>