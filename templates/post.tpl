{extends file="layouts/app.tpl"}

{block name="content"}
    <h1>{$post.name}</h1>
    <div>
        Posted at {$post.published_at|date_format:"%m/%d/%Y %H:%M"} in categor{$postCategories|count > 1 ? 'ies': 'y'}:
        {foreach from=$postCategories item=category key=index}
            <a href="/categories/show/{$category.id}">{$category.name}</a>
        {/foreach}
    </div>
    <div>Viewed {$post.views_count} time{$post.views_count == 1 ? '' : 's'}</div>

    <p>{$post.description}</p>

    <div>{$post.text}</div>

    {if $similarPosts|count}
        <h3>Similar Posts</h3>

        <ul>
            {foreach from=$similarPosts item=post}
                <li>
                    <a href="/posts/show/{$post.id}">{$post.name}, published at {$post.published_at|date_format:"%m/%d/%Y %H:%M"}, viewed {$post.views_count} time{$post.views_count == 1 ? '' : 's'}</a>
                </li>
            {/foreach}
        </ul>
    {/if}
{/block}