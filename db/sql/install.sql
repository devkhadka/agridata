select "creating Tables";
source schema.sql

-- Select "Inserting All Data";
-- source data.sql

Select "Inserting Base Data";
source basedata.sql

Select "Inserting Master Data";
source masterdata.sql

Select "Inserting Test Data";
source testdata.sql

select "changing database tables to INNODB";
source engine.sql

select "Maintaining Constraints";
source constraints.sql