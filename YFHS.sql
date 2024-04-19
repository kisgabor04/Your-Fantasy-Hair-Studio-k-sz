CREATE DATABASE IF NOT EXISTS users;
USE users;
CREATE TABLE IF NOT EXISTS datas (
    id int auto_increment PRIMARY KEY, 
    username varchar(50) NOT null, 
    password varchar(50) not null, 
    fullname varchar(50) not null, 
    hairdresser boolean not null);
INSERT INTO datas(username, password,fullname,hairdresser) VALUES('Józsi', '12345', 'Kis József',true);
INSERT INTO datas(username, password,fullname,hairdresser) VALUES('Béla', '12345', 'Tóth Béla',false);
CREATE TABLE IF NOT EXISTS idopontok ( 
    fullname varchar(50) not null,
    datum varchar(15) NOT null, 
    ido varchar(5) not null,
    szolgaltatas varchar(50) not null);
    

    INSERT INTO idopontok(fullname,datum,ido,szolgaltatas) VALUES('Tóth Béla','2024.05.29.','09:00','Festés');
