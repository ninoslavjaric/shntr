DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1664311696';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        CREATE TABLE `info_sell_token`
        (
            `id`                int(10) UNSIGNED  NOT NULL,
            `user_id`           int(10) UNSIGNED  NOT NULL,
            `user_name`         varchar(255)      NOT NULL,
            `name`              varchar(255)      NOT NULL,
            `user_email`        varchar(255)      NOT NULL,
            `address`           varchar(255)      NOT NULL,
            `country`           varchar(255)      NOT NULL,
            `sell_amount_token` int(255) UNSIGNED NOT NULL,
            `iban`              varchar(255)      NOT NULL,
            `state`             varchar(255)      NOT NULL,
            `post_time`         varchar(255)      NOT NULL
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4
          ROW_FORMAT = DYNAMIC;

        ALTER TABLE `info_sell_token`
            ADD PRIMARY KEY (`id`);

        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
