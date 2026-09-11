{extends file="layouts/app.tpl"}

{block name="content"}
    <h1>{$category.name}</h1>
    <div>{$category.description}</div>

    <div>
        <a href="/categories/show/{$category.id}?sort=published_at{$sort.sort == 'published_at' && $sort.dir != 'desc' ? '&dir=desc' : ''}">Сортировать по Дате Публикации (по {$sort.sort != 'published_at' || ($sort.sort == 'published_at' && $sort.dir == 'desc') ? 'возрастанию' : 'убыванию'})</a>
        <a href="/categories/show/{$category.id}?sort=views_count{$sort.sort == 'views_count' && $sort.dir != 'desc' ? '&dir=desc' : ''}">Сортировать по количеству просмотров (по {$sort.sort != 'views_count' || ($sort.sort == 'views_count' && $sort.dir == 'desc') ? 'возрастанию' : 'убыванию'})</a>
    </div>

    <ol>
        {foreach $posts.data as $post}
            <li>
                <a href="/posts/show/{$post.id}">{$post.name}</a>
            </li>
        {/foreach}
    </ol>

    <div>
        {for $i = 1 to $posts.pagination.pages}
            <a href="/categories/show/{$category.id}{$i > 1 || $appendSort ? '?' : ''}{$appendSort}{$appendSort && $i > 1 ? '&' : ''}{$i > 1 ? "page=$i" : ''}">{$i}</a>
        {/for}
    </div>
{/block}