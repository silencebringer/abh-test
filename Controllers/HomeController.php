<?php

namespace Controllers;

use PDO;
use Queries\CategoriesWithLatestPostsQuery;

class HomeController extends Controller
{
    public function index(): void
    {
        $result = (new CategoriesWithLatestPostsQuery())->handle();

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
                'title' => $row['post_title'],
            ];
        }

        $this->render('home', ['categories' => $data]);
    }
}