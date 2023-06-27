$(function () {
    $('#consultarProceso').submit(function (e) {
        var url = $('#consultarProceso').attr('action');
        var data = $(this).serialize();
        $.post(url, data, function (o) {
            $('#respuesta').html(o.tabla + o.paginacion);
            console.log(o);
        }, 'json');
        return false;
    });


    $('#frmCrear').submit(function (e) {
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.post(url, data, function (o) {

            Swal.fire({
                icon: 'success',
                title: "Creado correctamente",
            }).then((result) => {
                location.reload();
            });

            localStorage.reload;
        }, 'json');
        return false;
    });

    $('#frmEditar').submit(function (e) {
        var url = $(this).attr('action');
        var data = $(this).serialize();
        $.post(url, data, function (o) {

            Swal.fire({
                icon: 'success',
                title: "Editado correctamente",
            }).then((result) => {
                location.reload();
            });

            localStorage.reload;
        }, 'json');
        return false;
    });


    $(document).on("click", ".paginacion", function () {
        var data = $(this).attr("data-parametro");
        var url = $(this).attr("href");
        $.post(url, data, function (o) {
            $('#respuesta').html(o.tabla + "<br>" + o.paginacion);
        }, "json");
        return false;
    });

    $("#moneda option[value=" + $("#moneda").attr("data-selector") + "]").attr("selected", true)


    $("#SubirDocumento").submit(function () {
        var url = $(this).attr("action");// obtenemos la url donde viajara la info
        var formData = new FormData();
        formData.append("file", $("#file")[0].files[0]);

        $.ajax({
            url: url,
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            method: "POST",

            success: function (o) {

                if (o.mensaje == "error") {
                    Swal.fire({
                        icon: 'error',
                        title: "Debes cargar archivo",
                    });
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: "Imagen actualizada",
                    }).then((result) => {
                        location.reload();
                    });
                }
            }
        });

        return false;


    });

    $(document).on('click', '.eliminar-proceso', function (e) {
        var url = $(this).attr('href');
        Swal.fire({
            title: '¿Desea usted eliminar a este proceso?',
            icon: 'error',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'si, eliminalo',
            cancelButtonText: 'Cancelar',

        }).then((result) => {
            if (result.value) {
                $.post(url, function (e) {
                    Swal.fire({
                        icon: 'success',
                        title: e.msg,
                    }).then((result) => {
                        location.reload();
                    });


                }, 'json');
            }
        });
        return false;

    });
});
