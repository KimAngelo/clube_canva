<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>
<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Artes
                        </h3>
                    </div>
                    <div class="card-toolbar">

                        <!--begin::Button-->
                        <a href="<?= $router->route('admin.createArt') ?>"
                           class="btn btn-primary font-weight-bolder">
                            <i class="la la-plus"></i>Nova arte</a>
                        <!--end::Button-->
                    </div>
                </div>
                <div class="card-body ">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <form action="" method="get">
                        <input type="hidden" name="filter" value="s">
                        <div class="row mb-20">
                            <div class="col-12">
                                <h3>Buscar
                                    <span class="svg-icon svg-icon-dark-50 svg-icon-2x"><!--begin::Svg Icon | path:C:\wamp64\www\keenthemes\themes\metronic\theme\html\demo1\dist/../src/media/svg/icons\General\Search.svg--><svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <rect x="0" y="0" width="24" height="24"/>
                                            <path d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                  fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                                            <path d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                  fill="#000000" fill-rule="nonzero"/>
                                        </g>
                                    </svg><!--end::Svg Icon-->
                                </span>
                                </h3>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input name="text" type="text" class="form-control"
                                           value="<?= isset($_GET['text']) ? $_GET['text'] : "" ?>"
                                           placeholder="Título ou descrição"/>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="pack" class="form-control">
                                        <option>Selecione um pack</option>
                                        <?php if ($packs): foreach ($packs as $pack): ?>
                                            <option <?= isset($_GET['pack']) && $_GET['pack'] == $pack->id ? "selected" : "" ?>
                                                    value="<?= $pack->id ?>"><?= $pack->name ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <select name="category" class="form-control">
                                        <option>Selecione uma categoria</option>
                                        <?php if ($categories): foreach ($categories as $category): ?>
                                            <option <?= isset($_GET['category']) && $_GET['category'] == $category->id ? "selected" : "" ?>
                                                    value="<?= $category->id ?>"><?= $category->name ?></option>
                                        <?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-theme-secondary w-100" type="submit">Buscar</button>
                            </div>
                        </div>
                    </form>

                    <?php if ($arts): ?>
                        <div class="row">
                            <?php foreach ($arts as $art): ?>
                                <div class="col-md-3 col-6 mb-3">
                                    <?= $this->insert('views/art_search', ["art" => $art]) ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <?= $render ?>
                    <?php else: ?>
                        <p>Nenhuma arte encontrada</p>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>

<?php if ($arts): foreach ($arts as $art): ?>
    <div class="modal fade" id="delete_art_<?= $art->id ?>" tabindex="-1" role="dialog"
         aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Excluir Arte</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza que deseja excluir essa arte?</p>
                    <form action="" method="post" class="form">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $art->id ?>">
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

<?php $this->end() ?>