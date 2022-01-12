<?php $this->layout("_theme", [
    "title" => "Dados de acesso | " . CONF_SITE_NAME
]); ?>

<h2>Parabéns <?= $first_name; ?>!</h2>
<p>Este são os seus dados para acessar o <?= CONF_SITE_NAME ?>.</p>
<p><strong>E-mail: </strong><?= $email ?><br/><strong>Senha: </strong><?= $password ?></p>
<p><a title='Acessar' href='<?= $link; ?>'>CLIQUE AQUI PARA ACESSAR</a></p>
<p><b>IMPORTANTE:</b> É importante que você altere sua senha quando acessar o <?= CONF_SITE_NAME ?> pela primeira vez.
</p>