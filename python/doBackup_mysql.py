#####################################################
#author:wangjiazhe
#created time: 2015-01-20
#file name: doBackup_mysql.py
#use : 用于mysql数据恢复
#####################################################
#!/usr/sbin/python
import os,sys,tarfile
list=['db_lanmayi','db_mall','db_ucenter','db_ljmallim','db_tuan','db_webim']
mysql='mysql -uroot -p密码 -e '
path1='/data/work/mysql_backup/data/'
######找到相应的tar解压#######
def localdata(c):
    if os.path.exists(path1) :
        tar = tarfile.open(c)
        names = tar.getnames()
        for name in names:
            tar.extract(name,path=path1)
        tar.close()
    else:
        mkdir='mkdir -p '+path1
        os.system(mkdir)
        tar231=raw_input("Please enter a remote tar package.").strip()
        com='scp -P2211 spider@218.249.131.231:/backup/187-db/'
        localdir=' '+path1
        g=com+tar231+localdir
        os.system(g)
        tarpath=localdir+tar231
        tar = tarfile.open(tarpath)
        names = tar.getnames()
        for name in names:
            tar.extract(name,path=path1)
        tar.close()
        return
###################判断输入的内容############################
while True:
    print  "\033[36m1.please enter the date to resume.\n2.Restore one database.\n3.Restore one table.\n4.quit\033[0m"
    try:
        nu=int(raw_input("please select:"))
        if nu == 1 :
            while True:
                date=raw_input("please enter date(0000-00-00) :").strip()
                fil='find '+path1+date+'*'
                a=os.popen(fil)
                b=a.read()
                c=b.rstrip()
                if os.path.isfile(c):
                    localdata(c)
                    break
                else:
                    print "please enter a valid dtae."
        elif nu == 2 :
            #localdata()
            while True:
                dataname=raw_input("please enter database name or break:").strip()
                if dataname in list :
                    lsdir='ls -ap '+path1+"|grep '/'|grep -v '\./'"
                    tdir=os.popen(lsdir)
                    zdir=tdir.read()
                    dirl=zdir.strip('\n')
                    pathd=path1+dirl+dataname+'_'+dirl
                    ls='ls '
                    sqlall=ls+pathd
                    sql=os.popen(sqlall)
                    sqla=sql.readlines()
                    crbase=mysql+'"create database if not exists '+dataname+';'+'"'
                    os.system(crbase)
                    for i in sqla:
                        allsql='"use '+dataname+';'+'source '+path1+dirl+dataname+'_'+dirl+i+';"'
                        mysql1='mysql -uroot -p123456 -e '+allsql
                        os.system(mysql1)
                    break
                elif dataname == "break" :
                    break
                else:
                    print "please enter database name." 
        elif nu == 3 :
            #localdata()
            while True:
                dataname=raw_input("please enter database name or break:").strip()
                if dataname in list :
                    table=raw_input("please enter table name(*.sql):").strip()
                    lsdir='ls -ap '+path1+"|grep '/'|grep -v '\./'"
                    tdir=os.popen(lsdir)
                    zdir=tdir.read()
                    dirl=zdir.strip('\n')
                    crbase=mysql+'"create database if not exists '+dataname+';'+'"'
                    os.system(crbase)
                    data=dataname+'_'+dirl
                    mycomm=mysql+'"use '+dataname+';'+'source '+path1+dirl+data+table+';'+'"'
                    os.system(mycomm)
                    break
                elif dataname == "break" :
                    break
                else:
                    print "please database name."
        elif nu == 4 :
            rm='a='+'`ls -ap '+path1+"|grep '/'|grep -v '\./'`"+ ';for i in $a; do rm -rf '+path1+'$i; done'
            lsdir='ls -ap '+path1+"|grep '/'|grep -v '\./'"
            tdir=os.popen(lsdir)
            zdir=tdir.read()
            dirl=zdir.strip('\n')
            if dirl == '':
                pass
            else:
                os.system(rm)
            sys.exit()
        else:
            print "\033[31mplease enter anuber 1 or 2 or 3.\033[0m"
    except ValueError:  
         print "\033[31mPlease enter a number\033[0m"

