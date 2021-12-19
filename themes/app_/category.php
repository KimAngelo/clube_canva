<?php $v->layout('_theme'); ?>

<div class="row mt-10 align-items-center">
    <div class="col-md-6">
        <label class="color-theme font-weight-bold"><?= $name_category ?></label>
    </div>
    <div class="col-md-6 order-first order-md-last">
        <?= $v->insert('views/_search') ?>
    </div>
</div>

<?php if ($arts): ?>
    <div class="row arts">
        <?php foreach ($arts as $art): ?>
            <div class="col-md-3 col-6 mt-8">
                <?= $v->insert("views/art", ['art' => $art]) ?>
            </div>
        <?php endforeach; ?>
    </div>
    <?= $render ?>
<?php else: ?>
    <p>Nenhuma arte cadastrada na categoria</p>
<?php endif; ?>


<?php $v->start('scripts') ?>

<?php $v->end() ?>
