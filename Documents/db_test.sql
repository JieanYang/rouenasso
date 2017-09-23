create database if not exists rouenasso;

use rouenasso;

create table if not exists test(
	col1 varchar(255),
    col2 int(11),
    col3 bit(1)
);

insert into test values('item 1', 1234567890, 0);
insert into test values('item 2', 233333333, 1);