<?php
include("./data/config.inc.php");
//���ύ��...
$posts = $_POST;
//���һЩ�հ׷���
foreach ($posts as $key => $value) {
    $posts[$key] = trim($value);
}

echo($db_host+$db_user+$db_pass);

mysql_connect($db_host,$db_user,$db_pass) //��дmysql�û���������  
   or die("abc"+mysql_error());    

mysql_select_db($db_name) or die("bcd"+mysql_error()); 

mysql_query('set names "gbk"'); //���ݿ������ݵı���  
$password =  mysql_real_escape_string($posts["password"]);
$username = mysql_real_escape_string($posts["username"]); 
$sql = "SELECT * FROM user WHERE password = password('$password') AND username = '$username'";
//  ȡ�ò�ѯ���
$result = mysql_query($sql) or die ("wrong"); 
$userInfo = mysql_fetch_array($result); 

if (!empty($userInfo)) {

if ($userInfo["username"] == $username) { 
    //  ����һ�����Ŀ¼
    $savePath = '../ss_save_dir/';
    //  ����һ��
    $lifeTime = 24 * 3600;
    //  ȡ�õ�ǰ Session ����Ĭ��Ϊ PHPSESSID
    $sessionName = session_name();
    //  ȡ�� Session ID
    $sessionID = $_GET[$sessionName];
    //  ʹ�� session_id() ���û�õ� Session ID
    session_id($sessionID); 
    session_set_cookie_params($lifeTime);
    //  ����֤ͨ�������� Session
    session_start();
    //  ע���½�ɹ��� admin ����������ֵ true
    $_SESSION["admin"] = true;
    $_SESSION["username"] = $username;
    $sn = session_id();
        echo("<meta http-equiv=refresh content='0; url=index.php?s=".$sn."'>"); 
} else { 
echo("�û����������code2,5�����ת����¼ҳ"); 

echo("<meta http-equiv=refresh content='5; url=login.php'>");

} 

} else {
    echo("�û����������code1,5�����ת����¼ҳ");

    echo("<meta http-equiv=refresh content='5; url=login.php'>");

}
?>
