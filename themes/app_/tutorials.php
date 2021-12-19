<?php $v->layout('_theme'); ?>

<?php if ($tutorials): ?>
    <div class="row mt-10 mt-md-10 mt-lg-5">
        <?php foreach ($tutorials as $tutorial): ?>
            <div class="col-md-3 col-6">
                <div class="card card-custom gutter-b">
                    <div class="card-body p-0 rounded">
                        <a href="<?= $router->route('app.tutorial', ['slug' => $tutorial->slug]) ?>">
                            <img class="img-fluid w-100"
                                 src="<?= !empty($tutorial->cover) ? image($tutorial->cover, 320, 240, CONF_UPLOAD_IMAGE_DIR_BLOG) : "" ?>"
                                 loading="lazy" alt="<?= $tutorial->title ?>">
                            <div class="desc-tutorials p-4">
                                <h5 class="font-weight-bold"><?= str_limit_chars($tutorial->title, 20) ?></h5>
                                <p><?= str_limit_chars($tutorial->description, 30) ?></p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
<?php endif; ?>
<?= $render ?>