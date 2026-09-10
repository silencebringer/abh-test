<?php

namespace Queries;

use Connections\Database;

class CategoriesWithLatestPostsQuery
{
    public function handle()
    {
        $query = "
select
    categories.id as category_id,
    categories.name as category_name,
    posts.id as post_id,
    posts.name as post_title
from categories
join (
    select
        category_post.category_id,
        posts.*,
        row_number() over (
            partition by category_post.category_id
            order by posts.id desc
        ) as rn
    from category_post
    join posts
        on posts.id = category_post.post_id
) as posts
    on posts.category_id = categories.id
    and posts.rn <= 3
order by
    categories.id,
    posts.id desc;";

        return Database::connection()->query($query);
    }
}