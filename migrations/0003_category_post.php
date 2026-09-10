<?php

return function (PDO $pdo): void {
    $pdo->exec("
        create table if not exists `category_post` (
            `category_id` int unsigned not null,
            `post_id` int unsigned not null,
            primary key (`category_id`,`post_id`),
            constraint `category_id_foreign` foreign key (`category_id`) references `categories` (`id`),
            constraint `post_id_foreign` foreign key (`post_id`) references `posts` (`id`)
        )
    ");
};