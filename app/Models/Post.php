<?php

namespace App\Models;

use PDO;

class Post extends Model
{
    protected $table = 'posts';

    public function paginateCategoryPosts(int $categoryId, array $sort = [], int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;

        $query = "
from posts
join category_post on category_post.post_id = posts.id
where category_post.category_id = :categoryId
";

        if (array_key_exists('sort', $sort) && in_array($sort['sort'], ['published_at', 'views_count'])) {
            $query .= "order by posts.{$sort['sort']}";

            if (array_key_exists('dir', $sort) && in_array($sort['dir'], ['asc', 'desc'])) {
                $query .= " {$sort['dir']}";
            }
        }

        $result = $this->connection->prepare("select posts.* $query limit :offset, :perPage");
        $result->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $result->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $result->bindValue(':offset', $offset, PDO::PARAM_INT);
        $result->execute();

        $countResult = $this->connection->prepare("select count(distinct(posts.id)) as total $query");
        $countResult->bindValue(':categoryId', $categoryId, PDO::PARAM_INT);
        $countResult->execute();
        $totalItems = $countResult->fetch(PDO::FETCH_ASSOC)['total'];

        return [
            'data' => $result->fetchAll(PDO::FETCH_ASSOC),
            'pagination' => [
                'items' => $totalItems,
                'current' => $page,
                'pages' => $totalItems / $perPage,
            ]
        ];
    }

    public function similar(array $categories, int $excludeId, int $limit = 3): array
    {
        $placeholders = [];

        foreach ($categories as $index => $category) {
            $placeholders[] = ':category' . $index;
        }

        $query = "
select distinct posts.*
from posts
join category_post on category_post.post_id = posts.id
where category_post.category_id in (" . implode(', ', $placeholders) . ") and
    category_post.post_id != :excludeId
order by published_at desc
limit :limit
";

        $result = $this->connection->prepare($query);
        foreach ($categories as $index => $category) {
            $result->bindValue('category' . $index, $category, PDO::PARAM_INT);
        }
        $result->bindValue('excludeId', $excludeId, PDO::PARAM_INT);
        $result->bindValue('limit', $limit, PDO::PARAM_INT);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function viewed(int $id): void
    {
        $query = "update posts set views_count = views_count + 1 where id = :id";

        $result = $this->connection->prepare($query);
        $result->bindValue('id', $id, PDO::PARAM_INT);
        $result->execute();
    }
}