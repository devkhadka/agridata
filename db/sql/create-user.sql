use agricare_nepal;
create user 'agricare_synsite'@'localhost' identified by '';
grant all privileges on agricare_nepal.* to 'agricare_synsite'@'localhost';
flush privileges;

