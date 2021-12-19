<?php $this->layout('auth/_theme', ["head" => $head]); ?>

<div class="login-signin">

    <form class="form" method="post" action="<?= $router->route('auth.recover.post') ?>">
        <input type="hidden" name="code" value="<?= $code; ?>"/>
        <?= csrf_input() ?>
        <div class="form-group mb-5">
            <label class="float-left text-white ml-4">Nova senha</label>
            <input class="form-control h-auto form-control-solid py-4 px-8" type="password" autofocus
                   minlength="<?= CONF_PASSWD_MIN_LEN ?>" placeholder="Digite sua nova senha..." name="password"/>
        </div>
        <div class="form-group mb-5">
            <label class="float-left text-white ml-4">Repita sua senha</label>
            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                   minlength="<?= CONF_PASSWD_MIN_LEN ?>" placeholder="Digite sua nova senha..." name="password_re"/>
        </div>

        <div class="form-group">
            <button type="submit" title="Acessar <?= CONF_SITE_NAME ?>"
                    class="btn btn-theme-secondary btn-pill w-100 font-weight-bold px-9 py-4">Restaurar acesso
            </button>
        </div>

    </form>

</div>
