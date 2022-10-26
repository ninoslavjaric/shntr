DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1666783546';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        create table if not exists users_relysia
        (
            user_name varchar(255) unique not null,
            access_token varchar(1000) not null,
            access_token_expiration_date TIMESTAMP default CURRENT_TIMESTAMP not null
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
