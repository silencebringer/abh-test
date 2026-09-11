<?php

namespace App\Controllers;

use App\Queries\CategoriesWithLatestPostsQuery;
use PDO;

class HomeController extends Controller
{
    public function index(): void
    {
        $result = new CategoriesWithLatestPostsQuery()->handle();

        $data = [];

        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['category_id'];

            $data[$id] ??= [
                'id' => $id,
                'name' => $row['category_name'],
                'posts' => [],
            ];

            $data[$id]['posts'][] = [
                'id' => $row['post_id'],
                'name' => $row['post_name'],
                'published_at' => $row['post_published_at'],
                'views_count' => $row['post_views_count'],
            ];
        }

        $this->render('home', ['categories' => $data]);
    }
}