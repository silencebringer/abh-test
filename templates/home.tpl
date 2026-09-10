{if $categories}
{foreach $categories as $category}
<div>{$category.name}</div>

<ul>
    {foreach $category.posts as $post}
    <li>{$post.title}</li>
    {/foreach}
</ul>
{/foreach}
{else}
<div>There are no posts yet</div>
{/if}