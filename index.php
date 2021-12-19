<?php
ob_start();

require "vendor/autoload.php";

use CoffeeCode\Router\Router;

date_default_timezone_set('America/Sao_Paulo');

//Inicio das rotas
$router = new Router(url(), ":");
$router->namespace("Source\Controller");

/**
 * APP
 */
$router->group(null);
$router->get("/", "App:home", "app.home");
$router->get("/buscar", "App:search", "app.search");
$router->get("/categoria/{slug}", "App:category", "app.category");
$router->get("/pack/{slug}", "App:pack", "app.pack");
$router->get("/tutoriais", "App:tutorials", "app.tutorials");
$router->get("/tutorial/{slug}", "App:tutorial", "app.tutorial");
$router->get("/categorias", "App:categories", "app.categories");
$router->get("/hoje", "App:today", "app.today");
$router->get("/abrir/{id}", "App:openArt", "app.open.art");
$router->get("/suporte", "App:support", "app.support");
$router->post("/suporte", "App:support", "app.support");

//Perfil
$router->get("/perfil", "App:profile", "app.profile");
$router->post("/perfil", "App:profile", "app.profile");

/**
 * IMAGE
 */
$router->group(null);
$router->get('/img/{name_img}', "Image:img", "img");

/**
 * AUTH
 */
$router->namespace("Source\Controller");
$router->group(null);
$router->get("/entrar", "Auth:login", "auth.login");
$router->post("/entrar", "Auth:login", "auth.login");
$router->get("/alterar-senha", "Auth:updatePassword", "auth.update_password");
$router->post("/alterar-senha", "Auth:updatePassword", "auth.update_password");
$router->get("/esqueceu-senha", "Auth:forget", "auth.forget");
$router->post("/esqueceu-senha", "Auth:forget", "auth.forget");
$router->get("/recuperar/{code}", "Auth:recover", "auth.recover");
$router->post("/recuperar", "Auth:recover", "auth.recover.post");
$router->get("/sair", "Auth:logout", "auth.logout");


/**
 * Admin
 */
$router->namespace("Source\Controller\Admin");
$router->group("/panel");
$router->get("/", "Auth:login", "admin.auth_login");
$router->post("/", "Auth:login", "admin.auth_login");
$router->get("/dash", "Admin:dash", "admin.dash");
$router->post("/dash", "Admin:dash", "admin.dash");
$router->get("/tutoriais", "Admin:tutorials", "admin.tutorials");
$router->post("/tutoriais", "Admin:tutorials", "admin.tutorials");
$router->get("/tutorial/criar", "Admin:createTutorial", "admin.createTutorial");
$router->post("/tutorial/criar", "Admin:createTutorial", "admin.createTutorial");
$router->get("/tutorial/editar/{id}", "Admin:updateTutorial", "admin.updateTutorial");
$router->post("/tutorial/editar/{id}", "Admin:updateTutorial", "admin.updateTutorial");
$router->get("/planos", "Admin:plans", "admin.plans");
$router->post("/planos", "Admin:plans", "admin.plans");
$router->get("/categorias", "Admin:categories", "admin.categories");
$router->post("/categorias", "Admin:categories", "admin.categories");
$router->get("/packs", "Admin:packs", "admin.packs");
$router->post("/packs", "Admin:packs", "admin.packs");
$router->get("/artes", "Admin:arts", "admin.arts");
$router->post("/artes", "Admin:arts", "admin.arts");
$router->get("/arte/criar", "Admin:createArt", "admin.createArt");
$router->post("/arte/criar", "Admin:createArt", "admin.createArt");
$router->get("/arte/editar/{id}", "Admin:updateArt", "admin.updateArt");
$router->post("/arte/editar/{id}", "Admin:updateArt", "admin.updateArt");
$router->get("/usuarios", "Admin:users", "admin.users");
$router->post("/usuarios", "Admin:users", "admin.users");
$router->get("/usuario/criar", "Admin:createUser", "admin.createUser");
$router->post("/usuario/criar", "Admin:createUser", "admin.createUser");
$router->get("/usuario/editar/{id}", "Admin:updateUser", "admin.updateUser");
$router->post("/usuario/editar/{id}", "Admin:updateUser", "admin.updateUser");
$router->get("/senha", "Admin:password", "admin.password");
$router->post("/senha", "Admin:password", "admin.password");
$router->get('/faqs', 'Admin:faq', "admin.faq");
$router->post('/faqs', 'Admin:faq', "admin.faq");
$router->get('/campos-dinamicos', 'Admin:dynamicFields', 'admin.dynamic.fields');
$router->post('/campos-dinamicos', 'Admin:dynamicFields', 'admin.dynamic.fields');
$router->get('/lote', 'Admin:index', 'admin.index');
$router->post('/lote', 'Admin:index', 'admin.index');

/**
 * HOTMART
 */
$router->namespace("Source\Controller");
$router->group("/webhook");
$router->post("/compra-aprovada", "Webhook:approvedPurchase");
$router->post("/compra-reembolsada", "Webhook:refundedPurchase");
$router->post("/assinatura-cancelada", "Webhook:subscriptionCanceled");
$router->post("/troca-de-plano", "Webhook:changePlan");

/**
 * ERROR ROUTES
 */
$router->namespace("Source\Controller\Admin");
$router->group("/ops");
$router->get("/{errcode}", "Auth:error", "admin.error");

/**
 * ROUTE
 */
$router->dispatch();

/**
 * ERROR REDIRECT
 */
if ($router->error()) {
    $router->redirect("/ops/{$router->error()}");
}

ob_end_flush();