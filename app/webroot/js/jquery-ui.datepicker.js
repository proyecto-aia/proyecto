$(document).ready(function(){
                               
                                

                                $(function() {
                                                /*Llamamos al ID "datepicker" */
                                               $("#datepicker1, #datepicker2").datepicker(
                                               {

                                                // Todas estas propiedades estan explicadas en:
                                                //  http://api.jqueryui.com/datepicker/#option-dateFormat

                                                  // Para que aprentando en el INPUT o en el calendario se habra el calendario
                                                  // Jquery UI.
                                                  showOn: "both",

                                                  // ver todos los tipos de animaciones posibles que hay en:
                                                  // http://jqueryui.com/datepicker/#animation
                                                  showAnim: "fadeIn",


                                                  // El calendario va apareciendo lentamente. Esta bueno.
                                                  //duration: "slow",

                                                  // Para que la imagen no se vea con un recuadro
                                                  buttonImageOnly: true,

                                                  // Ubicacion de la imagen del calendario chiquito.
                                                  buttonImage: basePath + "img/datepicker.png",
                                                  // Texto que aparece al poner el cursor arriba del calendario
                                                  buttonText: "Calendarario",
                                                  
                                                  // Para poder cambiar tambien el año
                                                  changeYear: true,

                                                  // Esta bueno para tener un boton que te lleve a "today" y "done" para dejar
                                                  //la fecha que habiamos elegido y no tener que buscarla de nuevo
                                                  //showButtonPanel: true,

                                                  //formato de la fecha para que cuando se seleccione se muestre asi.
                                                  // Luego en el controller lo debemos girar ya que en la base de datos
                                                  // ser guardan como yy-mm-dd.
                                                  dateFormat: 'dd-mm-yy',

                                                  dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],

                                                  dayNamesMin: [ "Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa" ],

                                                  dayNamesShort: [ "Dom", "Lun", "Mar", "Mir", "Jue", "Vie", "Sab" ],

                                                  monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],

                                                  monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],

                                                  // Fecha maxima posible de seleccion. Existen diferentes formas de expresar la fecha maxima. Estos son algunos ejemplos.

                                                  // + 1 semana y 1 dia.
                                                  //maxDate: "+1w + 1d",

                                                  // Una fecha especifica. El formato es yyyy,mm,dd. De modo que para meses
                                                  // inferirores a 2 digitos se debe poner "m - 1".
                                                  //maxDate: new Date(2015, 5-1, 29),  // 29 de mayo, 2015 inclusive

                                                  // en dias a partir de la fecha actual.
                                                  maxDate: 0,


                                                  // Para el caso de la fecha minima, es lo mismo que en maxDate.
                                                  // antes de ayer.
                                                  //minDate: -2,

                                                  //minDate: new Date(2015, 4 - 1, 1),
                                               })

                                              /*Esta es una pequeña funcion que le agrego al INPUT "#datepicker" que lo que
                                              hace es LIMPIAR el campo si presionamos la tecla de codigo 8 (delete) o
                                              46 (backspace) */
                                                .keyup(function(e) {
                                                               if(e.keyCode == 8 || e.keyCode == 46) {
                                                                  $.datepicker._clearDate(this);
                                                                }
                                                          });


             

                                         }); /*fin function*/


                  });