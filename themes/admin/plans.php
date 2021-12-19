<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>
<?= css_version_control('plugins/custom/datatables/datatables.bundle', CONF_VIEW_ADMIN) ?>
<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Planos
                        </h3>
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <a data-toggle="modal" data-target="#create_plan"
                           class="btn btn-primary font-weight-bolder">
                            <i class="la la-plus"></i>Novo plano</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body mt-5">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <?php if (!empty($plans)): ?>
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable table-responsive-sm" id="table_1">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome do plano</th>
                                <th>Limite diário</th>
                                <th>Qt usuários</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($plans as $plan): ?>
                                <tr>
                                    <td><?= $plan->id ?></td>
                                    <td><?= $plan->name ?></td>
                                    <td><?= $plan->limit_day ?></td>
                                    <td><?= $plan->userCount() ?></td>
                                    <td>
                                        <div class="btn-toolbar justify-content-between" role="toolbar"
                                             aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <button data-toggle="modal" data-target="#update_plan_<?= $plan->id ?>"
                                                        title="Editar"
                                                        class="btn btn-primary  btn-icon"><i
                                                            title="Editar" class="la la-file-text-o"></i>
                                                </button>
                                                <?php if ($plan->userCount() == 0): ?>
                                                    <button type="button" class="btn btn-danger btn-icon"
                                                            data-toggle="modal"
                                                            data-target="#delete_plan_<?= $plan->id ?>"
                                                            title="Excluir">
                                                        <i class="la la-close"></i>
                                                    </button>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    <?php else: ?>
                        <p>Nenhum plano cadastrado</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php if (!empty($plans)): foreach ($plans as $plan): ?>
    <?php if ($plan->userCount() == 0): ?>
        <div class="modal fade" id="delete_plan_<?= $plan->id ?>" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Excluir Plano</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Tem certeza que deseja excluir esse plano?</p>
                        <form action="" method="post" class="form">
                            <input type="hidden" name="action" value="delete">
                            <input type="hidden" name="id" value="<?= $plan->id ?>">
                            <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancelar
                            </button>
                            <button type="submit" class="btn btn-danger font-weight-bold">Sim, excluir!</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>
    <div class="modal fade" id="update_plan_<?= $plan->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar Plano</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form" method="post">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?= $plan->id ?>">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nome do plano</label>
                                    <input value="<?= $plan->name ?>" required name="name" type="text"
                                           class="form-control" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Limite diário</label>
                                    <input required name="limit_day" value="<?= $plan->limit_day ?>" type="number"
                                           class="form-control" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Código da hotmart</label>
                                    <input required name="cod_hotmart" value="<?= $plan->cod_hotmart ?>" type="text"
                                           class="form-control" placeholder="Digite aqui"/>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-theme font-weight-bold">Salvar!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; endif; ?>

    <div class="modal fade" id="create_plan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar Plano</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form" method="post">
                        <input type="hidden" name="action" value="create">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nome do plano</label>
                                    <input name="name" type="text" class="form-control" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Limite diário</label>
                                    <input name="limit_day" type="number" class="form-control"
                                           placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Código da hotmart</label>
                                    <input name="cod_hotmart" type="text" class="form-control"
                                           placeholder="Digite aqui"/>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-theme font-weight-bold">Criar!</button>
                    </form>
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