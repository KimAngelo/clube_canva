<?php $this->layout('auth/_theme', ["head" => $head]); ?>

<div class="login-signin">

    <form class="form" method="post">
        <p class="text-light-white font-weight-light mb-10">
            Bem vindo(a) <?= user()->first_name ?>! Para começar, por segurança, altere a senha de acordo com a sua
            preferência ok 😀
        </p>
        <?= csrf_input() ?>

        <div class="form-group mb-5">
            <label class="float-left text-white ml-4">Nova senha</label>
            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                   placeholder="Digite sua senha..." name="password"/>
        </div>
        <div class="form-group mb-5">
            <label class="float-left text-white ml-4">Repetir senha</label>
            <input class="form-control h-auto form-control-solid py-4 px-8" type="password"
                   placeholder="Digite sua senha..." name="password_re"/>
        </div>

        <div class="form-group">
            <button type="submit" title="Próximo passo"
                    class="btn btn-theme-secondary btn-pill w-100 font-weight-bold px-9 py-4">Avançar <i
                        class="fas fa-arrow-right text-white"></i>
            </button>
        </div>

    </form>

</div>
