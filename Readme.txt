从git上pull下来之后，如果data/sqldata文件夹下有新的文件，说明数据库需要更新
登录admin管理界面，将“日期***.sql”文件的内容复制到“SQL查询”页面，点击“提交查询”
配件品牌和配件类型的关系数据，存在表ecs_brand2category中，通过一个MySQL的Trigger在ecs_goods被修改是进行操作。所以，如果如果未执行过data/sqldata下的Trigger_on_goods.sql或该文件有更新，则需要执行该文件。
且该文件无法在Admin界面中执行，因此需要通过"mysql -hlocalhost -uroot -ppassword testecs < Trigger_on_goods.sql"执行。