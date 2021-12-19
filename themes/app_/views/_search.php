<div class="input-search">
    <form action="<?= $router->route('app.search') ?>" method="get">
        <div class="form-group">
            <div class="input-group">
                <input name="s" type="text" class="form-control" minlength="3" required
                       placeholder="Digite uma palavra..."/>
                <div class="input-group-append">
                    <button class="btn btn-secondary " type="submit"><i class="fas fa-search color-theme"></i>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>