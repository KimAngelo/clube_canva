<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>


<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Adicionar tutorial</h3>
                    </div>

                </div>

                <div class="card-body">
                   <div class="ajax_response"></div>
                    <?= flash() ?>
                    <form class="form" action="" method="post">
                        <?= csrf_input() ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group m-form__group">
                                    <label><strong>Título</strong>*</label>
                                    <input type="text" class="form-control m-input" name="title"
                                           placeholder="Digite o título do tutorial">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group m-form__group">
                                    <label><strong>Descrição</strong></label>
                                    <textarea class="form-control m-input" name="description"
                                              placeholder="Escreva uma descrição..."
                                              rows="3"></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">

                                <div class="form-group m-form__group">
                                    <label><strong>Status</strong>*</label>
                                    <select class="form-control m-input" name="status">
                                        <option value="post">Ativo</option>
                                        <option value="draft">Rascunho</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label><strong>Imagem de destaque  <span class="label label-inline font-weight-lighter mr-2">Tamanho 320x240px</span></strong></label>
                                        </br>
                                        <img src="" class="img-cover img-thumbnail"
                                             style="max-width: 300px; min-height: 150px; min-width: 300px;">
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group m-form__group">
                                            <div></div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="cover"
                                                       name="cover[]"
                                                       accept="image/jpeg, image/png, image/jpg">
                                                <label class="custom-file-label" for="customFile">
                                                    C: selecionar imagem
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group m-form__group">
                                    <label for="content"><strong>Conteúdo</strong></label>
                                    <textarea class="form-control m-input" id="content" name="content"
                                              rows="10"></textarea>
                                </div>
                            </div>

                            <div class="col-md 12">
                                <button type="submit" class="btn btn-theme">Criar tutorial</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php $this->start('scripts') ?>
    <script src="<?= theme("assets/tinymce/tinymce.min.js", CONF_VIEW_ADMIN) ?>"></script>
    <script>
        $(document).ready(function () {
            $("#cover").change(function () {
                filePreview(this, ".img-cover");
            });
            tinyMCEload("#content");
        });


    </script>
<?php $this->end() ?>