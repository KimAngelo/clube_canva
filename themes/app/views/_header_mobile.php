<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed">
    <!--begin::Logo-->
    <a href="<?= $router->route('app.home') ?>">
        <img alt="<?= CONF_SITE_NAME ?>" class="w-150px" src="<?= url("/storage/images/site/ccbranco.png") ?>" />
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <!--begin::Aside Mobile Toggle-->
        <div class="btn btn-icon btn-hover-transparent-white btn-clean btn-lg mr-3"
             data-toggle="tooltip" title="<?= user()->artBalance() ?> Artes disponíveis!">
            <span class="label label-rounded <?= balance_arts_label() ?> font-weight-bold"><?= user()->artBalance() ?></span>
        </div>
        <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
            <span></span>
        </button>
        <!--end::Aside Mobile Toggle-->

    </div>
    <!--end::Toolbar-->
</div>