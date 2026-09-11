<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>
        {block name="title"}My website{/block}
    </title>

    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header>
    <div class="container">
        <nav>
            <a href="/">На главную</a>
        </nav>
    </div>
</header>

<main>
    <div class="container">
        {block name="content"}{/block}
    </div>
</main>

</body>
</html>