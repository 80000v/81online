<?php
include("./data/config.inc.php");
//  ��ֹȫ�ֱ�����ɰ�ȫ����
$admin = false;
session_id($_GET['s']);
session_start();
//  �ж��Ƿ��½
if (isset($_SESSION["admin"]) && $_SESSION["admin"] === true) {
    echo "";
} else {
    //  ��֤ʧ�ܣ��� $_SESSION["admin"] ��Ϊ false
    $_SESSION["admin"] = false;
    echo("��û�е�¼,����ת����¼ҳ");
    echo("<meta http-equiv=refresh content='2; url=login.php'>");
    die();
}

function check_input($value){
// Stripslashes
if (get_magic_quotes_gpc())  {  $value = stripslashes($value);  }
// Quote if not a number
if (!is_numeric($value))  {  $value = "'" . mysql_real_escape_string($value) . "'";  }
return $value;}

//  ���ύ��...
$posts = $_POST;
//  ���һЩ�հ׷���
foreach ($posts as $key => $value) {
    $posts[$key] = trim($value);
}
$username          =$_SESSION["username"];
mysql_connect($db_host,$db_user,$db_pass) //��дmysql�û���������  
   or die("Could not connect to MySQL server!");  
mysql_select_db($db_name) //���ݿ���  
   or die("Could not select database!");  
mysql_query('set names "gbk"'); //���ݿ������ݵı��� 
$oldpassword =  mysql_real_escape_string($posts["oldpassword"]);
$newpassword =  mysql_real_escape_string($posts["newpassword"]); 
$renewpassword =  mysql_real_escape_string($posts["renewpassword"]);
$sql = "SELECT * FROM user WHERE password = password('$oldpassword') AND username = '$username'";
$result = mysql_query($sql) or die ("wrong"); 
$userInfo = mysql_fetch_array($result); 

  if( $newpassword != $renewpassword){
    echo('��������������벻��ȷ,����������!����Ӧ��6-20λ֮�䡣����ת��ǰһҳ');
    echo("<meta http-equiv=refresh content='2; url=change.php'>");
  }else{   
   if(mysql_num_rows( mysql_query($sql) )==1 ){
    $sql="Update user set password=password('$newpassword') where username='$username'";
    mysql_query($sql) or die(mysql_error());
    echo('�����޸ĳɹ�!����ת����¼ҳ');
    echo("<meta http-equiv=refresh content='2; url=login.php'>");
   }else{
    echo('�����벻��ȷ,����������!����ת��ǰһҳ');
    echo("<meta http-equiv=refresh content='2; url=change.php'>");
   }
  }

 
?>