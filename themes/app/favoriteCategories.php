<?php $this->layout('_theme', ["head" => $head]); ?>

<div class="row mt-8 align-items-center">
    <div class="col-md-6">
        <label class="color-theme font-weight-bolder font-size-h2">Selecione suas categorias favoritas <i
                    class="fas fa-heart text-danger"></i></label>
    </div>
    <div class="col-md-6 order-first order-md-last">

    </div>
</div>

<?php if ($categories_pop_up): ?>
    <div class="row mb-5">
        <?php foreach ($categories_pop_up as $category): ?>
            <div class="col-6 col-md-2 mt-8">
                <div role="button" class="ach_page__badges__item categories_favorite w-100 h-100"
                     data-favorite="<?= $category->id ?>">
                    <img loading="lazy" width="200"
                         src="<?= image_glide($category->thumb, CONF_UPLOAD_IMAGE_DIR_CATEGORY, ['w' => 200, 'h' => 120, 'fit' => 'fill', 'bg' => '#fffff']) ?>"
                         alt="">
                    <p><?= $category->name ?></p>
                    <span role="button" class="">
                        <i class="fas fa-heart animate__animated <?= in_array($category->id, $favorite_categories) ? "text-danger" : "" ?>"></i>
                    </span>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<div class="row d-none d-md-block">
    <div class="col-12 text-center">
        <a href="<?= $router->route('app.home') ?>" title="Continuar"
           class="btn btn-lg btn-theme-secondary w-50 font-weight-bolder mt-8">
            CONTINUAR <i class="fas fa-arrow-right text-white"></i>
        </a>
    </div>
</div>

<a href="<?= $router->route('app.home') ?>" title="Continuar"
   class="btn btn-lg btn-square btn-theme-secondary w-100 font-weight-bolder fixed-bottom d-md-none">
    CONTINUAR <i class="fas fa-arrow-right text-white"></i>
</a>

<?php $this->start('scripts') ?>
<script>
    let categories = document.querySelectorAll('.categories_favorite');
    categories.forEach(function (category) {
        let id_category = category.getAttribute('data-favorite');
        category.addEventListener('click', () => {
            //const axios = require('axios');
            axios.post(BASE_SITE + '/categorias-favoritas', {
                action: 'add_favorite',
                id_category: id_category
            })
                .then(function (response) {
                    let icon_heart = category.querySelector('.fa-heart');
                    icon_heart.classList.toggle("text-danger");
                    icon_heart.classList.toggle("animate__pulse");
                })
                .catch(function (error) {
                    toastr.error('Ooops! Erro ao adicioanar favorito');
                    return false;
                });
        });
    });

</script>
<?php $this->end() ?>
