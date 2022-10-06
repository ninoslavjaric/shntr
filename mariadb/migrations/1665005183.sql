DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1665005183';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then

        alter table users add user_relysia_password varchar(255) default NULL null;

        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
