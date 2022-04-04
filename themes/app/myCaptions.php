<?php $this->layout('_theme', ["head" => $head]); ?>

<div class="row mt-lg-5">
    <div class="col-12">
        <div class="card card-custom">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">Minhas legendas</h3>
                </div>
                <div class="card-toolbar">
                    <a href="<?= $router->route('app.new.caption') ?>" class="btn btn-sm btn-theme font-weight-bold">
                        <i class="far fa-comment-dots text-white"></i> Nova legenda
                    </a>
                </div>
            </div>
            <div class="card-body">
                <?php if (!empty($captions)): ?>
                    <div class="row">
                        <?php foreach ($captions as $caption): ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="text-right w-100"><small><?= date_fmt($caption->created_at) ?></small></label>
                                    <textarea id="caption_<?= $caption->id ?>" class="form-control" readonly
                                              rows="15"><?= $caption->caption ?></textarea>
                                    <div class="text-center mt-2">
                                        <button data-clipboard-target="#caption_<?= $caption->id ?>"
                                                data-clipboard="true"
                                                data-toggle="tooltip" data-trigger="click" title="Copiado!"
                                                class="btn btn-theme-secondary btn-sm font-weight-bolder"><i
                                                    class="far fa-copy text-white"></i> COPIAR
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $this->start('scripts') ?>
<script>
    new ClipboardJS('[data-clipboard=true]');
</script>
<?php $this->end() ?>
