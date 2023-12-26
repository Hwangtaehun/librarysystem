<!DOCTYPE html>
<html lang="ko">
    <head>
        <meta charset="utf-8">
        <title>Layout 연습</title>
        <link type="text/css" rel="stylesheet" href="../css/sjlayout.css">
    </head>
    <body>
        <?php include __DIR__.'/../templates/sj43header.html.php'; ?>
        <div id="content">
            <section id="main_section">
                <article class="main_article">
                    <h1>Main Article</h1>
                    <p>Web Page Layout 연습입니다.</p>
                </article>
                <article class="main_article">
                    <div class="form_class"><h1><?=$title?></h1></div>
                    <?=$outString?>
                </article>
            </section>
            <?php include __DIR__.'/../templates/sj43aside.html.php'; ?>
        </div>
        <?php include __DIR__.'/../templates/footer.html.php'; ?>
    </body>
</html>