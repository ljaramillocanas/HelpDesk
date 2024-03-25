// Variable para almacenar la tabla de datos
var tabla;

// Obtiene el ID de usuario y el ID de rol
var user_id = $('#user_idx').val();
var rol_id = $('#rol_idx').val();

// Función de inicialización que se llama al cargar la página
function init(){
    // Evento de envío del formulario de asignación
    $("#asig_form").on("submit",function(e){
        // Llama a la función para asignar el ticket
        asignarT(e);
        // Oculta el modal de asignación
        $('#modalasignar').modal('hide');
        // Recarga la tabla de tickets
        $('#ticket_data').DataTable().ajax.reload();
        // Muestra un mensaje de éxito al usuario
        swal({
            title: "Resolvex:!",
            text: "El ticket ha sido asignado con éxito.",
            type: "success",
            confirmButtonClass: "btn-success"
        });
    });
}

// Función que se ejecuta cuando el documento está listo
$(document).ready(function(){

    // Petición AJAX para cargar el combo de usuarios
    $.post("../../Controller/usuario.php?op=combo",function(data){
        $('#usu_asig').html(data);
    });

    // Verifica el rol del usuario y carga los datos correspondientes en la tabla
    if(rol_id == 1){
        tabla = $('#ticket_data').dataTable({
            // Opciones de configuración de la tabla
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax":{
                url:'../../Controller/ticket.php?op=listar_x_usu',
                type: "post",
                dataType: "json",
                data: {usu_id : user_id},
                error: function(e){
                    console.log(e.responseText);
                }
            },
            // Opciones de idioma
            "language": {
                // ...
            }
        }).DataTable(); 
    } else {
        tabla = $('#ticket_data').dataTable({
            // Opciones de configuración de la tabla
            "aProcessing": true,
            "aServerSide": true,
            dom: 'Bfrtip',
            "searching": true,
            lengthChange: false,
            colReorder: true,
            buttons: [
                'copyHtml5',
                'excelHtml5',
                'csvHtml5',
                'pdfHtml5'
            ],
            "ajax":{
                url:'../../Controller/ticket.php?op=listar_ticket',
                type: "post",
                dataType: "json",
                error: function(e){
                    console.log(e.responseText);
                }
            },
            // Opciones de idioma
            "language": {
                // ...
            }
        }).DataTable(); 
    }
});

// Función para abrir la página de detalle del ticket
function ver(tick_id){
    console.log(tick_id)
    window.open('http://localhost/Help_Desk/view/detalleticket/?ID='+tick_id+'');
}

// Función para abrir el modal de asignación de ticket
function asignar(tick_id){
    $.post("../../Controller/ticket.php?op=mostrar",{tick_id:tick_id},function(data){
        data = JSON.parse(data);
        $('#tick_id').val(data.tick_id);
        $('#mdlasignar').html('Asignar Soporte');
        $('#modalasignar').modal('show');
    });
}

// Función para realizar la asignación de un ticket
function asignarT(e){
    e.preventDefault();
    var formData = new FormData($("#asig_form")[0]);
    $.ajax({
        url: "../../Controller/ticket.php?op=update_asig_tick",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(datos){  
            console.log(datos);       
        }   
    });
}

// Inicializa la página al cargarla
init();