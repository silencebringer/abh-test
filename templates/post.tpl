{extends file="layouts/app.tpl"}

{block name="content"}
    <h1>{$post.name}</h1>
    <div>
        Опубликовано {$post.published_at|date_format:"%d.%m.%Y"} в {$post.published_at|date_format:"%H:%M"}, в категори{$postCategories|count > 1 ? 'ях': 'и'}:
        {foreach from=$postCategories item=category key=index}
            <a href="/categories/show/{$category.id}">{$category.name}</a>
        {/foreach}
    </div>
    <div class="post-views-count">Количество просмотров: {$post.views_count}</div>

    <div>
        <img src="https://picsum.photos/1100/600" alt="">
    </div>

    <p class="post-description">{$post.description}</p>

    <div>{$post.text|nl2br}</div>

    {if $similarPosts|count}
        <h3>Похожие статьи</h3>

        <ul>
            {foreach from=$similarPosts item=post}
                <li>
                    <a href="/posts/show/{$post.id}">{$post.name}, published at {$post.published_at|date_format:"%m/%d/%Y %H:%M"}, viewed {$post.views_count} time{$post.views_count == 1 ? '' : 's'}</a>
                </li>
            {/foreach}
        </ul>
    {/if}
{/block}