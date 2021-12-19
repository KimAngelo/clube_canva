<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>
<?php $this->end() ?>

    <div class="row">
        <div class="col-12">
            <div class="card card-custom">
                <div class="card-header flex-wrap border-0 pt-6 pb-0">
                    <div class="card-title">
                        <h3 class="card-label">Artes em lote
                        </h3>
                    </div>

                </div>

                <div class="card-body mt-5">
                    <div class="ajax_response"></div>
                    <?= flash() ?>
                    <?php if (!empty($index)): ?>
                        <!--begin: Datatable-->
                        <table class="table table-separate table-head-custom table-checkable table-responsive-sm"
                               id="table_1">
                            <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Quantidade</th>
                                <th>Ação</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($index as $data): ?>
                                <tr>
                                    <td><?= $data['name'] ?></td>
                                    <td><?= $data['total'] ?></td>
                                    <td>
                                        <form action="" method="post" class="form">
                                            <input type="hidden" name="action" value="index">
                                            <input type="hidden" name="name_file" value="<?= $data['name_file'] ?>">
                                            <button title="Indexar"
                                                    class="btn btn-theme">Indexar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                        <!--end: Datatable-->
                    <?php else: ?>
                        <p>Nenhum arquivo CSV encontrado</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?php $this->start('scripts') ?>

<?php $this->end() ?>