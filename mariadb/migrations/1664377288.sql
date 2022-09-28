DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1664377288';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        ALTER TABLE `info_sell_token`
            MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
