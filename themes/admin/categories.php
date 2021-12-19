<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>
<?= css_version_control('plugins/custom/datatables/datatables.bundle', CONF_VIEW_ADMIN) ?>
<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Categorias
                        </h3>
                    </div>
                    <div class="card-toolbar">
                        <!--begin::Button-->
                        <a data-toggle="modal" data-target="#create_category"
                           class="btn btn-primary font-weight-bolder">
                            <i class="la la-plus"></i>Nova categoria</a>
                        <!--end::Button-->
                    </div>

                </div>

                <div class="card-body mt-5">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <?php if (!empty($categories)): ?>
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable table-responsive-sm"
                               id="table_1">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Categoria</th>
                                <th>Destaque</th>
                                <th>Qt artes</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody id="list_categories">
                            <?php foreach ($categories as $category): ?>
                                <tr data-id="<?= $category->id ?>">
                                    <td><?= $category->id ?></td>
                                    <td><?= $category->name ?></td>
                                    <td>
                                        <div class="form-group mb-0">
                                            <div class="checkbox-list">
                                                <label class="checkbox">
                                                    <input <?= $category->featured == 1 ? 'checked' : '' ?>
                                                            onchange="featured('<?= $category->id ?>')" type="checkbox"
                                                            name="Checkboxes1"/>
                                                    <span></span>
                                                </label>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $category->artsCount() ?></td>
                                    <td>
                                        <div class="btn-toolbar justify-content-between" role="toolbar"
                                             aria-label="Toolbar with button groups">
                                            <div class="btn-group" role="group" aria-label="First group">
                                                <button data-toggle="modal"
                                                        data-target="#update_category_<?= $category->id ?>"
                                                        title="Editar"
                                                        class="btn btn-primary  btn-icon"><i
                                                            title="Editar" class="la la-file-text-o"></i></button>
                                                <button type="button" class="btn btn-danger btn-icon"
                                                        data-toggle="modal"
                                                        data-target="#delete_category_<?= $category->id ?>"
                                                        title="Excluir">
                                                    <i class="la la-close"></i></button>
                                                <button type="button" class="btn btn-secondary btn-icon handle">
                                                    <i class="fas fa-arrows-alt"></i></button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    <?php else: ?>
                        <p>Nenhuma categoria cadastrada</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
<?php if (!empty($categories)): foreach ($categories as $category): ?>
    <div class="modal fade" id="delete_category_<?= $category->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir essa categoria?</p>
                    <form action="" method="post" class="form">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $category->id ?>">
                        <button type="button" class="btn btn-light font-weight-bold" data-dismiss="modal">Cancelar
                        </button>
                        <button type="submit" class="btn btn-danger font-weight-bold">Sim, excluir!</button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="update_category_<?= $category->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Editar categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form" method="post">
                        <input type="hidden" name="action" value="update">
                        <input type="hidden" name="id" value="<?= $category->id ?>">
                        <div class="row">

                            <div class="col-md-12 mb-3">
                                <label>Imagem de destaque <span
                                            class="label label-inline mr-2">Tamanho 200x120px</span></label>
                                </br>
                                <img src="<?= image($category->thumb, 200, 120, CONF_UPLOAD_IMAGE_DIR_CATEGORY) ?>"
                                     class="img_cover_<?= $category->id ?> img-thumbnail"
                                     style="max-width: 200px; min-height: 120px; min-width: 200px;">
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-form__group">
                                    <div></div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="cover"
                                               onchange="filePreview(this, '.img_cover_<?= $category->id ?>')"
                                               name="cover"
                                               accept="image/jpeg, image/png, image/jpg">
                                        <label class="custom-file-label" for="customFile">
                                            C: selecionar imagem
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nome da categoria</label>
                                    <input value="<?= $category->name ?>" name="name" required type="text"
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
    <div class="modal fade" id="create_category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar categoria</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="" class="form" method="post">
                        <input type="hidden" name="action" value="create">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label>Imagem de destaque <span
                                                    class="label label-inline mr-2">Tamanho 200x120px</span></label>
                                        </br>
                                        <img src="" class="img-cover img-thumbnail"
                                             style="max-width: 200px; min-height: 120px; min-width: 200px;">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group m-form__group">
                                            <div></div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="cover"
                                                       onchange="filePreview(this, '.img-cover')"
                                                       name="cover"
                                                       accept="image/jpeg, image/png, image/jpg">
                                                <label class="custom-file-label" for="customFile">
                                                    C: selecionar imagem
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Nome da categoria</label>
                                    <input name="name" type="text" class="form-control" placeholder="Digite aqui"/>
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
<?= js_version_control('js/SortableJS', CONF_VIEW_ADMIN) ?>
<?= js_version_control('js/JquerySortable', CONF_VIEW_ADMIN) ?>
<?= js_version_control('js/axios', CONF_VIEW_ADMIN) ?>

    <script>
        loadTables("#table_1");

        let list_categories = document.getElementById('list_categories');
        new Sortable(list_categories, {
            animation: 150,
            group: 'categories',
            handle: '.handle',
            store: {
                set: function (sortable) {
                    let order = sortable.toArray();
                    axios({
                        method: 'post',
                        url: BASE_SITE + '/panel/categorias',
                        data: {
                            array_key: order,
                            action: 'order'
                        }
                    });
                }
            }
        });

        function featured(id) {
            axios({
                method: 'post',
                url: BASE_SITE + '/panel/categorias',
                data: {
                    id: id,
                    action: 'featured'
                }
            });
        }
    </script>
<?php $this->end() ?>