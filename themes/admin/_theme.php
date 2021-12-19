<!DOCTYPE html>
<html lang="pt-br">
<!--begin::Head-->
<head>
    <base href="">
    <meta charset="utf-8"/>
    <?= $head ?>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

    <?= css_version_control('style', CONF_VIEW_ADMIN) ?>
    <link href="<?= theme('assets/css/custom.css', CONF_VIEW_ADMIN) ?>" rel="stylesheet" type="text/css"/>

    <link rel="shortcut icon" href="<?= url("storage/images/site/icon-ico.ico"); ?>"/>

    <script>var BASE_SITE = '<?= url(); ?>';</script>
</head>
<!--end::Head-->
<!--begin::Body-->
<body id="kt_body"
      class="header-fixed header-mobile-fixed  aside-enabled aside-fixed aside-minimize-hoverable page-loading">

<?= $this->section("style") ?>
<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <div class="ajax_load_box_title">Aguarde, carregando!</div>
    </div>
</div>
<!--begin::Main-->
<!--begin::Header Mobile-->
<div id="kt_header_mobile" class="header-mobile align-items-center header-mobile-fixed h-60px">
    <!--begin::Logo-->
    <a href="<?= $router->route('admin.dash') ?>">
        <img class="w-150px" alt="Logo" src="<?= url("/storage/images/site/ccbranco.png") ?>"/>
    </a>
    <!--end::Logo-->
    <!--begin::Toolbar-->
    <div class="d-flex align-items-center">
        <!--begin::Aside Mobile Toggle-->
        <button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
            <span></span>
        </button>
        <!--end::Aside Mobile Toggle-->


    </div>
    <!--end::Toolbar-->
</div>
<!--end::Header Mobile-->
<div class="d-flex flex-column flex-root">
    <!--begin::Page-->
    <div class="d-flex flex-row flex-column-fluid page">
        <!--begin::Aside-->
        <div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
            <!--begin::Brand-->
            <div class="brand flex-column-auto mt-3 justify-content-center" id="kt_brand">
                <!--begin::Logo-->
                <a href="<?= $router->route('admin.dash') ?>" class="brand-logo mt-10">
                    <img alt="<?= CONF_SITE_NAME ?>" class="w-95px text-center"" src="<?= url("/storage/images/site/cc1080.png") ?>"/>
                </a>
                <!--end::Logo-->

            </div>
            <!--end::Brand-->
            <!--begin::Aside Menu-->
            <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
                <!--begin::Menu Container-->
                <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1"
                     data-menu-dropdown-timeout="500">
                    <!--begin::Menu Nav-->
                    <ul class="menu-nav">
                        <li class="menu-item" aria-haspopup="true">
                            <a href="<?= $router->route('admin.dash') ?>" class="menu-link">
                                <span class="menu-text">Inicio</span>
                            </a>
                        </li>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="menu-text">Artes</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                        <span class="menu-link">
                                            <span class="menu-text">Artes</span>
                                        </span>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.index') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Lote</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.createArt') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Adicionar</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.arts') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Todas</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-item" aria-haspopup="true">
                            <a href="<?= $router->route('admin.categories') ?>" class="menu-link">
                                <span class="menu-text">Categorias</span>
                            </a>
                        </li>
                        <li class="menu-item" aria-haspopup="true">
                            <a href="<?= $router->route('admin.packs') ?>" class="menu-link">
                                <span class="menu-text">Packs</span>
                            </a>
                        </li>
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="menu-text">Tutoriais</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                        <span class="menu-link">
                                            <span class="menu-text">Tutoriais</span>
                                        </span>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.createTutorial') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Adicionar</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.tutorials') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Todos</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="menu-text">Usuários</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                        <span class="menu-link">
                                            <span class="menu-text">Usuários</span>
                                        </span>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.createUser') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Adicionar</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.users') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Todos</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-item menu-item-submenu" aria-haspopup="true" data-menu-toggle="hover">
                            <a href="javascript:;" class="menu-link menu-toggle">
                                <span class="menu-text">Suporte</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="menu-submenu">
                                <i class="menu-arrow"></i>
                                <ul class="menu-subnav">
                                    <li class="menu-item menu-item-parent" aria-haspopup="true">
                                        <span class="menu-link">
                                            <span class="menu-text">Suporte</span>
                                        </span>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.faq') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Perguntas frequentes</span>
                                        </a>
                                    </li>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('admin.dynamic.fields') ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-dot">
                                                <span></span>
                                            </i>
                                            <span class="menu-text">Campos dinâmicos</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>

                        <li class="menu-item" aria-haspopup="true">
                            <a href="<?= $router->route('admin.plans') ?>" class="menu-link">
                                <span class="menu-text">Planos</span>
                            </a>
                        </li>
                    </ul>
                    <!--end::Menu Nav-->
                </div>
                <!--end::Menu Container-->
            </div>
            <!--end::Aside Menu-->
        </div>
        <!--end::Aside-->
        <!--begin::Wrapper-->
        <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

            <!--begin::Content-->
            <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

                <!--begin::Entry-->
                <div class="d-flex flex-column-fluid">
                    <!--begin::Container-->
                    <div class="container">
                        <?= $this->section('content') ?>
                    </div>
                    <!--end::Container-->
                </div>
                <!--end::Entry-->
            </div>
            <!--end::Content-->
            <!--begin::Footer-->
            <div class="footer bg-white py-4 d-flex flex-lg-column" id="kt_footer">
                <!--begin::Container-->
                <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
                    <!--begin::Copyright-->
                    <div class="text-dark order-2 order-md-1">
                        <span class="text-muted font-weight-bold mr-2">Desenvolvido por </span>
                        <a href="https://g7company.com.br/programador" target="_blank"
                           class="text-dark-75 text-hover-primary">G7 Company</a>
                    </div>
                    <!--end::Copyright-->
                    <!--begin::Nav-->
                    <div class="nav nav-dark">

                    </div>
                    <!--end::Nav-->
                </div>
                <!--end::Container-->
            </div>
            <!--end::Footer-->
        </div>
        <!--end::Wrapper-->
    </div>
    <!--end::Page-->
</div>

<?= js_version_control('scripts', CONF_VIEW_ADMIN) ?>
<?= $this->section("scripts") ?>
</body>
<!--end::Body-->
</html>