 DBUSER="root"
 DBPASS="devkhadka"
 DATABASENAME="agricare_nepal"

mysqladmin -u $DBUSER -p$DBPASS drop $DATABASENAME
mysqladmin -u $DBUSER -p$DBPASS create $DATABASENAME
mysql -u $DBUSER -p$DBPASS $DATABASENAME < create-user.sql
mysql -u $DBUSER -p$DBPASS $DATABASENAME < install.sql

