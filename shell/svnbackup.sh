#!/bin/bash
#author: wangjiazhe
#date: 2015-01-09
dump="svnadmin dump"
rep=`ls -ap /data/svndata/ |grep '/'|grep -v '\./'|sed "s/\/$//"`  #取所有的版本库名
path=/data/svndata/  #svn目录
date=`date "+%Y%m%d"`  #当天时间
bakdir=/svn_backup/$date #备份目录
bak=/svn_backup/  
conf=$path/db_api/conf
######把所有的版本库导出到/svn_backup
mkdir -p $bakdir
for i in $rep;
do
   $dump $path/$i >$bakdir/$i  2>&1 
done
###########把备份数据打包并删除备份目录
if [ -d $bakdir ]
then
	cd $bak
	cp -r $conf ./$date/
	tar -zcvf svn_$date.tar.gz $date  1>/dev/null 
	rm -rf $date
fi

find $bak -mtime +1 -type f -name \*.tar.gz -exec rm -rf {} \;
