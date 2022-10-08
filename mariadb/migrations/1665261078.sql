DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1665261078';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        drop table if exists prices;
        create table prices (
                                price_name varchar(255) unique,
                                price float(10, 2)
        );
        insert into prices values ('product_price', 100),('page_price', 100),('group_price', 100), ('event_price', 100);

        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
