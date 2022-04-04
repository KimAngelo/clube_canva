<?php $this->layout('_theme', ["head" => $head]); ?>
<input type="hidden" name="user_name" value="<?= user()->first_name ?>">
<input type="hidden" name="endpoint" value="<?= $router->route('app.new.caption') ?>">
<div class="row mt-lg-5">
    <div class="col-12">
        <div class="card card-custom gutter-b">

            <div class="card-body">
                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <span class="text-lg-center" id="typed"></span>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group mb-1">
                            <textarea
                                    placeholder="Descreva seu produto ou serviço com o máximo de detalhes possível.&#10;&#10;Quanto mais informção você me fornecer, melhor será a sua legenda ok.&#10;&#10;Por exemplo: Biscoito da marca Bono sabor torta de limão, fabricante Nestlé, para crianças de 5 a 14 anos de idade, biscoito muito crocante e cheio de recheio."
                                    maxlength="300" class="form-control" name="description" rows="13"></textarea>
                        </div>
                        <span class="float-right"><small><span
                                        id="count_caracteres">0</span> / 300 caracteres</small></span>
                        <!--<span data-step="1" class="range-ia-text"></span>
                        <span data-step="2" class="range-ia-text"></span>
                        <span data-step="3" class="range-ia-text"></span>-->
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mt-5">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><strong>A legenda deve ter uma linguagem:</strong></label>
                            <select name="language" class="form-control">
                                <option value="1">Formal</option>
                                <option value="2">Informal</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row mt-5">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class=""><strong>Posso adicionar emoji na legenda? 😉 </strong></label>
                            <div class="checkbox-inline">
                                <div class="radio-inline">
                                    <label class="radio radio-rounded">
                                        <input type="radio" checked="checked" value="true" name="emoji"/>
                                        <span></span>
                                        Sim
                                    </label>
                                    <label class="radio radio-rounded">
                                        <input type="radio" value="false" name="emoji"/>
                                        <span></span>
                                        Não
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3"></div>
                </div>

                <div class="row">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <button id="button_generate" class="btn btn-theme btn-lg w-100 font-weight-bolder">GERAR
                            LEGENDA
                        </button>
                    </div>
                    <div class="col-md-3"></div>
                </div>
                <div class="row mt-20 d-none caption_none">
                    <div class="col-md-3"></div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <textarea id="caption" class="form-control" readonly rows="15"></textarea>
                            <div class="text-center mt-4">
                                <button data-clipboard-target="#caption" data-clipboard="true"
                                        data-toggle="tooltip" data-trigger="click" title="Copiado!"
                                        class="btn btn-theme-secondary btn-sm font-weight-bolder"><i
                                            class="far fa-copy text-white"></i> COPIAR
                                </button>
                            </div>
                            <div class="mt-10">
                                <span class="">Você possui <b id="balance"></b> créditos disponíveis para gerar suas legendas. <br>
                            </div>
                            Cada legenda consome 10 créditos.</span>
                        </div>

                    </div>
                    <div class="col-md-3"></div>
                </div>
            </div>


        </div>
    </div>
</div>

<?php $this->start('scripts') ?>
<?= js_version_control('plugins/custom/typed/typed', CONF_VIEW_APP) ?>
<script>
    let user_name = document.querySelector('input[name=user_name]').value;
    var typed = new Typed('#typed', {
        strings: ['Oi ' + user_name + ',^500 eu sou a Inteligência Artificial do Clube Canva,^500 ficarei muito feliz em te ajudar a criar as legendas para a sua rede social 😊.^500</br> Vamos começar?'],
        typeSpeed: 5,
        backSpeed: 0,
        loop: false,
    });

    let description = document.querySelector('textarea[name=description]');
    description.addEventListener('keyup', () => {
        document.getElementById('count_caracteres').innerText = description.value.length;
        if (description.value.length === 0) {
            description.classList.remove('input-border-warning');
            description.classList.remove('input-border-success');
        } else if (description.value.length <= 100) {
            description.classList.add('input-border-warning');
            description.classList.remove('input-border-success');
        } else {
            description.classList.add('input-border-success');
            description.classList.remove('input-border-warning');
        }

    });

    new ClipboardJS('[data-clipboard=true]');

    const endpoint = document.querySelector('input[name=endpoint]').value;
    const button_generate = document.querySelector('#button_generate');
    button_generate.addEventListener('click', () => {
        let language = document.querySelector('select[name=language]');
        language = language.options[language.selectedIndex].value;

        let emoji = document.querySelector('input[name=emoji]:checked').value;

        load('open');
        fetch(endpoint, {
            method: "POST",
            body: JSON.stringify({description: description.value, action: 'generate', language: language, emoji: emoji})
        }).then(function (response) {
            return response.json();
        }).then(function (response) {
            load('close');
            if (response.message_warning) {
                toastr.warning(response.message_warning);
                return false;
            }
            if (response.message_error) {
                toastr.error(response.message_error);
                return false;
            }
            if (response.success) {
                document.querySelector('.caption_none').classList.remove('d-none');
                document.querySelector('#caption').value = response.caption;
                document.querySelector('#balance').innerText = response.balance;
                //const to = document.querySelector('.btn-theme-secondary').offsetTop;
                window.scroll({
                    top: 600,
                    behavior: 'smooth'
                });
            }
            if (response.refresh) {
                $('html').animate({scrollTop: 0}, 'slow');
                setTimeout(function () {
                    window.location.reload();
                }, 500);

            }
        })
    });

</script>
<?php $this->end() ?>
