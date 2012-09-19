set DBUSER="root"
set DBPASS="devkhadka"
set DATABASENAME="agridata"

C:\xampp\mysql\bin\mysqladmin -u %DBUSER% -p%DBPASS% drop %DATABASENAME%
C:\xampp\mysql\bin\mysqladmin -u %DBUSER% -p%DBPASS% create %DATABASENAME%
C:\xampp\mysql\bin\mysql -u %DBUSER% -p%DBPASS% %DATABASENAME% < create-user.sql
C:\xampp\mysql\bin\mysql -u %DBUSER% -p%DBPASS% %DATABASENAME% < install.sql
