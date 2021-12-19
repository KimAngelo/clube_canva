<div class="aside aside-left aside-fixed d-flex flex-column flex-row-auto" id="kt_aside">
    <!--begin::Brand-->
    <div class="brand flex-column-auto mb-7 mt-5" id="kt_brand">
        <!--begin::Logo-->
        <a href="<?= $router->route('app.home') ?>" class="brand-logo">
            <img alt="<?= CONF_SITE_NAME ?>" class="w-95px mt-5" src="<?= url("/storage/images/site/cc1080.png") ?>" />
        </a>
        <!--end::Logo-->

        <div class="btn btn-icon btn-hover-transparent-white btn-clean btn-lg mt-5"
             data-toggle="tooltip" title="<?= user()->artBalance() ?> Artes disponíveis!">
            <span class="label label-rounded <?= balance_arts_label() ?> font-weight-bold"><?= user()->artBalance() ?></span>
        </div>
    </div>
    <!--end::Brand-->
    <!--begin::Aside Menu-->
    <div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">
        <!--begin::Menu Container-->
        <div id="kt_aside_menu" class="aside-menu my-4" data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
            <!--begin::Menu Nav-->
            <ul class="menu-nav">
                <li class="menu-item menu-item-hover" aria-haspopup="true">
                    <a href="<?= $router->route('app.home') ?>" class="menu-link">
                        <i class="menu-icon fas fa-home"></i>
                        <span class="menu-text">INICIO</span>
                    </a>
                </li>
                <?php if ($packs): ?>
                    <li class="menu-item menu-item-submenu menu-item-hover" aria-haspopup="true" data-menu-toggle="hover">
                        <a href="javascript:;" class="menu-link menu-toggle">
                            <i class="menu-icon fas fa-box-open"></i>
                            <span class="menu-text">PACKS</span>
                            <i class="menu-arrow"></i>
                        </a>
                        <div class="menu-submenu">
                            <i class="menu-arrow"></i>
                            <ul class="menu-subnav">
                                <li class="menu-item menu-item-parent" aria-haspopup="true">
                                        <span class="menu-link">
                                            <span class="menu-text">PACKS</span>
                                        </span>
                                </li>
                                <?php foreach ($packs as $pack): ?>
                                    <li class="menu-item" aria-haspopup="true">
                                        <a href="<?= $router->route('app.pack', ['slug' => $pack->slug]) ?>" class="menu-link">
                                            <i class="menu-bullet menu-bullet-line">
                                                <span></span>
                                            </i>
                                            <span class="menu-text"><?= $pack->name ?></span>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="menu-item menu-item-hover" aria-haspopup="true">
                    <a href="#" data-toggle="modal" data-target="#modal_categories" class="menu-link">
                        <i class="menu-icon fas fa-cubes"></i>
                        <span class="menu-text">CATEGORIAS</span>
                    </a>
                </li>
                <li class="menu-item menu-item-hover" aria-haspopup="true">
                    <a href="<?= $router->route('app.tutorials') ?>" class="menu-link">
                        <i class="menu-icon fas fa-magic"></i>
                        <span class="menu-text">RECURSOS</span>
                    </a>
                </li>
                <li class="menu-item menu-item-hover" aria-haspopup="true">
                    <a href="<?= $router->route('app.support') ?>" class="menu-link">
                        <i class="menu-icon fas fa-question"></i>
                        <span class="menu-text">SUPORTE</span>
                    </a>
                </li>
                <li class="menu-item menu-item-hover" aria-haspopup="true">
                    <a href="<?= $router->route('auth.logout') ?>" class="menu-link">
                        <i class="menu-icon fas fa-sign-out-alt"></i>
                        <span class="menu-text">SAIR</span>
                    </a>
                </li>
            </ul>
            <!--end::Menu Nav-->
        </div>
        <!--end::Menu Container-->
    </div>
    <!--end::Aside Menu-->
</div>