DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1666983198';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        alter table users add user_relysia_username varchar(255) null after user_religion;
        update users set user_relysia_username = user_name where user_relysia_username is null;

        CREATE OR REPLACE TABLE `users_relysia_transactions`
        (
            `user_id`        int(10) zerofill,
            `to`             varchar(255)   DEFAULT NULL,
            `txId`           varchar(255)   DEFAULT NULL,
            `from`           varchar(255)   DEFAULT NULL,
            `timestamp`      timestamp NULL DEFAULT NULL,
            `balance_change` double         DEFAULT NULL,
            `docId`          varchar(255)   DEFAULT NULL,
            `notes`          varchar(255)   DEFAULT NULL,
            `type`           varchar(255)   DEFAULT NULL,
            `protocol`       varchar(255)   DEFAULT NULL,
            index (`timestamp`)
        ) ENGINE = InnoDB
          DEFAULT CHARSET = utf8mb4;

        alter table users_relysia add transaction_in_progress tinyint default 0 not null;
        alter table users_relysia modify user_name varchar(255) null;


        create temporary table rel_tmp like users_relysia;
        insert into rel_tmp select * from users_relysia;
        truncate table users_relysia;
        alter table users_relysia add user_id int zerofill unique not null first;
        insert into users_relysia select users.user_id, rel_tmp.* from rel_tmp inner join users using(user_name);

        alter table users_relysia modify access_token_expiration_date datetime default NOW() not null;

        insert into migrations values (@migration_name);
        select concat('Migration ', @migration_name, ' executed.') as message;
    else
        select concat('Migration ', @migration_name, ' already executed.') as message;
    end if;

end ;;
delimiter ;

call migrator();

drop procedure if exists migrator;
