{extends file="layouts/app.tpl"}

{block name="content"}
        {if $categories}
            <div class="home-grid">
                {foreach $categories as $category}
                    <div class="category-card">
                        <h4>
                            {$category.name}
                            <span class="hint">| последние статьи</span>
                        </h4>

                        <ul>
                            {foreach $category.posts as $post}
                                <li>
                                    <a href="/posts/show/{$post.id}">{$post.name}, опубликовано {$post.published_at|date_format:"%d.%m.%Y"} в {$post.published_at|date_format:"%H:%M"}, количество просмотров: {$post.views_count}</a>
                                </li>
                            {/foreach}
                            <li><a href="/categories/show/{$category.id}">Все статьи</a></li>
                        </ul>
                    </div>
                {/foreach}
            </div>
        {else}
            <div>There are no posts yet</div>
        {/if}
    </div>
{/block}