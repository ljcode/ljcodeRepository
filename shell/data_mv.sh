#####################################################
#author: wangjiazhe
#created time: 2015-07-22
#file name:data_mv.sh 
#use : 把uc_members表中的数据导入mall_member表中
#####################################################
#!/bin/bash
#从uc_members表中模糊超找出username疑似是电话的 
mysql -uroot -p密码 -e "use db_ucenter; select uid,username from uc_members where username like '1%';"  >./uid_name.txt
#判断出电话号码
cat ./uid_name.txt |egrep [0-9]{11} >./iphon.txt
#从ecm_order表中查出Buyer_id和Payment_id不为0的
for i in `cat iphon.txt|awk '{print $1}'`
    do
       mysql -uroot -psvntest_mysql_224 -e "use db_mall; select Payment_id,Buyer_id,buyer_name from ecm_order where  Buyer_id=$i && Payment_id!='NUll';"  >>./nu.txt
    done
#更改数据

for i in `cat nu.txt|sed -n '/1/p'|awk '{print $3}'`
  do
   mysql -uroot -psvntest_mysql_224 -e "use db_mall; update mall_member set iphone=$i where nikename=$i; "
  done

#删除文件
sleep 5
rm -rf uid_name.txt iphon.txt

