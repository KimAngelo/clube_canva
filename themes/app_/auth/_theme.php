<!DOCTYPE html>

<html lang="pt-br">
<!--begin::Head-->
<head>
    <base href="<?= url() ?>">
    <meta charset="utf-8"/>
    <?= $head ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <link rel="shortcut icon" href="<?= url("storage/images/site/icon.ico"); ?>"/>

    <link href="<?= theme('assets/css/pages/login/classic/login-4.css', CONF_VIEW_APP) ?>" rel="stylesheet"
          type="text/css"/>
    <?= css_version_control('style', CONF_VIEW_APP) ?>
    <link href="<?= theme('assets/css/custom.css') ?>" rel="stylesheet" type="text/css"/>
    <link href="<?= theme('assets/css/auth.css') ?>" rel="stylesheet" type="text/css"/>

    <meta name="theme-color" content="#130036">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="#130036">
    <meta name="msapplication-navbutton-color" content="#130036">

    <script>var BASE_SITE = '<?= url(); ?>';</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body" class="header-fixed header-mobile-fixed header-bottom-enabled subheader-enabled page-loading">
<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <div class="ajax_load_box_title">Aguarde, carregando!</div>
    </div>
</div>
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Login-->
    <div class="login login-4 login-signin-on d-flex flex-row-fluid">
        <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat"
             style="background-image: url('<?= url('storage/images/site/bg-login.png') ?>');">
            <div class="login-form text-center p-7 position-relative overflow-hidden">
                <!--begin::Login Header-->
                <div class="d-flex flex-center mb-15">
                    <a href="#">
                        <img src="<?= url("/storage/images/site/Logo_Portal_Canva_430.png") ?>" class="w-75 max-h-200px"
                             alt="<?= CONF_SITE_NAME ?>"/>
                    </a>
                </div>
                <div class="ajax_response"></div>
                <?= flash() ?>
                <?= $v->section('content') ?>
            </div>
        </div>
    </div>
    <!--end::Login-->
</div>

<?= js_version_control('scripts', CONF_VIEW_APP) ?>
<?= $v->section("scripts") ?>
</body>
<!--end::Body-->
</html>