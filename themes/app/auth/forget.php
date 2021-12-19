<?php $this->layout('auth/_theme', ["head" => $head]); ?>

<div class="login-signin">

    <form class="form" method="post">
        <?= csrf_input() ?>
        <div class="form-group mb-5">
            <label class="float-left text-white ml-4">Digite seu e-mail para recuperar o acesso:</label>
            <input class="form-control h-auto form-control-solid py-4 px-8" type="email" autofocus
                   placeholder="Digite seu email..." name="email"/>
        </div>
        <div class="form-group d-flex flex-wrap justify-content-end align-items-center">
            <a title="Acessar <?= CONF_SITE_NAME ?>" href="<?= $router->route('auth.login') ?>"
               class="text-muted text-hover-primary">Lembrei minha senha :)</a>
        </div>
        <div class="form-group">
            <button type="submit" title="Acessar <?= CONF_SITE_NAME ?>"
                    class="btn btn-theme-secondary btn-pill w-100 font-weight-bold px-9 py-4">Recuperar senha
            </button>
        </div>

    </form>

</div>
