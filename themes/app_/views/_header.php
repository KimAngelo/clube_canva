<div id="kt_header" class="header flex-column header-fixed">
    <!--begin::Top-->
    <div class="header-top bg-theme">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Left-->
            <div class="d-none d-lg-flex align-items-center mr-3 w-100 justify-content-between">
                <!--begin::Logo-->
                <a href="<?= url() ?>" class="mr-15">
                    <img alt="<?= CONF_SITE_NAME ?>"
                         src="<?= url("/storage/images/site/Logo_Portal_Canva_80.png") ?>"
                         class="max-h-65px"/>
                </a>

                <!--end::Logo-->
                <!--begin::Desktop Search-->

                <!--end::Desktop Search-->

                <ul class="nav nav-pills ml-5">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->route('app.home') ?>">INICIO</a>
                    </li>
                    <?php if ($packs): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                               aria-haspopup="true" aria-expanded="false">PACKS</a>
                            <div class="dropdown-menu">
                                <?php foreach ($packs as $pack): ?>
                                    <a class="dropdown-item"
                                       href="<?= $router->route('app.pack', ['slug' => $pack->slug]) ?>"><?= $pack->name ?></a>
                                <?php endforeach; ?>
                            </div>
                        </li>
                    <?php endif; ?>
                    <li class="nav-item">
                        <a data-toggle="modal" data-target="#modal_categories" class="nav-link"
                           href="<?= $router->route('app.categories') ?>">CATEGORIAS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->route('app.tutorials') ?>">RECURSOS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $router->route('app.support') ?>">SUPORTE</a>
                    </li>
                </ul>
            </div>
            <!--end::Left-->
            <!--begin::Topbar-->
            <div class="topbar">

                <!--begin::Chat-->
                <div class="topbar-item mr-1">
                    <div class="btn btn-icon btn-hover-transparent-white btn-clean btn-lg"
                         data-toggle="tooltip" title="<?= user()->artBalance() ?> Artes disponíveis!">
                        <span class="label label-rounded <?= balance_arts_label() ?> font-weight-bold"><?= user()->artBalance() ?></span>
                    </div>
                </div>
                <!--end::Chat-->
                <!--begin::User-->
                <div class="topbar-item">
                    <div class="btn btn-icon btn-hover-transparent-white w-auto d-flex align-items-center btn-lg px-2"
                         id="kt_quick_user_toggle">
                        <div class="d-flex flex-column text-right pr-3">
                            <span class="text-white opacity-50 font-weight-bold font-size-sm d-none d-md-inline">Olá</span>
                            <span class="text-white font-weight-bolder font-size-sm d-none d-md-inline"><?= user()->first_name ?></span>
                        </div>
                        <span class="symbol symbol-35">
                            <span class="symbol-label font-size-h5 font-weight-bold text-white bg-white-o-30"><?= substr(ucwords(user()->first_name), 0, 1) ?></span>
                        </span>
                    </div>
                </div>
                <!--end::User-->
            </div>
            <!--end::Topbar-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Top-->
    <!--begin::Bottom-->
    <div class="header-bottom d-md-none">
        <!--begin::Container-->
        <div class="container">
            <!--begin::Header Menu Wrapper-->
            <div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
                <!--begin::Header Menu-->
                <div id="kt_header_menu"
                     class="header-menu header-menu-left header-menu-mobile header-menu-layout-default">
                    <!--begin::Header Nav-->
                    <ul class="menu-nav">
                        <li class="menu-item menu-item-here  menu-item-rel ">
                            <a href="<?= $router->route('app.home') ?>" class="menu-link">
                                Inicio
                            </a>
                        </li>
                        <?php if ($packs): ?>
                            <li class="menu-item menu-item-here menu-item-submenu menu-item-rel "
                                data-menu-toggle="hover" aria-haspopup="true">
                                <a href="javascript:;" class="menu-link menu-toggle">
                                    <span class="menu-text">Packs</span>
                                    <span class="menu-desc"></span>
                                    <i class="menu-arrow"></i>
                                </a>
                                <div class="menu-submenu menu-submenu-classic menu-submenu-left">
                                    <ul class="menu-subnav">
                                        <?php foreach ($packs as $pack): ?>
                                            <li class="menu-item" aria-haspopup="true">
                                                <a href="<?= $router->route('app.pack', ['slug' => $pack->slug]) ?>"
                                                   class="menu-link">
                                                    <span class="menu-text"><?= $pack->name ?></span>
                                                    <span class="menu-desc"></span>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </li>
                        <?php endif; ?>
                        <li class="menu-item menu-item-here  menu-item-rel ">
                            <a data-toggle="modal" data-target="#modal_categories"
                               href="<?= $router->route('app.categories') ?>" class="menu-link">
                                Categorias
                            </a>
                        </li>
                        <li class="menu-item menu-item-here  menu-item-rel ">
                            <a href="<?= $router->route('app.tutorials') ?>" class="menu-link">
                                Recursos
                            </a>
                        </li>
                        <li class="menu-item menu-item-here  menu-item-rel ">
                            <a href="<?= $router->route('app.support') ?>" class="menu-link">
                                Suporte
                            </a>
                        </li>

                    </ul>
                    <!--end::Header Nav-->
                </div>
                <!--end::Header Menu-->
            </div>
            <!--end::Header Menu Wrapper-->
        </div>
        <!--end::Container-->
    </div>
    <!--end::Bottom-->
</div>