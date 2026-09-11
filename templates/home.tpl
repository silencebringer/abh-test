{extends file="layouts/app.tpl"}

{block name="content"}
    {if $categories}
        {foreach $categories as $category}
            <h4>
                {$category.name}
            </h4>

            <ul>
                {foreach $category.posts as $post}
                    <li>
                        <a href="/posts/show/{$post.id}">{$post.name}, published at {$post.published_at|date_format:"%m/%d/%Y %H:%M"}, viewed {$post.views_count} time{$post.views_count == 1 ? '' : 's'}</a>
                    </li>
                {/foreach}
                <li><a href="/categories/show/{$category.id}">Все статьи</a></li>
            </ul>
        {/foreach}
    {else}
        <div>There are no posts yet</div>
    {/if}
{/block}