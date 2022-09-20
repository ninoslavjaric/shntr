DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1663679243';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        alter table posts_files add column file_title varchar(255) after post_id;
        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
