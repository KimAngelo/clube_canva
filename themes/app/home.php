<?php $this->layout('_theme', ["head" => $head]); ?>

<?php if ($featured_categories): ?>
    <div class="row mt-lg-5">
        <div class="col-12 text-right mb-2">
            <a data-toggle="modal" data-target="#modal_categories" class="text-dark-75 font-weight-bold "
               href="<?= $router->route('app.categories') ?>"><i
                        class="fas fa-plus text-dark-75"></i> Mais categorias</a>
        </div>
        <div class="col-12">
            <div class="owl-carousel owl-theme">
                <?php foreach ($featured_categories as $category): ?>
                    <div class="item">
                        <?= $this->insert('views/category', ['category' => $category]) ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
<?php endif; ?>

<div class="row mt-10 align-items-center">
    <div class="col-md-6">
        <label class="color-theme font-weight-bolder font-size-h2">ÚLT. ATUALIZAÇÕES</label>
    </div>
    <div class="col-md-6 order-first order-md-last">
        <?= $this->insert('views/_search') ?>
    </div>
</div>

<?php if ($arts): ?>
    <div class="row arts">
        <?php foreach ($arts as $art): ?>
            <div class="col-md-3 col-6 mt-8">
                <?= $this->insert("views/art", ['art' => $art]) ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php $this->start('scripts') ?>
<script>
    $(document).ready(function () {
        $('.owl-carousel').owlCarousel({
            loop: true,
            margin: 10,
            center: true,
            stagePadding: 5,
            dots: false,
            nav: false,
            lazyLoad: true,
            animateIn: 'bounce',
            autoWidth: true,
            responsive: {
                0: {
                    items: 3,
                    margin: 10
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5,
                    dots: true
                }
            }
        })
    })
</script>
<?php $this->end() ?>
