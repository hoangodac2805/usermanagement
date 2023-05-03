<?php 
if(!defined('_INCODE'))  die('Access Dined...');
?>
<?php
try{
    if (class_exists('PDO')){
        $dsn = _DRIVER.':dbname='._DB.';host='._HOST;
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //Đẩy lỗi vào ngoại lệ khi truy vấn
        ];
        $conn = new PDO($dsn, _USER, _PASS, $options);
    }
}catch (Exception $exception){
   require_once 'modules/errors/database.php';
    die();
}
?>
<div><img src="asdasd/asdfsaf" alt=""></div>
<div><img src="asdasd/asdfsaf" alt=""></div>
<div><img src="asdasd/asdfsaf" alt=""></div>
<div><img src="asdasd/asdfsaf" alt=""></div>
<div><img src="asdasd/asdfsaf" alt=""></div>
<div><img src="asdasd/asdfsaf" alt=""></div>
<div><img src="asdasd/asdfsaf" alt=""></div>
<div><img src="asdasd/asdfsaf" alt=""></div>
<div><img src="asdasd/asdfsaf" alt=""></div>




