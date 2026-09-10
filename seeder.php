<?php

use Connections\Database;

require_once __DIR__ . '/autoload.php';

$pdo = Database::connection();

$pdo->exec('set foreign_key_checks = 0;');
$pdo->exec("truncate table `category_post`");
$pdo->exec("truncate table `categories`");
$pdo->exec("truncate table `posts`");
$pdo->exec('set foreign_key_checks = 1;');

$categoriesCount = 10;

$categoriesIds = [];

for ($i = 0; $i < $categoriesCount; $i++) {
    $categoryName = 'Category ' . time() . '-' . rand(100000, 999999);

    $pdo->prepare('insert into `categories` (`name`, `description`) values (:name, :description)')
        ->execute(['name' => $categoryName, 'description' => $categoryName . ' Description']);

    $lastInsertId = $pdo->lastInsertId();

    $newName = 'Category ' . $lastInsertId;

    $pdo->prepare('update `categories` set `name` = :name, `description` = :description where `id` = :id')
        ->execute([
            'name' => $newName,
            'description' => $newName . ' Description',
            'id' => $lastInsertId,
        ]);

    $categoriesIds[] = $lastInsertId;
}

$postsCount = 100;

for ($i = 0; $i < $postsCount; $i++) {
    $postName = 'Post ' . time() . '-' . rand(100000, 999999);

    $pdo->prepare('insert into `posts` (`name`, `description`, `text`) values (:name, :description, :text)')
        ->execute([
            'name' => $postName,
            'description' => $postName . ' Description',
            'text' => $postName . ' Text',
        ]);

    $postId = $pdo->lastInsertId();

    shuffle($categoriesIds);

    $associatedCategoriesKeys = array_rand($categoriesIds, rand(1, 4));

    if (!is_array($associatedCategoriesKeys)) {
        $associatedCategoriesKeys = [$associatedCategoriesKeys];
    }

    $associatedCategories = array_intersect_key(
        $categoriesIds,
        array_flip($associatedCategoriesKeys)
    );

    $newName = 'Post ' . $postId . ' for categories ' . implode(', ', $associatedCategories);

    $pdo->prepare('update `posts` set `name` = :name, `description` = :description, `text` = :text where `id` = :id')
        ->execute([
            'name' => $newName,
            'description' => $newName . ' Description',
            'text' => $newName . ' Text',
            'id' => $postId,
        ]);

    foreach ($associatedCategories as $categoryId) {
        $pdo->prepare('insert into `category_post` (`category_id`, `post_id`) values (:category_id, :post_id)')
            ->execute(['category_id' => $categoryId, 'post_id' => $postId]);
    }
}