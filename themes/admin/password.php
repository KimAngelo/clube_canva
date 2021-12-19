<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>


<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Alterar senha</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <form class="form" action="">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Senha</strong>*</label>
                                    <input type="password" class="form-control m-input" name="title"
                                           placeholder="Digite aqui" minlength="<?= CONF_PASSWD_MIN_LEN ?>" maxlength="<?= CONF_PASSWD_MAX_LEN ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Repetir senha</strong>*</label>
                                    <input type="password" class="form-control m-input" name="title"
                                           placeholder="Digite aqui" minlength="<?= CONF_PASSWD_MIN_LEN ?>" maxlength="<?= CONF_PASSWD_MAX_LEN ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>E-mail</strong></label>
                                    <input type="email" disabled class="form-control m-input" name="title">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-theme">Salvar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php $this->start('scripts') ?>

<?php $this->end() ?>