<?php $this->layout('_theme', ["head" => $head]); ?>

<div class="row">
    <div class="col-xl-3">
        <!--begin::Stats Widget 30-->
        <div class="card card-custom bg-info card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <span class="svg-icon svg-icon-2x svg-icon-white">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                         viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none"
                           fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path d="M18,14 C16.3431458,14 15,12.6568542 15,11 C15,9.34314575 16.3431458,8 18,8 C19.6568542,8 21,9.34314575 21,11 C21,12.6568542 19.6568542,14 18,14 Z M9,11 C6.790861,11 5,9.209139 5,7 C5,4.790861 6.790861,3 9,3 C11.209139,3 13,4.790861 13,7 C13,9.209139 11.209139,11 9,11 Z"
                                  fill="#000000" fill-rule="nonzero"
                                  opacity="0.3"></path>
                            <path d="M17.6011961,15.0006174 C21.0077043,15.0378534 23.7891749,16.7601418 23.9984937,20.4 C24.0069246,20.5466056 23.9984937,21 23.4559499,21 L19.6,21 C19.6,18.7490654 18.8562935,16.6718327 17.6011961,15.0006174 Z M0.00065168429,20.1992055 C0.388258525,15.4265159 4.26191235,13 8.98334134,13 C13.7712164,13 17.7048837,15.2931929 17.9979143,20.2 C18.0095879,20.3954741 17.9979143,21 17.2466999,21 C13.541124,21 8.03472472,21 0.727502227,21 C0.476712155,21 -0.0204617505,20.45918 0.00065168429,20.1992055 Z"
                                  fill="#000000" fill-rule="nonzero"></path>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block"><?= $users_count ?></span>
                <span class="font-weight-bold text-white font-size-sm">Usuários registrados</span>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 30-->
    </div>
    <div class="col-xl-3">
        <!--begin::Stats Widget 31-->
        <div class="card card-custom bg-danger card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body">
				<span class="svg-icon svg-icon-2x svg-icon-white">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Media/Equalizer.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                         viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none"
                           fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"></rect>
                            <rect fill="#000000" opacity="0.3" x="13" y="4" width="3"
                                  height="16" rx="1.5"></rect>
                            <rect fill="#000000" x="8" y="9" width="3" height="11"
                                  rx="1.5"></rect>
                            <rect fill="#000000" x="18" y="11" width="3" height="9"
                                  rx="1.5"></rect>
                            <rect fill="#000000" x="3" y="13" width="3" height="7"
                                  rx="1.5"></rect>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block"><?= $arts_count ?></span>
                <span class="font-weight-bold text-white font-size-sm">Artes cadastradas</span>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 31-->
    </div>
    <div class="col-xl-3">
        <!--begin::Stats Widget 32-->
        <div class="card card-custom bg-dark card-stretch gutter-b">
            <!--begin::Body-->
            <div class="card-body">
                <span class="svg-icon svg-icon-2x svg-icon-white">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Group-chat.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                         viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24"/>
                            <path d="M2,13 C2,12.5 2.5,12 3,12 C3.5,12 4,12.5 4,13 C4,13.3333333 4,15 4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,13 C20,12.4477153 20.4477153,12 21,12 C21.5522847,12 22,12.4477153 22,13 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 C2,15 2,13.3333333 2,13 Z"
                                  fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                            <rect fill="#000000" opacity="0.3"
                                  transform="translate(12.000000, 8.000000) rotate(-180.000000) translate(-12.000000, -8.000000) "
                                  x="11" y="1" width="2" height="14" rx="1"/>
                            <path d="M7.70710678,15.7071068 C7.31658249,16.0976311 6.68341751,16.0976311 6.29289322,15.7071068 C5.90236893,15.3165825 5.90236893,14.6834175 6.29289322,14.2928932 L11.2928932,9.29289322 C11.6689749,8.91681153 12.2736364,8.90091039 12.6689647,9.25670585 L17.6689647,13.7567059 C18.0794748,14.1261649 18.1127532,14.7584547 17.7432941,15.1689647 C17.3738351,15.5794748 16.7415453,15.6127532 16.3310353,15.2432941 L12.0362375,11.3779761 L7.70710678,15.7071068 Z"
                                  fill="#000000" fill-rule="nonzero"
                                  transform="translate(12.000004, 12.499999) rotate(-180.000000) translate(-12.000004, -12.499999) "/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <span class="card-title font-weight-bolder text-white font-size-h2 mb-0 mt-6 d-block"><?= $downloads_today ?></span>
                <span class="font-weight-bold text-white font-size-sm">Downloads hoje</span>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 32-->
    </div>
    <div class="col-xl-3">
        <!--begin::Stats Widget 29-->
        <div class="card card-custom bgi-no-repeat card-stretch gutter-b"
             style="background-position: right top; background-size: 30% auto; background-image: url(<?= theme('assets/media/svg/shapes/abstract-1.svg', CONF_VIEW_ADMIN) ?>)">
            <!--begin::Body-->
            <div class="card-body">
                <span class="svg-icon svg-icon-2x svg-icon-info">
                    <!--begin::Svg Icon | path:assets/media/svg/icons/Communication/Mail-opened.svg-->
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                         version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"/>
                            <path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z"
                                  fill="#000000" fill-rule="nonzero" opacity="0.3"/>
                            <path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z"
                                  fill="#000000" fill-rule="nonzero"/>
                        </g>
                    </svg>
                    <!--end::Svg Icon-->
                </span>
                <span class="card-title font-weight-bolder text-dark-75 font-size-h2 mb-0 mt-6 d-block"><?= $onlineCount ?></span>
                <span class="font-weight-bold text-muted font-size-sm">Usuários online</span>
            </div>
            <!--end::Body-->
        </div>
        <!--end::Stats Widget 29-->
    </div>
