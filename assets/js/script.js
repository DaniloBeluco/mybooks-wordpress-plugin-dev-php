jQuery(document).ready(function() {
    /* Ação ao clicar em Fazer Upload da Imagem do Livro */
    jQuery("#btn-upload").on("click", function() {
        var image = wp
            .media({
                title: "Upload Image for My Book",
                multiple: false,
            })
            .open()
            .on("select", function() {
                var uploaded_image = image.state().get("selection").first();
                var getImage = uploaded_image.toJSON().url;
                jQuery("#image_name").val(getImage);
                jQuery("#show-image").html(
                    "<img src='" +
                    getImage +
                    "' style='max-height:70px;max-width:70px;'/>"
                );
            });
    });

    /* Ação ao clicar em Cadastrar Livro */
    jQuery("#frmAddBook").validate({
        submitHandler: function() {
            var postdata =
                "action=mybooklibrary&param=save_book&" +
                jQuery("#frmAddBook").serialize();
            jQuery.post(mybookajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                } else {}
            });
        },
    });

    /* Ação ao clicar em Editar Livro */
    jQuery("#frmEditBook").validate({
        submitHandler: function() {
            var postdata =
                "action=mybooklibrary&param=edit_book&" +
                jQuery("#frmEditBook").serialize();
            jQuery.post(mybookajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                    setTimeout(function() {
                        //window.location.reload();
                        location.reload();
                    }, 1300);
                } else {}
            });
        },
    });

    /* Ação ao clicar em Deletar Livro */
    jQuery(".btnbookdelete").on("click", function() {
        var conf = confirm("Deseja mesmo excluir este livro ?");
        if (conf) {
            var book_id = jQuery(this).attr("data-id");
            var postdata = "action=mybooklibrary&param=delete_book&id=" + book_id;
            jQuery.post(mybookajaxurl, postdata, function(response) {
                var data = jQuery.parseJSON(response);
                if (data.status == 1) {
                    jQuery("#mb_success_message").html(
                        "<div class='alert alert-success'>" + data.message + "</div>"
                    );
                    setTimeout(function() {
                            location.reload();
                        }),
                        500;
                } else {}
            });
        }
    });

    /* Traduzindo o DataTables */
    jQuery("#my-book").DataTable({
        language: {
            lengthMenu: "Mostrar _MENU_ resultados por página",
            zeroRecords: "Nenhum livro encontrado - Desculpe =/",
            info: "Página <strong> _PAGE_ de _PAGES_ </strong>",
            infoEmpty: "Nenhum livro encontrado",
            infoFiltered: "(filtered from _MAX_ total records)",
            sSearch: "",
            oPaginate: {
                sFirst: "Primeiro ",
                sLast: " Último",
                sNext: "Próximo ",
                sPrevious: " Anterior",
            },
            searchPlaceholder: "Pesquisar..",
        },
    });
});