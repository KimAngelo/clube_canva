<div class="card">
    <img loading="lazy" class="card-img-top"
         src="<?= image_glide($art->thumb, CONF_UPLOAD_IMAGE_DIR_ARTES, ['w' => 300, 'h' => 300, 'fit' => 'fill']) ?>">
    <div class="card-body p-4">
        <h5 class="card-title mb-3"><?= $art->name ?></h5>
        <div class="d-flex justify-content-center align-items-center">
            <a href="<?= $router->route('admin.updateArt', ['id' => $art->id]) ?>"
               class="btn btn-theme btn-sm mr-1">Editar</a>
            <a data-toggle="modal" data-target="#delete_art_<?= $art->id ?>" href="#" class="btn btn-danger btn-sm">Excluir</a>
        </div>
    </div>
</div>