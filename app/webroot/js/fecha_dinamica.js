// JavaScript Document
// Fecha dinámica

var mifecha=new Date()
var year=mifecha.getYear()
if (year < 1000)
year+=1900
var dia=mifecha.getDay()
var mes=mifecha.getMonth()
var diames=mifecha.getDate()
if (diames<10)
diames="0"+diames
var arraydia=new Array("Domingo","Lunes","Martes","Mi&eacute;rcoles","Jueves","Viernes","S&aacute;bado")
var mesarray=new Array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre")
document.write("<span style='float:right;padding:5% 1% 5% 1%;color:#708090;font-size:12px;font-weight:normal;'>"+arraydia[dia]+" "+diames+" de "+mesarray[mes]+" de "+year+"</span>")

/*border-top:1px solid #ddd;*/