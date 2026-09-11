<?php

namespace Models;

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
}