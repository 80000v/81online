81online
=====================可供生产使用=======================

                 已知的bug都被修复
                 它应该是为生产做好准备
                 使用。
======================================================================
此项目是根据OpenVPN的前端用户管理平台。

它现在具有以下特点：

用户

1.1登录查看帐户状态，包括信息，如配额总量，配额使用和左配额。

1.2更改密码。

1.3查看安装说明。

联系

2.1登录查看所有用户和管理员。

2.2新增用户和管理员。

2.3删除用户和管理员。

2.4更改管理员密码。

去做

所有MySQL连接是通过使用PHP MySQL扩展的。今后，迫切需要移动到mysqli扩展来避免任何secruity问题。

该系统现在只有中国的版本。多语言支持被认为是后来添加的。

前端UI设计正在开发中。

新增用户自定义属性。

待续。

安装

你有你的服务器上先安装OpenVPN。它需要openvpn-auth-pam.so在OpenVPN的目录中。它可以发现在资源目录。对于Debian您可以使用下面的命令：

         cp /usr/lib/openvpn/openvpn-auth-pam.so /etc/openvpn/

   要安装PAM-MySQL需要。对于Debian，请使用以下命令进行安装：

         aptitude install libpam-dev libpam-mysql libmysql++-dev sasl2-bin
   
  此外，您还需要配置PAM-mysql的。添加以下两行中“/etc/pam.d/openvpn”。如果它不存在，只需要创建一个新的文件：
   
         auth optional pam_mysql.so user=openvpn passwd=PASSWORD host=localhost db=openvpn table=user usercolumn=username passwdcolumn=password where=active=1 crypt=2
         account required pam_mysql.so user=openvpn passwd=PASSWORD host=localhost db=openvpn table=user usercolumn=username passwdcolumn=password where=active=1 crypt=2
   
   请记住，根据更改数据库的用户，passwd文件，主机和数据库。
   
   Run

               saslauthd -a pam
   
   to start sasl authrization service.
   
   
   In your server.conf:
   
         Add   

               # user/pass auth from mysql
               plugin ./openvpn-auth-pam.so openvpn
               client-cert-not-required
               username-as-common-name
               
               # record in database
               script-security 2
               client-connect ./connect.sh
               client-disconnect ./disconnect.sh


   In your client.conf
   
          注释掉

               cert client.crt
               key client.key
   
         A添加

               auth-user-pass
               
   如果上面的代码的任何部分已经在你的配置文件，不只是添加它，但修改现有的配置上面。

从脚本目录复制connect.sh和disconnect.sh到安装的OpenVPN的目录。在/ etc / OpenVPN的为Debian。

用户运行OpenVPN的过程中需要对connect.sh和disconnect.sh执行权限。您需要更改connect.sh和disconnect.sh数据库连接信息
