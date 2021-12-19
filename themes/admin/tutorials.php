<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>
<?= css_version_control('plugins/custom/datatables/datatables.bundle', CONF_VIEW_ADMIN) ?>
<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Tutoriais
                        </h3>
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <a href="<?= $router->route('admin.createTutorial') ?>"
                           class="btn btn-primary font-weight-bolder">
                            <i class="la la-plus"></i>Novo tutorial</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body mt-10">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <?php if ($tutorials): ?>
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable table-responsive-sm" id="table_1">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Título</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($tutorials as $tutorial): ?>
                                <tr>
                                    <td><?= $tutorial->id ?></td>
                                    <td><?= $tutorial->title ?></td>
                                    <td>
                                        <div class="btn-toolbar justify-content-between" role="toolbar"
                                             aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <a href="<?= $router->route('admin.updateTutorial', ['id' => $tutorial->id]) ?>"
                                                   class="btn btn-primary  btn-icon"><i
                                                            title="Editar" class="la la-file-text-o"></i></a>
                                                <button data-toggle="modal" data-target="#delete_tutorial_<?= $tutorial->id ?>" type="button" class="btn btn-danger btn-icon">
                                                    <i title="Excluir"
                                                       class="la la-close"></i>
                                                </button>
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

<?php if ($tutorials): foreach ($tutorials as $tutorial): ?>
    <div class="modal fade" id="delete_tutorial_<?= $tutorial->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Tutorial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir esse tutorial?</p>
                    <form action="" method="post" class="form">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $tutorial->id ?>">
                        <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger font-weight-bold">Sim, excluir!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
<?php endforeach; endif; ?>
<?php $this->start('scripts') ?>
<?= js_version_control('plugins/custom/datatables/datatables.bundle', CONF_VIEW_ADMIN) ?>
    <script>
        loadTables("#table_1");
    </script>
<?php $this->end() ?>