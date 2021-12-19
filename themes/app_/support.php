<?php $v->layout('_theme'); ?>

<div class="row px-lg-48">
    <div class="col-12 mt-8 text-center">
        <h2 class="font-weight-bolder"><?= $dynamic_fields->title_of_call ?></h2>
    </div>
    <div class="col-12 mt-8 text-center">
        <div class="tutorial">
            <?= $dynamic_fields->video_html ?>
        </div>
    </div>
    <?php if (!empty($faqs)): ?>
        <div class="col-12 mt-8 text-center">
            <h2 class="font-weight-bolder">Perguntas frequentes!</h2>
        </div>

        <div class="col-12">
            <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle"
                 id="accordionExample7">
                <?php foreach ($faqs as $faq): ?>
                    <div class="card bg-transparent">
                        <div class="card-header" id="headingThree7">
                            <div class="card-title collapsed" data-toggle="collapse" data-target="#collapse_<?= $faq->id ?>">
                            <span class="svg-icon svg-icon-theme">
                             <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                  version="1.1">
                              <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                               <polygon points="0 0 24 0 24 24 0 24"></polygon>
                               <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z"
                                     fill="#000000" fill-rule="nonzero"></path>
                               <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z"
                                     fill="#000000" fill-rule="nonzero" opacity="0.3"
                                     transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) "></path>
                              </g>
                             </svg>
                            </span>
                                <div class="card-label pl-4 text-left"><?= $faq->title ?></div>
                            </div>
                        </div>
                        <div id="collapse_<?= $faq->id ?>" class="collapse" data-parent="#accordionExample7">
                            <div class="card-body pl-12">
                                <?= $faq->description ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-12 mt-8 text-center">
        <h2 class="font-weight-bolder"><?= $dynamic_fields->notice_title ?></h2>
    </div>
</div>

<div class="row mt-10 mt-lg-5 px-lg-48">
    <div class="col-12">
        <div class="card card-custom gutter-b">
            <div class="card-body">
                <ul class="dashboard-tabs nav nav-pills nav-danger row row-paddingless m-0 p-0 flex-column flex-sm-row"
                    role="tablist">
                    <!--begin::Item-->
                    <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0 support">
                        <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center support-whatsapp "
                           target="_blank" href="https://api.whatsapp.com/send?phone=5585987281625&text=">
                            <span class="py-2 w-auto">
                                <i class="fab fa-whatsapp font-weight-bolder color-whatsapp"></i>
                            </span>
                            <span class="nav-text font-size-lg py-2 font-weight-bolder text-center color-whatsapp">Whatsapp</span>
                        </a>
                    </li>
                    <!--end::Item-->
                    <!--begin::Item-->
                    <li class="nav-item d-flex col-sm flex-grow-1 flex-shrink-0 mr-3 mb-3 mb-lg-0 support">
                        <a class="nav-link border py-10 d-flex flex-grow-1 rounded flex-column align-items-center support-email "
                           data-toggle="modal" data-target="#support-email" href="#">
                            <span class="nav-icon py-2 w-auto">
                                <span class="svg-icon svg-icon-3x">
                                   <i class="far fa-envelope font-weight-bolder color-theme"></i>
                                </span>
                            </span>
                            <span class="nav-text font-size-lg py-2 font-weight-bolder text-center color-theme">E-mail</span>
                        </a>
                    </li>
                    <!--end::Item-->
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="support-email" tabindex="-1" role="dialog"
     aria-labelledby="staticBackdrop" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Suporte por e-mail</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <form action="" method="post" class="form">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-1">
                                <label class="font-weight-bold">Mensagem</label>
                                <textarea minlength="10" name="message"
                                          placeholder="Digite aqui a mensagem para o suporte"
                                          class="form-control" id="exampleTextarea" rows="5"></textarea>
                            </div>
                            <button type="submit" class="btn btn-theme font-weight-bold mt-2">Enviar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>