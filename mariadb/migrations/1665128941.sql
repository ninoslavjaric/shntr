DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1665128941';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        CREATE OR REPLACE TABLE `prices` (
                                  `id` int(10) UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
                                  `page` varchar(255) NOT NULL,
                                  `product` varchar(255) NOT NULL,
                                  `event` varchar(255) NOT NULL,
                                  `groups` varchar(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=DYNAMIC;
        INSERT INTO `prices` (`page`, `product`, `event`, `groups`) VALUES
        (100, 100, 100, 100);

        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
