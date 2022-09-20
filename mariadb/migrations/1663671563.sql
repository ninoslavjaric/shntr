DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name='1663671563';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        create or replace table paywalls
        (
            paywall_owner_id int unsigned not null,
            paywall_invader_id int unsigned not null,
            paywall_price bigint unsigned not null,
            primary key (paywall_owner_id, paywall_invader_id),
            foreign key (paywall_owner_id) references users(user_id),
            foreign key (paywall_invader_id) references users(user_id)
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
