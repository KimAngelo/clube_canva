<?php $this->layout('_theme', ["head" => $head]); ?>

<div class="row mt-10 mt-lg-5">
    <div class="col-12">
        <div class="card card-custom gutter-b">
            <div class="card-header">
                <div class="card-title">
                    <h3 class="card-label">
                        <?= $tutorial->title ?>
                    </h3>
                </div>
            </div>
            <div class="card-body tutorial">
                <?= $tutorial->content ?>
            </div>
        </div>
    </div>
</div>