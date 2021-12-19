<a href="<?= $router->route("app.category", ["slug" => $category->slug]) ?>" title="<?= $category->name ?>">
    <div class="ach_page__badges__item">
        <img loading="lazy" width="100" src="<?= image_glide($category->thumb, CONF_UPLOAD_IMAGE_DIR_CATEGORY, ['w' => 200, 'h' => 120, 'fit' => 'fill', 'bg' => '#fffff']) ?>"
             alt="">
        <p><?= $category->name ?></p>
    </div>
</a>