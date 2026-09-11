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
    <nav>
        <a href="/">На главную</a>
    </nav>
</header>

<main>
    {block name="content"}{/block}
</main>

</body>
</html>