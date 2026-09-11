{extends file="layouts/app.tpl"}

{block name="content"}
    <h1>{$category.name}</h1>
    <div>{$category.description}</div>

    <div class="category-posts-sort">
        <span>Сортировать по: </span>
        <a href="/categories/show/{$category.id}?sort=published_at{$sort.sort == 'published_at' && $sort.dir != 'desc' ? '&dir=desc' : ''}">Дате Публикации (по {$sort.sort != 'published_at' || ($sort.sort == 'published_at' && $sort.dir == 'desc') ? 'возрастанию' : 'убыванию'})</a>
        <a href="/categories/show/{$category.id}?sort=views_count{$sort.sort == 'views_count' && $sort.dir != 'desc' ? '&dir=desc' : ''}">Количеству Просмотров (по {$sort.sort != 'views_count' || ($sort.sort == 'views_count' && $sort.dir == 'desc') ? 'возрастанию' : 'убыванию'})</a>
    </div>

    <ol>
        {foreach $posts.data as $post}
            <li>
                <a href="/posts/show/{$post.id}">{$post.name}, published at {$post.published_at|date_format:"%m/%d/%Y %H:%M"}, viewed {$post.views_count} time{$post.views_count == 1 ? '' : 's'}</a>
            </li>
        {/foreach}
    </ol>

    <div class="pagination">
        {for $i = 1 to $posts.pagination.pages}
            <a href="/categories/show/{$category.id}{$i > 1 || $appendSort ? '?' : ''}{$appendSort}{$appendSort && $i > 1 ? '&' : ''}{$i > 1 ? "page=$i" : ''}">{$i}</a>
        {/for}
    </div>
{/block}