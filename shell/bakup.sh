#######################################################
#author: wangjiazhe
#created time: 2015-06-08
#file name:bakup.sh
#use : 打包备份dokuwiki数据
######################################################
#!/bin/bash
date=`date "+%Y%m%d"`  #当天时间
#############备份打包,放到备份目录里####################
cd /home/

tar -zcf $date.tar.gz ./dokuwiki 

mv $date.tar.gz /bakup_dokuwiki/
############保留15天数据#####################################
find /bakup_dokuwiki/ -mtime +15 -type f -name \*.tar.gz -exec rm -rf {} \;
