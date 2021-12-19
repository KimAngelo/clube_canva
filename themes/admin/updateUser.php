<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>
<?= css_version_control('plugins/custom/datatables/datatables.bundle', CONF_VIEW_ADMIN) ?>
<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Editar usuário</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="ajax_response"></div>
                    <?= flash() ?>

                    <ul class="nav nav-tabs nav-tabs-line">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_tab_data">Dados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_tab_downloads">Downloads</a>
                        </li>

                    </ul>
                    <div class="tab-content mt-5" id="myTabContent">
                        <div class="tab-pane fade show active" id="kt_tab_data" role="tabpanel"
                             aria-labelledby="kt_tab_pane_2">

                            <form class="form" action="<?= $router->route('admin.users') ?>" method="post">
                                <input type="hidden" name="action" value="update">
                                <input type="hidden" name="id" value="<?= $user->id ?>">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Nome</strong>*</label>
                                            <input type="text" class="form-control m-input" name="first_name"
                                                   value="<?= $user->first_name ?>" placeholder="Digite aqui...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Sobrenome</strong>*</label>
                                            <input type="text" class="form-control m-input" name="last_name"
                                                   value="<?= $user->last_name ?>" placeholder="Digite aqui...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>E-mail</strong>*</label>
                                            <input type="email" class="form-control m-input" name="email"
                                                   value="<?= $user->email ?>" placeholder="Digite aqui...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Documento</strong></label>
                                            <input type="text" class="form-control m-input" name="document_number"
                                                   value="<?= $user->document_number ?>" placeholder="Digite aqui...">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Telefone</strong></label>
                                            <input type="text" class="form-control m-input" name="phone"
                                                   value="<?= $user->phone ?>" data-mask="(00) 00000-0000"
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
                                                   value="<?= $user->address_number ?>" placeholder="Digite aqui">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Bairro</strong></label>
                                            <input type="text" class="form-control m-input" name="neighborhood"
                                                   value="<?= $user->neighborhood ?>" placeholder="Digite aqui">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Estado</strong></label>
                                            <input type="text" class="form-control m-input" name="state"
                                                   value="<?= $user->state ?>" maxlength="2"
                                                   placeholder="Digite aqui">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Cidade</strong></label>
                                            <input type="text" class="form-control m-input" name="city"
                                                   value="<?= $user->city ?>" placeholder="Digite aqui">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>CEP</strong></label>
                                            <input type="text" class="form-control m-input" name="cep"
                                                   value="<?= $user->cep ?>" data-mask="00000-000"
                                                   placeholder="Digite aqui">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Status</strong>*</label>
                                            <select class="form-control m-input" name="status">
                                                <option <?= $user->status == "1" ? "selected" : "" ?> value="1">Ativo
                                                </option>
                                                <option <?= $user->status == "2" ? "selected" : "" ?> value="2">
                                                    Reembolsada
                                                </option>
                                                <option <?= $user->status == "3" ? "selected" : "" ?> value="3">
                                                    Cancelado
                                                </option>
                                                <option <?= $user->status == "4" ? "selected" : "" ?> value="4">
                                                    Bloqueado
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Plano</strong>*</label>
                                            <select class="form-control m-input" name="plan">
                                                <?php if ($plans): foreach ($plans as $plan): ?>
                                                    <option <?= $user->id_plan == $plan->id ? "selected" : "" ?>
                                                            value="<?= $plan->id ?>"><?= $plan->name ?></option>
                                                <?php endforeach; endif; ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Nivel de acesso</strong>*</label>
                                            <select class="form-control m-input" name="level">
                                                <option <?= $user->level == "1" ? "selected" : "" ?> value="1">Usuário
                                                </option>
                                                <option <?= $user->level == "5" ? "selected" : "" ?> value="5">
                                                    Administrador
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group m-form__group">
                                            <label><strong>Senha</strong>*</label>
                                            <input type="password" class="form-control m-input" name="password"
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
                                        <button type="submit" class="btn btn-theme">Salvar</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="tab-pane fade" id="kt_tab_downloads" role="tabpanel"
                             aria-labelledby="kt_tab_pane_2">
                            <table class="table table-separate table-head-custom table-checkable table-responsive-sm" id="table_1">
                                <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Link</th>
                                    <th>Data</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if ($history): foreach ($history as $item): ?>
                                    <tr>
                                        <td><?= $item->name ?></td>
                                        <td><a target="_blank"
                                               href="<?= $item->link_download ?>"><?= str_limit_chars($item->link_download, 50) ?></a>
                                        </td>
                                        <td><?= date_fmt($item->created_at, 'd/m/Y H\hi') ?></td>
                                    </tr>
                                <?php endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $this->start('scripts') ?>
<?= js_version_control('plugins/custom/datatables/datatables.bundle', CONF_VIEW_ADMIN) ?>
    <script>
        loadTables("#table_1");
    </script>
<?php $this->end() ?>