<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Post;

class PostsController extends Controller
{
    public function show($id)
    {
        (new Post)->viewed($id);

        $post = (new Post)->find($id);

//        $postCategories = (new CategoryPost)->findWhere(['post_id' => $id]);
        $postCategories = (new Category)->findByPost($id);

        $categories = array_map(fn ($row) => $row['id'], $postCategories);

        $similarPosts = (new Post)->similar($categories, $post['id']);

        $this->render(
            'post',
            compact('post', 'postCategories', 'similarPosts')
        );
    }
}