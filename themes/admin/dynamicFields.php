<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>

<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Campos dinâmicos - <small>Suporte</small>
                        </h3>
                    </div>
                    <div class="card-toolbar">


                    </div>

                </div>
                <div class="card-body mt-5">
                    <div class="ajax_response"></div>
                    <?= flash() ?>

                    <form action="" method="post" class="form">
                        <input type="hidden" name="action" value="update">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Título de chamada</label>
                                    <input name="title_of_call" type="text" class="form-control"
                                           value="<?= $dynamic_fields->title_of_call ?>" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="exampleTextarea">Vídeo embed</label>
                                    <textarea name="video_html" class="form-control"
                                              rows="3"><?= $dynamic_fields->video_html ?></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Título de aviso</label>
                                    <input name="notice_title" type="text" class="form-control"
                                           value="<?= $dynamic_fields->notice_title ?>" placeholder="Digite aqui"/>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-theme">Salvar!</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>


<?php $this->start('scripts') ?>

<?php $this->end() ?>