</div>

<div class="row mt-48">
    <div class="col-12">
        <h4 class="font-weight-bold mb-3 ml-3">Usuários online</h4>
        <table class="table table-hover table-responsive-sm ">
            <thead>
            <tr>
                <th>Tempo de navegação</th>
                <th>Usuário</th>
                <th>Qt. de páginas</th>
                <th>Url</th>
            </tr>
            </thead>
            <tbody class="app_dash_home_trafic_list">
            <?php if($online): ?>
               <?php foreach ($online as $onlineNow): ?>
                <tr>
                    <td>
                        <?= date_fmt($onlineNow->created_at, "H\hi") . " - " . date_fmt($onlineNow->updated_at, "H\hi") ?>
                    </td>
                    <td>
                        <?= !empty($onlineNow->user) ? $onlineNow->user()->first_name : "Guest"; ?>
                    </td>
                    <td>
                        <?= $onlineNow->pages; ?>
                    </td>
                    <td>
                        <a target="_blank" href="<?= url("{$onlineNow->url}") ?>"><?= $onlineNow->url ?></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<?php $this->push("scripts"); ?>
    <script>
        $(function () {
            setInterval(function () {
                $.post("<?= $router->route('admin.dash') ?>", {refresh: true}, function (response) {
                    //count
                    if (response.count) {
                        $(".app_dash_home_trafic_count").html(response.count);
                    } else {
                        $(".app_dash_home_trafic_count").html(0);
                    }

                    //list
                    var list = "";
                    if (response.list) {
                        $.each(response.list, function (item, data) {
                            var url = data.url;

                            list += "<tr>";
                            list += "<td>" + data.dates + "</td>";
                            list += "<td>" + data.user + "</td>";
                            list += "<td>" + data.pages + "</td>";
                            list += "<td><a target='_blank' href='" + url + "'>" + url + "</a></td>";
                            list += "</tr>";

                        });


                    } else {
                        list = "<p>Não existem usuários navegando neste momento...</p>";
                    }
                    $(".app_dash_home_trafic_list").html(list);
                }, 'json');
            }, 1000 * 5)
        });
    </script>
<?php $this->end(); ?>