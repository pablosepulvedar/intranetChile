function login(){
    $('#falla').css('display','none')
    let usuario = $('#usuario').val()
    let password = $('#password').val()
    let cmd = 'login'
    $.ajax({
        url: 'intranet/command.php',
        type: 'GET',
        data: {cmd,usuario,password},
        success: function (response) {
                let reservas = JSON.parse(response)
                if (reservas.length >= 1 ) {
                    window.open('intranet/reservas.php?usuario='+usuario+'&password='+password, '_self')
                } else {
                    $('#falla').css('display','')
                }
            }
        })
}
function inicFecha() {
    if ($("#fecha").val() == '') {
        var n = new Date()
        var y = n.getFullYear()
        var m = n.getMonth() + 1
        var d = n.getDate()
        if (m < 10) {
            m = '0'+m
        }
        if (d < 10) {
            d = '0'+d
        }
        var newfecha = `${y}-${m}-${d}`
        $("#fecha").val(newfecha);  
    }
}
function cambiarFecha(cambio) {
    var fecha = new Date($("#fecha").val())
    fecha.setDate(fecha.getDate() + 1)
    if (cambio == 0) {
        cambio = -1
    } 
    fecha.setDate(fecha.getDate() + cambio)
    var y = fecha.getFullYear()
    var m = fecha.getMonth() + 1
    var d = fecha.getDate()
    if (m < 10) {
        m = '0'+m
    }
    if (d < 10) {
        d = '0'+d
    }
    var newfecha = `${y}-${m}-${d}`
    $("#fecha").val(newfecha);
    cargarReservas()
}
function cargarReservas() {
    var fecha = $("#fecha").val()
    var cmd = 'reservas'
    $("#tablaReservas").empty()
    $.ajax({
        url: 'command.php',
        type: 'GET',
        data: {cmd,fecha}, /*Lo mismo que escribir {search: search} */
        success: function (response) {
            let reservas = JSON.parse(response)
            let tabla = ''
            for (let i = 0; i < reservas.length; i++) {
                const element = reservas[i]
                let adeudado = parseInt(element.total)-parseInt(element.abono);
                let estado = 'No Valida'
                let color = '#ff0202;'
                if (element.valida == 1) {
                    estado = 'Valida'
                    color = '#7ee382;'
                }
                tabla = tabla+'<tr title="'+element.observaciones+'"><td style="background-color:'+color+'">'+estado+'</td><td>'+element.hora+'</td>'+'<td>'+element.nombre+'</td>'+'<td>'+element.cantidad+'</td>'+'<td>'+element.total+'</td>'+'<td>'+element.abono+'</td>'+'<td>'+adeudado+'</td><td>'+element.usuario+'</td>'
                if ($('#idusuario').val() == element.usuario) {
                    tabla = tabla+'<td><input type="button" onclick="modReserva('+element.idreserva+')" value="Modificar"></td>'
                    tabla = tabla+'<td><input type="button" onclick="elimReserva('+element.idreserva+',\''+element.nombre+'\')" value="Eliminar"></td>'
                }
                tabla = tabla+'</tr>'
            }
            var jQueryTabla = $("<table><tr><th>Estado</th><th>Hora</th><th>Nombre</th><th>Cantidad</th><th>Total</th><th>Abono</th><th>Adeudado</th><th>Usuario</th><th>Acciones</th></tr>"+tabla+"</table>");
            jQueryTabla.attr({
            id:"reservas"});
            
            $("#tablaReservas").append(jQueryTabla);
            }
        })
}
function modReserva(idreserva) {
    if (comprobarPermisos('permiso1')){
        $('#tablaReservas').css('display', 'none')
        $('#cabecera').css('display', 'none')
        $('#idreserva').val(idreserva)
        if (idreserva == 0) {
            $('#btnReserva').val('Ingresar')
            $('#fechaForm').val($('#fecha').val())
            $('#idusuarioinsert').val($('#idusuario').val())
        } else {
            var cmd = 'traerReserva'
            var idreserva = idreserva
            $('#btnReserva').val('Modificar')
            $.ajax({
                url: 'command.php',
                type: 'GET',
                data: {cmd,idreserva}, /*Lo mismo que escribir {search: search} */
                success: function (response) {
                    let reserva = JSON.parse(response)
                    $('#idreserva').val(reserva[0].idreserva)
                    $('#valorUni').val(reserva[0].valoruni)
                    $('#valorDuo').val(reserva[0].valorduo)
                    $('#alma').val(reserva[0].vueloalma)
                    $('#nombre').val(reserva[0].nombre)
                    $('#cantidad').val(reserva[0].cantidad)
                    $('#hora').val(reserva[0].idhora)
                    $('#fechaForm').val(reserva[0].fecha)
                    $('#total').val(reserva[0].total)
                    $('#abono').val(reserva[0].abono)
                    $('#adeudado').val(reserva[0].adeudado)
                    $('#idusuarioinsert').val(reserva[0].usuario)
                    $('#observaciones').val(reserva[0].observaciones)
                    $('#telefono').val(reserva[0].telefono)
                    }
                })
        }
        $('#editReservas').css('display','')
    } else {
        alert('Sin permisos para Modificar Reservas')
    }
}
function elimReserva(idreserva,nombre) {
    if(confirm('Esta seguro que desea eliminar la reserva a nombre de '+nombre+'?'))
    {
        var cmd = 'eliminar'
        $.ajax({
            async: false,
            url: 'command.php',
            type: 'GET',
            data: {cmd,idreserva}, /*Lo mismo que escribir {search: search} */
            success: function (response) {
                    if (response == 'ok') {
                        cargarReservas()
                        alert('Reserva Eliminada')
                    } else {
                        alert(response)
                    }
                }
            })
    }
}
function volver(confirma = 'con') {
    if (confirma == 'sin') {
        confirma = true
    } else {
        confirma = confirm('Si vuelve al listado perdera los avances realizados')
    }
    if (confirma) {
        $('#tablaReservas').css('display', '')
        $('#cabecera').css('display', '')
        $('#editReservas').css('display','none')
        limpiarFormulario() 
        cargarReservas()
    }

}
function comprobarPermisos(permiso) {
    var idusuario = $('#idusuario').val()
    var cmd = 'comprobarpermisos'
    var conpermiso = false
    $.ajax({
        async: false,
        url: 'command.php',
        type: 'GET',
        data: {cmd,idusuario}, /*Lo mismo que escribir {search: search} */
        success: function (response) {
                let permisos = JSON.parse(response)
                if (permisos[0].permisos.includes(permiso)) {
                    conpermiso = true
                }else{
                    conpermiso = false
                }
            }
        })
    return conpermiso
}
function insertarReserva() {
    var idreserva = $('#idreserva').val()
    if (idreserva == 0) {
        alert('insertar nueva')
    } else {
        alert('Modificar existente')
    }
}
function cambioChekAlma(input) {
    if (input.checked) {
        $('#valorUni').val(66000)
        $('#valorDuo').val(132000)
        calcularValores()
    } else {
        $('#valorUni').val(50000)
        $('#valorDuo').val(95000)
        calcularValores()
    }
}
function calcularValores() {
    if ($('#cantidad').val() == '') {
        $('#cantidad').val(0)
    }
    if ($('#abono').val() == '') {
        $('#abono').val(0)
    }
    var cantidad = parseInt($('#cantidad').val())
    var valorUni = parseInt($('#valorUni').val())
    var ValorDuo = parseInt($('#valorDuo').val())
    var abono = parseInt($('#abono').val())
    var total 
    if (cantidad%2 == 0) {
        total = (cantidad/2)*ValorDuo 
    }else{
        if (cantidad > 1) {
            total = ((cantidad-1)/2)*ValorDuo+valorUni
        } else {
            total = cantidad*valorUni
        }
    }
    $('#total').val(total)
    $('#adeudado').val(total-abono)
}
function modificarValores() {
    if ($('#btnValores').val() == 'Modificar Valores') {
        $('#btnValores').val('Insertar Valores')
        $('#valorUni').prop('disabled', false)
        $('#valorDuo').prop('disabled', false)
    } else {
        if (confirm('Al insertar estos valores es importante que se modifiquen ambos, 多esta segudo que desea modificar?')) {
            $('#btnValores').val('Modificar Valores')
            if ($('#valorUni').val() == '') {
                $('#valorUni').val(50000)
            }
            if ($('#valorDuo').val() == '') {
                $('#valorDuo').val(95000)
            }
            $('#valorUni').prop('disabled', true)
            $('#valorDuo').prop('disabled', true)
            calcularValores()
        }
    }
}
function limpiarFormulario() {
    $('#idreserva').val(0)
    $('#valorUni').val(50000)
    $('#valorDuo').val(95000)
    $('#nombre').val('')
    $('#cantidad').val('')
    $('#hora').val(0)
    $('#fechaForm').val('')
    $('#total').val('')
    $('#abono').val('')
    $('#adeudado').val('')
    $('#observaciones').val('')
    $('#idusuarioinsert').val('')
    $('#telefono').val('')
}
function cargarHorarios() {
    var cmd = 'horarios'
    var optionsHorarios ='<option value="0">Seleccionar</option>' 
    $.ajax({
        async: false,
        url: 'command.php',
        type: 'GET',
        data: {cmd}, /*Lo mismo que escribir {search: search} */
        success: function (response) {
            let horarios = JSON.parse(response)
            for (let i = 0; i < horarios.length; i++) {
                optionsHorarios = optionsHorarios+'<option value="'+horarios[i].idvalor+'">'+horarios[i].valor+'</option>' 
            }
            $('#hora').prepend(optionsHorarios);
        }
    })
}
function insertarReserva() {
    var idreserva       = $('#idreserva').val()
    var valorUni        = $('#valorUni').val()
    var valorDuo        = $('#valorDuo').val()
    var checkAlma       = $('#alma').is(':checked')
    var nombre          = $('#nombre').val()
    var cantidad        = $('#cantidad').val()
    var idHora          = $('#hora').val()
    var fecha           = $('#fechaForm').val()
    var total           = $('#total').val()
    var abono           = $('#abono').val()
    var adeudado        = $('#adeudado').val()
    var observaciones   = $('#observaciones').val()
    var usuario         = $('#idusuarioinsert').val()
    var telefono        = $('#telefono').val()
    var email           = $('#email').val()
    var cmd             = 'insertarReserva'

    $.ajax({
        async: false,
        url: 'command.php',
        type: 'GET',
        data: {cmd,idreserva,valorUni,valorDuo,checkAlma,nombre,cantidad,idHora,fecha,total,abono,adeudado,observaciones,usuario,telefono}, /*Lo mismo que escribir {search: search} */
        success: function (response) {
            if (response == 'ins ok') {
                alert('Se ha ingresado su reserva con exito')
                volver('sin')
            } else if (response == 'mod ok') {
                alert('Se ha modificado su reserva con exito')
                volver('sin')
            } else {
                alert(response)
                return
            }
        }
    })
}
function cambiarUsuari() {
    var usuarioinsert = $('#idusuarioinsert')
    if (usuarioinsert.prop('disabled') == true) {
        usuarioinsert.prop('disabled', false)
        $('#cambiarUsuario').val('Insertar Usuario')
    } else {
        usuarioinsert.prop('disabled', true)
        $('#cambiarUsuario').val('Cambiar Usuario')
    }
}
function irmenuvalidar() {
    $('#tablaReservas').css('display', 'none')
    $('#cabecera').css('display', 'none')
    $('#divvalidar').css('display', '')
}
function irmenureservas() {
    $('#divvalidar').css('display', 'none')
    $('#tablaReservas').css('display', '')
    $('#cabecera').css('display', '')
    $('#editReservas').css('display','none')
    limpiarFormulario() 
    cargarReservas()
}