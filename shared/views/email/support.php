<?php $v->layout("_theme", ["title" => "E-mail de suporte"]); ?>

<h2>O <?= $first_name; ?> precisa de suporte</h2>
<p><strong>Mensagem:</strong></p>
<p><?= $message; ?></p>
<hr>
<p><strong>E-mail de cadastro é:</strong> <?= $email; ?></p>
<p><strong>Código identificador:</strong> <?= $cod ?></p>