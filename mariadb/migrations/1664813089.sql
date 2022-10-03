DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1664813089';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        create table if not exists run_blocks
        (
            id int(10) unsigned primary key auto_increment,
            hash varchar(255) not null unique,
            value longtext not null,
            date timestamp not null default current_timestamp
        );

        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
