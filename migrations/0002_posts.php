<?php

return function (PDO $pdo): void {
    $pdo->exec("
        create table if not exists posts (
            id int unsigned auto_increment primary key,
            image varchar(255) null default null,
            name varchar(255) not null unique,
            description text not null,
            text text not null,
            views_count text not null
        )
    ");
};