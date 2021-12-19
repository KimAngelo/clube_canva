<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>
<?= css_version_control('plugins/custom/datatables/datatables.bundle', CONF_VIEW_ADMIN) ?>

<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Perguntas frequentes
                        </h3>
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <a data-toggle="modal" data-target="#create_faq"
                           class="btn btn-primary font-weight-bolder">
                            <i class="la la-plus"></i>Nova pergunta</a>
                        <!--end::Button-->
                    </div>

                </div>
                <div class="card-body mt-5">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <!--begin: Datatable-->
                    <?php if (!empty($faqs)): ?>
                        <table class="table table-separate table-head-custom table-checkable table-responsive-sm"
                               id="table_1">
                            <thead>
                            <tr>
                                <th>Título</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($faqs as $faq): ?>
                                <tr>
                                    <td><?= $faq->title ?></td>
                                    <td>
                                        <div class="btn-toolbar justify-content-between" role="toolbar"
                                             aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <button data-toggle="modal" data-target="#update_faq_<?= $faq->id ?>"
                                                        title="Editar"
                                                        class="btn btn-primary  btn-icon"><i
                                                            title="Editar" class="la la-file-text-o"></i></button>
                                                <button data-toggle="modal" data-target="#delete_faq_<?= $faq->id ?>"
                                                        type="button"
                                                        class="btn btn-danger btn-icon" title="Excluir">
                                                    <i class="la la-close"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>Nenhuma pergunta cadastrada</p>
                    <?php endif; ?>
                    <!--end: Datatable-->
                </div>
            </div>
        </div>
    </div>
<?php if (!empty($faqs)): foreach ($faqs as $faq): ?>
    <div class="modal fade" id="delete_faq_<?= $faq->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir pergunta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir essa pergunta?</p>
                    <form action="" class="form" method="post">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $faq->id ?>">
                        <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger font-weight-bold">Sim, excluir!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="update_faq_<?= $faq->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar pergunta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form" method="post">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?= $faq->id ?>">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Pergunta</label>
                                    <input value="<?= $faq->title ?>" required name="title" type="text"
                                           class="form-control" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-form__group">
                                    <label for="content">Resposta</label>
                                    <textarea
                                            class="form-control m-input description" id="content_<?= $faq->id ?>"
                                            name="description"
                                            rows="10"><?= $faq->description ?></textarea>
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

    <div class="modal fade" id="create_faq" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar pack</h5>
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
                                    <label>Pergunta</label>
                                    <input name="title" required type="text" class="form-control"
                                           placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-form__group">
                                    <label for="content">Resposta</label>
                                    <textarea class="form-control m-input description" name="description"
                                              rows="10"></textarea>
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
    <script src="<?= theme("assets/tinymce/tinymce.min.js", CONF_VIEW_ADMIN) ?>"></script>
    <script>
        loadTables("#table_1");

        tinyMCEload(".description");

    </script>
<?php $this->end() ?>