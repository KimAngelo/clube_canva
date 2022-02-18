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
                        <table class="table table-separate table-head-custom table-checkable table-responsive-sm"
                               id="table_1">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome do plano</th>
                                <th>Limite diário</th>
                                <th>Gateway</th>
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
                                    <td><?= gateway($plan->gateway) ?></td>
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

                    <h3 class="mt-20 mb-10">Webhooks</h3>
                    <h5 class="font-italic">Hotmart 1.0 <a class="btn btn-xs btn-icon btn-light ml-3"
                                                           title="Ver vídeo de como fazer" target="_blank"
                                                           href="https://www.loom.com/share/6660d53d8e894a9d8dbad640f5404b85?sharedAppSource=personal_library"><i
                                    class="fas fa-video"></i></a></h5>
                    <ul>
                        <li>
                            <span class="font-weight-bold">Compra aprovada:</span> <?= $router->route('webhook.hotmart.approvedPurchase') ?>
                        </li>
                        <li>
                            <span class="font-weight-bold">Compra reembolsada:</span> <?= $router->route('webhook.hotmart.refundedPurchase') ?>
                        </li>
                        <li>
                            <span class="font-weight-bold">Assinatura cancelada:</span> <?= $router->route('webhook.hotmart.subscriptionCanceled') ?>
                        </li>
                        <li>
                            <span class="font-weight-bold">Troca de plano:</span> <?= $router->route('webhook.hotmart.changePlan') ?>
                        </li>
                    </ul>
                    <h5 class="font-italic">Hotmart 2.0 <a class="btn btn-xs btn-icon btn-light ml-3"
                                                           title="Ver vídeo de como fazer" target="_blank"
                                                           href="https://www.loom.com/share/aa492ee9c0c34c419629cdef02ee39bd?sharedAppSource=personal_library"><i
                                    class="fas fa-video"></i></a></h5>
                    <ul>
                        <li>
                            <span class="font-weight-bold">Todos eventos:</span> <?= $router->route('webhook.hotmart') ?>
                        </li>
                    </ul>
                    <h5 class="font-italic">Mercado Pago IPN <a class="btn btn-xs btn-icon btn-light ml-3"
                                                                title="Ver vídeo de como fazer" target="_blank"
                                                                href="https://www.loom.com/share/68ed75507cd9499daaa9ce1043aa6a37"><i
                                    class="fas fa-video"></i></a></h5>
                    <ul>
                        <li>
                            <span class="font-weight-bold">Todos eventos:</span> <?= $router->route('webhook.mercadopago') ?>
                        </li>
                    </ul>


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
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Nome do plano</label>
                                    <input value="<?= $plan->name ?>" name="name" type="text" class="form-control"
                                           placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Limite diário</label>
                                    <input name="limit_day" type="number" class="form-control"
                                           value="<?= $plan->limit_day ?>" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Cód. Referência</label>
                                    <input name="cod_reference" type="text" class="form-control"
                                           value="<?= $plan->cod_reference ?>" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleSelect1">Gateway</label>
                                    <select class="form-control" name="gateway">
                                        <option <?= $plan->gateway == "mercado_pago" ? "selected" : "" ?>
                                                value="mercado_pago">
                                            Mercado Pago
                                        </option>
                                        <option <?= $plan->gateway == "hotmart" ? "selected" : "" ?> value="hotmart">
                                            Hotmart
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleSelect1">Período</label>
                                    <select class="form-control" name="period">
                                        <option <?= $plan->period == "1year" ? "selected" : "" ?> value="1year">1 ano
                                        </option>
                                        <option <?= $plan->period == "6months" ? "selected" : "" ?> value="6months">6
                                            meses
                                        </option>
                                        <option <?= $plan->period == "3months" ? "selected" : "" ?> value="3months">3
                                            meses
                                        </option>
                                        <option <?= $plan->period == "1month" ? "selected" : "" ?> value="1month">1
                                            mes
                                        </option>
                                        <option <?= $plan->period == "100years" ? "selected" : "" ?> value="100years">
                                            100 anos
                                        </option>
                                    </select>
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
                            <div class="col-8">
                                <div class="form-group">
                                    <label>Nome do plano</label>
                                    <input name="name" type="text" class="form-control" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Limite diário</label>
                                    <input name="limit_day" type="number" class="form-control"
                                           placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Cód. Referência</label>
                                    <input name="cod_reference" type="text" class="form-control"
                                           placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleSelect1">Gateway</label>
                                    <select class="form-control" name="gateway">
                                        <option value="mercado_pago">Mercado Pago</option>
                                        <option value="hotmart">Hotmart</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="exampleSelect1">Período</label>
                                    <select class="form-control" name="period">
                                        <option value="1year">1 ano</option>
                                        <option value="6months">6 meses</option>
                                        <option value="3months">3 meses</option>
                                        <option value="1month">1 mes</option>
                                        <option value="100years">100 anos</option>
                                    </select>
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