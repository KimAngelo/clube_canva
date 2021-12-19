<?php $this->layout('auth/_theme', ["head" => $head]); ?>

<div class="login-signin">

    <form class="form" method="post">
        <?= csrf_input() ?>
        <div class="form-group mb-5">
            <label class="float-left text-white ml-4">E-mail</label>
            <input class="form-control h-auto form-control-solid py-4 px-8" type="email" autofocus
                   placeholder="Digite seu email..." name="email"/>
        </div>
        <div class="form-group mb-5">
            <label class="float-left text-white ml-4">Senha</label>
            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                   placeholder="Digite sua senha..." name="password"/>
        </div>
        <div class="form-group d-flex flex-wrap justify-content-end align-items-center">
            <a title="Recuperar senha de acesso" href="<?= $router->route('auth.forget') ?>"
               class="text-muted text-hover-primary">Perdeu
                a senha?</a>
        </div>
        <div class="form-group">
            <button type="submit" title="Acessar <?= CONF_SITE_NAME ?>"
                    class="btn btn-theme-secondary btn-pill w-100 font-weight-bold px-9 py-4">Entrar
            </button>
        </div>

    </form>

</div>
