<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;

class CategoriesController extends Controller
{
    public function show($id): void
    {
        $category = (new Category)->find($id);

        $posts = (new Post)->paginateCategoryPosts(
            $id,
            [
                'sort' => $_GET['sort'] ?? 'published_at',
                'dir' => $_GET['dir'] ?? (isset($_GET['sort']) ? 'asc' : 'desc') ,
            ],
            $_GET['page'] ?? 1
        );

        $appendSort = [];

        $sort = [
            'sort' => $_GET['sort'] ?? '',
            'dir' => $_GET['dir'] ?? '',
        ];

        foreach ($sort as $key => $value) {
            if ($value) {
                $appendSort[] = "$key=$value";
            }
        }

        $appendSort = implode('&', $appendSort);

        $this->render(
            'category',
            compact('category', 'posts', 'sort', 'appendSort')
        );
    }
}