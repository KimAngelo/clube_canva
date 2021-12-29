<?php $this->layout('_theme', ["head" => $head]); ?>

<div class="row mt-10 align-items-center">
    <div class="col-md-6">
        <label class="color-theme font-weight-bolder font-size-h2 "><?= $name_pack ?></label>
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
    <?= $render ?>
<?php else: ?>
    <p>Nenhuma arte cadastrada neste pack</p>
<?php endif; ?>


<?php $this->start('scripts') ?>

<?php $this->end() ?>
