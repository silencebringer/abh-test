<?php

return function (PDO $pdo): void {
    $pdo->exec("
        create table if not exists categories (
            id int unsigned auto_increment primary key,
            name varchar(255) not null unique,
            description text not null
        )
    ");
};