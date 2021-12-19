<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>

<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Meu perfil</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <form class="form" action="" method="post" autocomplete="off">
                        <input type="hidden" name="action" value="update">
                        <?= csrf_input() ?>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Nome</strong>*</label>
                                    <input value="<?= $user->first_name ?>" type="text" class="form-control m-input"
                                           name="first_name"
                                           placeholder="Digite aqui...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Sobrenome</strong>*</label>
                                    <input type="text" class="form-control m-input" name="last_name"
                                           value="<?= $user->last_name ?>"
                                           placeholder="Digite aqui...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>E-mail</strong>*</label>
                                    <input value="<?= $user->email ?>" type="email" class="form-control m-input"
                                           disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Documento</strong></label>
                                    <input type="text" class="form-control m-input" name="document_number"
                                           value="<?= $user->document_number ?>"
                                           placeholder="Digite aqui...">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Telefone</strong></label>
                                    <input type="text" class="form-control m-input" name="phone"
                                           data-mask="(00) 00000-0000" value="<?= $user->phone ?>"
                                           placeholder="(00) 00000-0000">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group m-form__group">
                                    <label><strong>Endereço</strong></label>
                                    <input type="text" class="form-control m-input" name="address"
                                           value="<?= $user->address ?>" placeholder="Digite aqui">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Número</strong></label>
                                    <input type="text" class="form-control m-input" name="address_number"
                                           value="<?= $user->address_number ?>"
                                           placeholder="Digite aqui">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Bairro</strong></label>
                                    <input type="text" class="form-control m-input" name="neighborhood"
                                           placeholder="Digite aqui" value="<?= $user->neighborhood ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Estado</strong></label>
                                    <input type="text" class="form-control m-input" name="state"
                                           placeholder="Digite aqui" value="<?= $user->state ?>" maxlength="2">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Cidade</strong></label>
                                    <input type="text" class="form-control m-input" name="city"
                                           placeholder="Digite aqui" value="<?= $user->city ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>CEP</strong></label>
                                    <input type="text" class="form-control m-input" name="cep" data-mask="00000-000"
                                           placeholder="Digite aqui" value="<?= $user->cep ?>">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Senha</strong>*</label>
                                    <input type="password" class="form-control m-input" name="password" autocomplete="new-password"
                                           placeholder="Digite aqui" minlength="<?= CONF_PASSWD_MIN_LEN ?>"
                                           maxlength="<?= CONF_PASSWD_MAX_LEN ?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group m-form__group">
                                    <label><strong>Repetir senha</strong>*</label>
                                    <input type="password" class="form-control m-input" name="password_re"
                                           placeholder="Digite aqui" minlength="<?= CONF_PASSWD_MIN_LEN ?>"
                                           maxlength="<?= CONF_PASSWD_MAX_LEN ?>">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-theme">Atualizar dados</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php $this->start('scripts') ?>

<?php $this->end() ?>