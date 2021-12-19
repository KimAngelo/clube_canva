//Configurações Toast
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": true,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};

$(function () {
    //Form
    $('.form').on('submit', function (e) {
        e.preventDefault();
        var form = $(this)[0];
        var data = new FormData(form);
        $.ajax({
            url: $(this).attr('action'),
            type: $(this).attr('method'),
            dataType: 'json',
            data: data,
            contentType: false,
            processData: false,
            beforeSend: function () {
                /*$('.btn-theme').addClass('m-loader m-loader--light m-loader--left');*/
                load('open');
            },
            success: function (response) {

                //$('html').animate({scrollTop: 0}, 'slow');
                if (response.message) {
                    $(".ajax_response").html(response.message);
                    return false;
                }
                if (response.message_success) {
                    toastr.success(response.message_success);
                    return false;
                }
                if (response.message_warning) {
                    toastr.warning(response.message_warning);
                    return false;
                }
                if (response.message_error) {
                    toastr.error(response.message_error);
                    return false;
                }
                if (response.redirect) {
                    window.location.href = response.redirect;
                }
                if (response.refresh) {
                    $('html').animate({scrollTop: 0}, 'slow');
                    setTimeout(function () {
                        window.location.reload();
                    }, 500);

                }
            },
            error: function (xhr, status, errorThrown) {
                if (xhr.status !== 200) {
                    toastr.error('Ocorreu um erro interno, entre em contato com o suporte!');
                }
            },
            complete: function () {
                /*$('.btn-theme').removeClass('m-loader m-loader--light m-loader--left');*/
                load('close');
            }
        });
    });

    //Tooltip
    $('[data-toggle="tooltip"]').tooltip()
});

//Carregamento da tela de load
function load(action) {
    var load_div = $(".ajax_load");
    if (action === "open") {
        load_div.fadeIn().css("display", "flex");
    } else {
        load_div.fadeOut();
    }
}

//Carregamento de DataTables
function loadTables(id) {
    $(id).DataTable({
        language: {
            "sEmptyTable": "Nenhum registro encontrado",
            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
            "sInfoPostFix": "",
            "sInfoThousands": ".",
            "sLengthMenu": "_MENU_ resultados por página",
            "sLoadingRecords": "Carregando...",
            "sProcessing": "Processando...",
            "sZeroRecords": "Nenhum registro encontrado",
            "sSearch": "Pesquisar",
            "oPaginate": {
                "sNext": "Próximo",
                "sPrevious": "Anterior",
                "sFirst": "Primeiro",
                "sLast": "Último"
            },
            "oAria": {
                "sSortAscending": ": Ordenar colunas de forma ascendente",
                "sSortDescending": ": Ordenar colunas de forma descendente"
            },
            "select": {
                "rows": {
                    "_": "Selecionado %d linhas",
                    "0": "Nenhuma linha selecionada",
                    "1": "Selecionado 1 linha"
                }
            },
            "buttons": {
                "copy": "Copiar para a área de transferência",
                "copyTitle": "Cópia bem sucedida",
                "copySuccess": {
                    "1": "Uma linha copiada com sucesso",
                    "_": "%d linhas copiadas com sucesso"
                }
            }
        },
        "order": [],
        "pageLength": 30,
        "lengthMenu": [30, 60, 100, 120, 150]
    });
}

//Miniatura de imagem no input
function filePreview(input, img) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $(img).attr("src", e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
    }
}

//Acionador do TinyMCE
function tinyMCEload(selector) {
    tinymce.init({
        selector: selector, height: 400,
        setup: function (editor) {
            editor.on('change', function () {
                editor.save();
            });
        },
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars insertdatetime media nonbreaking",
            "table contextmenu directionality emoticons paste textcolor responsivefilemanager code"
        ],
        toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
        toolbar2: "| responsivefilemanager | link unlink anchor | image media | forecolor backcolor  | print preview code ",
        image_advtab: false,
        language: "pt_BR",
        external_filemanager_path: BASE_SITE + "/themes/admin/assets/responsive_filemanager/filemanager/",
        filemanager_title: "Envio de imagens",
        external_plugins: {"filemanager": BASE_SITE + "/themes/admin/assets/responsive_filemanager/filemanager/plugin.min.js"},
        relative_urls: false,
        remove_script_host: false
    });
}