<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>
<?= css_version_control('plugins/custom/datatables/datatables.bundle', CONF_VIEW_ADMIN) ?>
<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Usuários
                        </h3>
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <a href="<?= $router->route('admin.createUser') ?>"
                           class="btn btn-primary font-weight-bolder">
                            <i class="la la-plus"></i>Novo usuário</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body mt-5">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <!--begin: Datatable-->
                    <?php if (!empty($users)): ?>
                        <table class="table table-separate table-head-custom table-checkable" id="table_1">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Plano</th>
                                <th>Dt. Assinatura</th>
                                <th>Status</th>
                                <th>Downloads</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?= $user->first_name . " " . $user->last_name ?></td>
                                    <td><?= $user->email ?></td>
                                    <td><?= $user->plan()->name ?></td>
                                    <td><?= date_fmt($user->created_at, 'd/m/Y H\hi') ?></td>
                                    <td>
                                        <?= status($user->status) ?>
                                    </td>
                                    <td><?= $user->countDown() ?></td>
                                    <td>
                                        <div class="btn-toolbar justify-content-between" role="toolbar"
                                             aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <a href="<?= $router->route('admin.updateUser', ['id' => $user->id]) ?>"
                                                   class="btn btn-primary  btn-icon"><i
                                                            title="Editar" class="la la-file-text-o"></i></a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    <?php endif; ?>
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