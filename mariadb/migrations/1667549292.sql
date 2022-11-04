DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1667549292';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        CREATE OR REPLACE TABLE `php_sessions`
        (
            `session_id`      varchar(255) COLLATE utf8_unicode_ci NOT NULL,
            `session_expires` datetime                             NOT NULL,
            `session_data`    text COLLATE utf8_unicode_ci,
            PRIMARY KEY (`session_id`)
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
