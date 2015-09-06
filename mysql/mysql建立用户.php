<?php
/**
 * MYSQL中新建用户流程,及一些其他对用户操作
 * 
 * @author sulong
 * @date:2015-1-6
 */

//1.用管理员账号登录MYSQL
	mysql -u root -p

//2.创建一个新用户,用户名username,密码password
	insert into mysql.user(Host,User,Password) values('localhost','username',password('password'));

//3.刷新系统权限表
	flush privileges;

//4.赋予权限
	//赋予全部数据库所有操作权限
	grant all privileges on *.* to username@localhost identified by 'password';
	//赋予abc数据库所有操作权限
	grant all privileges on abc.* to username@localhost identified by 'password';
	//赋予abc数据库查找更新的权限
	grant select,update on abc.* to username@localhost identified by 'password';

//5.刷新系统权限表
	flush privileges;
//end	新用户添加完成，权限设置完成


/*--MYSQL对用户的操作--*/
//查看当前用户和权限
USE mysql;
SELECT host,user,password FROM user;
	//像我的MSQL打印出来就是这样
	+----------------------+----------+-------------------------------------------+
	| host                 | user     | password                                  |
	+----------------------+----------+-------------------------------------------+
	| localhost            | root     |                                           |
	| production.mysql.com | root     |                                           |
	| 127.0.0.1            | root     |                                           |
	| localhost            |          |                                           |
	| production.mysql.com |          |                                           |
	| localhost            | common   | *C587C4B37DAF52B734BBDE1A3969207D6E61D329 |
	| %                    | root     | *81F5E21E35407D884A6CD4A731AEBFB6AF209E1B |
	| localhost            | username | *2470C0C06DEE42FD1618BB99005ADCA2EC9D1E19 |
	+----------------------+----------+-------------------------------------------+

//查看用户username权限
show grants for username@'localhost';
	+--------------------------------------------------------------------------------------------------------------------------+
	| Grants for username@localhost                                                                                            |
	+--------------------------------------------------------------------------------------------------------------------------+
	| GRANT ALL PRIVILEGES ON *.* TO 'username'@'localhost' IDENTIFIED BY PASSWORD '*6BB4837EB74329105EE4568DDA7DC67ED2CA2AD9' |
	+--------------------------------------------------------------------------------------------------------------------------+

//用户username修改密码为newpassword
update mysql.user set password=password('newpassword') where User="username" and Host="localhost";
flush privileges;


//删除用户username同时删除权限
USE mysql;
DELETE FROM user WHERE User='username' and Host='localhost';
flush privileges;


//删除用户username同时删除权限，mysql5之前删除用户时必须先使用revoke 删除用户权限
drop user username@'localhost';



