##################################################
#author: wangjiazhe
#created time: 2015-05-06
#file name: my_kill.sh
#use : 杀掉mysql sleep状态的进程
##################################################
#!/bin/sh
#取有多少个sleep进程
n=`/usr/bin/mysqladmin -uroot -p密码 processlist | grep -i sleep | wc -l`
if [ "$n" -gt 50 ]
  then
    /usr/bin/mysqladmin -uroot -pMBBhE8qg04 processlist | grep -i sleep|sed 's/|/ /g' >>/var/log/mysql/my_kill.log
#关闭sleep进程
  for i in `/usr/bin/mysqladmin -uroot -pMBBhE8qg04 processlist | grep -i sleep | awk '{print $2}'`
    do
        /usr/bin/mysqladmin -uroot -pMBBhE8qg04 kill $i
    done
fi

