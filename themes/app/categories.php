<?php $this->layout('_theme', ["head" => $head]); ?>

<div class="row mt-lg-5 mt-10 align-items-center">
    <div class="col-md-6">
        <label class="color-theme font-weight-bold">CATEGORIAS</label>
    </div>
    <div class="col-md-6 order-first order-md-last">
        <?= $this->insert('views/_search') ?>
    </div>
</div>

<div class="row">
    <div class="col-6 col-md-2 mt-5">
        <?= $this->insert('views/category', ['name' => 'Academia', 'img' => 'https://www.designi.com.br/assets/img/categorias/academia.png']) ?>
    </div>

    <div class="col-6 col-md-2 mt-5">
        <?= $this->insert('views/category', ['name' => 'Açaí', 'img' => 'https://www.designi.com.br/assets/img/categorias/academia.png']) ?>
    </div>

    <div class="col-6 col-md-2 mt-5">
        <?= $this->insert('views/category', ['name' => 'Academia', 'img' => 'https://www.designi.com.br/assets/img/categorias/advocacia.png']) ?>
    </div>

    <div class="col-6 col-md-2 mt-5">
        <?= $this->insert('views/category', ['name' => 'Academia', 'img' => 'https://www.designi.com.br/assets/img/categorias/viagens.png']) ?>
    </div>

    <div class="col-6 col-md-2 mt-5">
        <?= $this->insert('views/category', ['name' => 'Academia', 'img' => 'https://www.designi.com.br/assets/img/categorias/auto-escola.png']) ?>
    </div>

    <div class="col-6 col-md-2 mt-5">
        <?= $this->insert('views/category', ['name' => 'Academia', 'img' => 'https://www.designi.com.br/assets/img/categorias/barbearia.png']) ?>
    </div>

    <div class="col-6 col-md-2 mt-5">
        <?= $this->insert('views/category', ['name' => 'Academia', 'img' => 'https://www.designi.com.br/assets/img/categorias/bares.png']) ?>
    </div>

    <div class="col-6 col-md-2 mt-5">
        <?= $this->insert('views/category', ['name' => 'Academia', 'img' => 'https://www.designi.com.br/assets/img/categorias/estetica.png']) ?>
    </div>
</div>


<?php $this->start('scripts') ?>

<?php $this->end() ?>
