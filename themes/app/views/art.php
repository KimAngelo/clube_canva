<a href="" data-toggle="modal" data-target="#modal_art_<?= $art->id ?>">
    <div class="art position-relative">
        <img class="w-100 rounded" loading="lazy"
             src="<?= image_glide($art->thumb, CONF_UPLOAD_IMAGE_DIR_ARTES, ['w' => 200, 'h' => 200]) ?>" alt="<?= $art->name ?>">
        <!--<div class="position-absolute tag d-flex flex-column-reverse align-items-end w-100">
            <span class="label label-inline">Feed</span>
        </div>-->
    </div>
</a>

<div class="modal fade" id="modal_art_<?= $art->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body p-5">
                <div class="row mb-2">
                    <div class="col-12">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <i aria-hidden="true" class="ki ki-close"></i>
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-center">
                        <img class="img-fluid w-400px"
                             src="<?= image_glide($art->thumb, CONF_UPLOAD_IMAGE_DIR_ARTES, ['w' => 300, 'h' => 300, 'fit' => 'fill']) ?>" alt="">
                    </div>

                    <div class="col-12 mt-3 text-center">
                        <a href="<?= $router->route('app.open.art', ['id' => $art->id]) ?>"
                           target="_blank"
                           class="btn btn-lg btn-theme-secondary w-100 w-md-400px font-weight-bold">ABRIR
                            NO CANVA</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>