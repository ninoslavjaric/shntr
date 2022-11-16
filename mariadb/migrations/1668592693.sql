DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1668592693';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then

        alter table token_transactions
            add recipient_relysia_paymail varchar(255) default null null;

        alter table token_transactions
            add is_completed boolean default false null;

        alter table token_transactions
            add count int default 0 null;

        UPDATE token_transactions SET is_completed = 1 where is_completed = 0;

        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
