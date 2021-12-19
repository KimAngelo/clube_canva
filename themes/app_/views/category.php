<a href="<?= $router->route("app.category", ["slug" => $category->slug]) ?>" title="<?= $category->name ?>">
    <div class="ach_page__badges__item">
        <img loading="lazy" width="100" src="<?= image($category->thumb, 200, 120, CONF_UPLOAD_IMAGE_DIR_CATEGORY) ?>"
             alt="">
        <p><?= $category->name ?></p>
    </div>
</a>