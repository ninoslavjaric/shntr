DELIMITER ;;
create or replace procedure migrator()
begin
    set @migration_name = '1665650552';

    if (select count(1) from migrations where migration_name = @migration_name) = 0 then
        create table if not exists stripe_transactions
        (
            id int(10) unsigned primary key auto_increment,
            session_id varchar(255) not null unique,
            user_id int unsigned not null,
            qty float(10, 8),
            status longtext default 'PENDING',
            date timestamp not null default current_timestamp,
            foreign key (user_id) references users(user_id)
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
