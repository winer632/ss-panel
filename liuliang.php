<?php 
/*
wangxx created this file on Jun 15,2016 
*/

error_reporting(0);
date_default_timezone_set("PRC");
ignore_user_abort();
set_time_limit(0);

$handle = fopen(dirname(__FILE__)."liuliang.log", "a+");

echo "email is ".$argv[1]."\n";
echo "money is ".$argv[2]."\n";
if(isset($argv[1])){
	$email = "'".$argv[1]."'";
}else{
	echo "no email\n";
	echo "php liuliang.php email money\n";
	exit;
}

if(isset($argv[2])){
	$money = $argv[2];
}else{
	echo "no money\n";
	echo "php liuliang.php email money\n";
	exit;
}


switch ($money) {
	case("5"):
  	$add_liuliang=1073741824;
  	break;
  case("10"):
  	$add_liuliang=3221225472;
  	break;
  case("20"):
  	$add_liuliang=9663676416;
  	break;
  default:
  	echo "wrong money\nmoney should be 5,10,20\n";
    exit;
}


echo "{$email}\n";
echo "{$money}\n";


define(MYSQL_HOST, 'localhost');
define(MYSQL_USER, 'root');
define(MYSQL_PASS, 'sOHSS*)@@)#R*382984');
define(MYSQL_SS_DB, 'sspanel');
define(TABLE_USER, 'user');


$user_db_conn = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_SS_DB, 3306) or die("Error " . mysqli_error($user_db_conn));
$sql = sprintf("select * from %s where email = %s", TABLE_USER, $email);
fwrite($handle, 'TIME: '.date("Y-m-d_H:i:s")."    sql is ".$sql."\n");
$result = mysqli_query($user_db_conn, $sql);
if(mysqli_num_rows($result) > 0){
    $row=mysqli_fetch_assoc($result);
    $old_liuliang=$row["transfer_enable"];
    $transfer_enable=$add_liuliang+$old_liuliang;

    fwrite($handle, "TIME: ".date("Y-m-d_H:i:s")."\t old_liuliang is ".$GLOBALS['old_liuliang']."\n");
    fwrite($handle, "TIME: ".date("Y-m-d_H:i:s")."\t add_liuliang is ".$GLOBALS['add_liuliang']."\n");
    fwrite($handle, "TIME: ".date("Y-m-d_H:i:s")."\t transfer_enable is ".$GLOBALS['transfer_enable']."\n");
    

    
    $sql = sprintf("update %s set transfer_enable = %s where email = %s", TABLE_USER, $transfer_enable, $email);
		fwrite($handle, 'TIME: '.date("Y-m-d_H:i:s")."    sql is ".$sql."\n");
		$result = mysqli_query($user_db_conn, $sql);
	
		mysqli_free_result($result);
		mysqli_close($user_db_conn);
    
}else{
    fwrite($handle, "TIME: ".date("Y-m-d_H:i:s")."\t email ".$GLOBALS['email']." not exist\n");
    
    mysqli_free_result($result);
    mysqli_close($user_db_conn);
    
}


?>