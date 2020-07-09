function qw (i, c, d, s) {
    var x = document.createElement("SELECT");
    x.setAttribute("id",i);
    x.setAttribute("class",c);
    var ss = document.getElementById(s);
    ss.appendChild(x)
    var z = document.createElement("option");
    z.setAttribute("value", "");
    var t = document.createTextNode(d);
    z.appendChild(t);
    document.getElementById(i).appendChild(z);
}
qw ("search-cat", "form-control" , "Todas tipo", "select1");
qw ("search-marca", "form-control" , "Todas las marcas", "select2");
qw ("search-marca1", "form-control" , "Todas las marcas", "select3");
qw ("frecuency_cicles", "form-control update-full-dosis" , "", "select4");
qw ("time_cicles", "form-control update-full-dosis" , "", "select5");
var options =
    [{"text"  : "Horas",   "value" : "Horas"},
     { "text"     : "Días",    "value"    : "Días"  },
   { "text"     : "Mes(es)", "value"    : "Mes"},
  { "text"  : "Semana (s)",  "value" : "Semanas" }  ];

var selectBox = document.getElementById('frecuency_cicles');

for(var i = 0, l = options.length; i < l; i++){
    var option = options[i];
    selectBox.options.add( new Option(option.text, option.value, option.selected) );
}
var options =
    [{"text"  : "Días",   "value" : "Días"},
        { "text"     : "Mes(es)", "value"    : "Mes"},
        { "text"  : "Semana (s)",  "value" : "Semanas" }  ];

var selectBox = document.getElementById('time_cicles');

for(var i = 0, l = options.length; i < l; i++){
    var option = options[i];
    selectBox.options.add( new Option(option.text, option.value, option.selected) );
}