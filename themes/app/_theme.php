<!DOCTYPE html>
<html lang="pt-br">
<!--begin::Head-->
<head>
    <base href="<?= url() ?>">
    <meta charset="utf-8"/>

    <?= $head ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <?= css_version_control('style', CONF_VIEW_APP) ?>
    <?= css_version_control('css/custom', CONF_VIEW_APP) ?>

    <link rel="shortcut icon" href="<?= url("storage/images/site/icon-ico.ico"); ?>"/>

    <meta name="theme-color" content="#7C2AE8">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#7C2AE8">
    <meta name="msapplication-navbutton-color" content="#7C2AE8">

    <script>var BASE_SITE = '<?= url(); ?>';</script>
</head>
<?= $this->section("style") ?>
<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <div class="ajax_load_box_title">Aguarde, carregando!</div>
    </div>
</div>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-mobile-fixed aside-enabled aside-fixed page-loading">
<!--begin::Main-->
<!--begin::Header Mobile-->
<?= $this->insert('views/_header_mobile') ?>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        <?= $this->insert('views/_aside') ?>
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            <!--begin::Content-->
            <div class=" d-flex flex-column flex-column-fluid" id="kt_content">

                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">
                        <div class="row mt-8 mt-lg-10">
                            <div class="col-12">
                                <?= flash(); ?>
                                <div class="ajax_response"></div>
                            </div>
                        </div>
                        <?= $this->section('content') ?>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <?= $this->insert('views/_footer') ?>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>
<!--end::Main-->


<?php if (isset($categories_pop_up) && !empty($categories_pop_up)): ?>
    <div class="modal fade" id="modal_categories" tabindex="-1" role="dialog"
         aria-labelledby="staticBackdrop" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header pb-0 pr-2 pt-2 justify-content-end border-0">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i aria-hidden="true" class="ki ki-close"></i>
                    </button>
                </div>
                <div class="modal-body pt-1 pb-1">
                    <div class="row">
                        <?php foreach ($categories_pop_up as $category): ?>
                            <div class="col-6 col-md-4 col-lg-3 col-xl-2 mt-5">
                                <?= $this->insert('views/category', ['category' => $category]) ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?= js_version_control('scripts', CONF_VIEW_APP) ?>
<?= $this->section("scripts") ?>
<?php if (env('ONESIGNAL_ACTIVE', 'false') == "true"): ?>
    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function () {
            OneSignal.init({
                appId: "f7de0265-e9bf-4cb3-9e0d-1f92fc804680",
            });
        });
    </script>
<?php endif; ?>

</body>
<!--end::Body-->
</html>