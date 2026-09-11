<?php

use App\Connections\Database;

require_once __DIR__ . '/vendor/autoload.php';

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

$now = new DateTimeImmutable();

for ($i = 0; $i < $postsCount; $i++) {
    $postName = 'Post ' . time() . '-' . rand(100000, 999999);

    $publishedAt = $now
        ->sub(new DateInterval('P' . rand(1,60) . 'DT' . rand(1,59) . 'H' . rand(1,59) . 'M'))
        ->format('Y-m-d H:i:s');

    $pdo->prepare('insert into `posts` (`name`, `description`, `text`, `image`, `published_at`) values (:name, :description, :text, :image, :published_at)')
        ->execute([
            'name' => $postName,
            'description' => $postName . ' Description Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed placerat eros nec velit consequat, sit amet bibendum arcu sagittis. Aliquam sed finibus tortor. Vestibulum ante ipsum primis in faucibus orci.',
            'text' => $postName . ' Text '
                . 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ut scelerisque ex, sed maximus mauris. Vestibulum accumsan elit purus, euismod ullamcorper mi varius a. Morbi non congue nisi. Morbi bibendum dolor sed tempus semper. Proin ullamcorper vitae enim non volutpat. Proin dignissim leo a lorem interdum, sed viverra ex egestas. Praesent commodo orci vel nunc volutpat rhoncus. Duis bibendum, lacus non suscipit malesuada, mauris dolor tempus diam, at malesuada nulla justo eget dui. Vivamus tempor eu diam nec auctor. Cras lacinia orci id arcu viverra sagittis. Nulla facilisi. Aenean faucibus lectus massa, vel fermentum magna pulvinar nec. Nunc lobortis dolor in sem posuere, tempus elementum purus efficitur. Nulla condimentum massa sit amet erat laoreet scelerisque.

Cras ut vehicula risus. Suspendisse ut sem consectetur, elementum nibh sit amet, tincidunt ipsum. Donec vitae scelerisque tellus. Fusce ac vehicula tortor. Sed rutrum feugiat facilisis. Etiam sed mauris eu erat blandit iaculis ut id nisl. Vivamus eu ultricies mi, et fermentum nibh. Nulla faucibus pretium nulla, in tempor massa facilisis et. Curabitur varius at dui nec dapibus. Integer bibendum porta risus sed fringilla. Morbi placerat sapien nisl, sed ullamcorper lorem laoreet at. Fusce lobortis est ac sem cursus, id blandit lectus aliquam. Etiam rhoncus a quam vitae aliquam. Morbi convallis sollicitudin cursus.

Donec imperdiet ipsum a turpis tempus sollicitudin et ac ante. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Etiam nisl urna, dignissim nec sem at, commodo rutrum leo. Nam efficitur, eros ut gravida varius, velit urna tempor erat, sit amet maximus lorem nulla ut turpis. Morbi convallis purus diam, non iaculis nibh placerat a. Sed nisi lectus, gravida ut imperdiet sed, efficitur sed orci. Nullam vestibulum, dui vitae tempor sollicitudin, nibh tellus scelerisque sapien, eget ultricies libero leo fringilla nibh. Etiam iaculis nisl at feugiat aliquam. Fusce ultricies diam tempor risus congue mollis. Nullam euismod, nunc vitae sodales lacinia, lectus lacus scelerisque ex, sit amet volutpat nisl diam a est.

Nam at velit lorem. Ut vel nibh sed mauris tincidunt bibendum. Phasellus congue elit sit amet consectetur ornare. Donec condimentum arcu id iaculis tincidunt. Morbi vel ultricies augue. Fusce orci felis, porttitor id nisl sed, aliquam fringilla lacus. Nunc in nibh vitae tortor volutpat pretium vitae non turpis. Curabitur aliquam nisi orci, eget lacinia ligula ullamcorper vel. Mauris pulvinar blandit ex.

Morbi non sollicitudin erat. Fusce non eleifend augue, nec bibendum quam. Donec tristique tortor ipsum, a pellentesque nibh lacinia eget. Pellentesque elementum, elit quis volutpat euismod, massa velit suscipit elit, accumsan luctus felis libero at lorem. Sed nibh dui, consequat in libero in, ultrices lobortis dui. Vestibulum eu sollicitudin massa, sed egestas enim. Suspendisse eget sodales enim, eget convallis velit. Pellentesque dapibus nulla id turpis placerat elementum. Nullam et elit interdum, venenatis dui sit amet, convallis arcu. Sed pellentesque pharetra justo sed dapibus. Phasellus vitae ante vitae velit tincidunt rhoncus.',
            'image' => 'https://picsum.photos/1100/600',
            'published_at' => $publishedAt,
        ]);

    $postId = $pdo->lastInsertId();

    shuffle($categoriesIds);

    $associatedCategoriesKeys = array_rand($categoriesIds, rand(1, 2));

    if (!is_array($associatedCategoriesKeys)) {
        $associatedCategoriesKeys = [$associatedCategoriesKeys];
    }

    $associatedCategories = array_intersect_key(
        $categoriesIds,
        array_flip($associatedCategoriesKeys)
    );

    /*$newName = 'Post ' . $postId . ' published at ' .  $publishedAt . ' for categories ' . implode(', ', $associatedCategories);// . ' viewsCount ' . $viewsCount;

    $pdo->prepare('update `posts` set `name` = :name, `description` = :description, `text` = :text where `id` = :id')
        ->execute([
            'name' => $newName,
            'description' => $newName . ' Description',
            'text' => $newName . ' Text',
            'id' => $postId,
        ]);*/

    foreach ($associatedCategories as $categoryId) {
        $pdo->prepare('insert into `category_post` (`category_id`, `post_id`) values (:category_id, :post_id)')
            ->execute(['category_id' => $categoryId, 'post_id' => $postId]);
    }
}