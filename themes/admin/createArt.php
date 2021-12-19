<?php $this->layout('_theme', ["head" => $head]); ?>
<?php $this->start('css') ?>


<?php $this->end() ?>
    <div class="row">
    <div class="col-12">
        <div class="card card-custom">
            <div class="card-header flex-wrap border-0 pt-6 pb-0">
                <div class="card-title">
                    <h3 class="card-label">Adicionar arte</h3>
                </div>
            </div>
            <div class="card-body">
                <div class="ajax_response"></div>
                <?= flash() ?>
                <form class="form" action="<?= $router->route('admin.arts') ?>" method="post">
                    <input type="hidden" name="action" value="create">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group m-form__group">
                                <label><strong>Nome</strong>*</label>
                                <input type="text" class="form-control m-input" name="name"
                                       placeholder="Digite o título da arte">
                            </div>
                            <div class="form-group m-form__group">
                                <label><strong>Descrição</strong></label>
                                <textarea class="form-control m-input" name="description"
                                          placeholder="Escreva uma descrição para que os usuários encontre, este campo ficará oculto"
                                          rows="3"></textarea>
                            </div>
                            <div class="form-group m-form__group">
                                <label><strong>Link do template</strong>*</label>
                                <input type="url" class="form-control m-input" name="link_template"
                                       placeholder="Digite o link do template">
                            </div>
                            <div class="form-group m-form__group">
                                <label><strong>Pack</strong>*</label>
                                <select class="form-control m-input" name="id_pack">
                                    <option>Selecione</option>
                                    <?php if (!empty($packs)): foreach ($packs as $pack): ?>
                                        <option value="<?= $pack->id ?>"><?= $pack->name ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label><strong>Imagem de destaque <span
                                                    class="label label-inline font-weight-lighter mr-2">Tamanho 1080x1080px</span></strong></label>
                                    </br>
                                    <img src="" class="img-cover img-thumbnail"
                                         style="max-width: 150px; min-height: 150px; min-width: 150px;">
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group m-form__group">
                                        <div></div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="cover"
                                                   name="thumb"
                                                   accept="image/jpeg, image/png, image/jpg">
                                            <label class="custom-file-label" for="customFile">
                                                C: selecionar imagem
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group m-form__group h-lg-100">
                                <label><strong>Categorias</strong>*</label>
                                <div class="checkbox-list categories_admin">
                                    <input type="text" class="form-control m-input mb-5" name="search"
                                           placeholder="Buscar categoria">
                                    <?php if (!empty($categories)): foreach ($categories as $category): ?>
                                        <label class="checkbox">
                                            <input type="checkbox" value="<?= $category->id ?>"
                                                   class="categories_checkbox"
                                                   name="categories[]"/>
                                            <span></span>
                                            <?= $category->name ?>
                                        </label>
                                    <?php endforeach; endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-theme">Adicionar arte</button>
                        </div>
                    </div>
            </div>
        </div>
    </div>


    <?php $this->start('scripts') ?>
    <script>
        $(document).ready(function () {
            $("#cover").change(function () {
                filePreview(this, ".img-cover");
            });

            let input_search = document.querySelector('input[name=search]');
            //let categories_input = document.querySelectorAll('.categories_checkbox');
            let categories_input = document.querySelectorAll('.checkbox-list .checkbox');

            input_search.addEventListener('keyup', () => {
                let value_search = input_search.value;

                for (i = 0; i < categories_input.length; i++) {
                    let category_text = categories_input[i].innerText.toLowerCase().trim();
                    if (category_text.indexOf(value_search) >= 0) {
                        categories_input[i].style.display = "flex";
                    } else {
                        categories_input[i].style.display = "none";
                    }
                }

            });

        });


    </script>
<?php $this->end() ?>