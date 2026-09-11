<?php

namespace App\Models;

use PDO;

class Category extends Model
{
    protected $table = 'categories';

    public function findByPost($postId)
    {
        $query = "
select categories.*
from categories
join category_post on category_post.category_id = categories.id
where category_post.post_id = :postId
        ";

        $result = $this->connection->prepare($query);
        $result->bindValue('postId', $postId, PDO::PARAM_INT);
        $result->execute();

        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}