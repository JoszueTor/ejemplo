import { Alert, Dropdown, Modal } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";


const coMando = document.getElementById("comando");

const buscarComando = async (e) => {

    // alert('funciona_');
    let valor = e.target.value;
    // alert(valor);
    // let comando = formDatosRegistroComando.comando.value;
  
   
  
      try {
        const url = `/ejemplo/API/inspectoriaG/buscarSinoptico?valor=${valor}`;
        const headers = new Headers();
        headers.append("X-requested-With", "fetch");
    
        const config = {
          method: "GET",
        };
    
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
    
        // console.log(data);
        // return;
        var cuadroSinoptico = document.getElementById("cuadroSinoptico");
        var html = "<ul class='' > ";
    // BATALLONES
        data.forEach(function (item) {
          if (
            
            (item.idbatallon > 10 && item.idbatallon < 15)
          ) {
            html +=
              "<li  class='list-group-item-secondary'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        // COMPAÑIAS
        
    
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 111 ||
            (item.idbatallon > 1110 && item.idbatallon < 1115)
          ) {
            html +=
              "<li  class='list-group-item-success'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 112 ||
            (item.idbatallon > 1120 && item.idbatallon < 1125)
          ) {
            html +=
              "<li  class='list-group-item-success'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 113 ||
            (item.idbatallon > 1130 && item.idbatallon < 1135)
          ) {
            html +=
              "<li  class='list-group-item-success'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 114 ||
            (item.idbatallon > 1140 && item.idbatallon < 1145)
          ) {
            html +=
              "<li  class='list-group-item-success'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 115 ||
            (item.idbatallon > 1150 && item.idbatallon < 1155)
          ) {
            html +=
              "<li  class='list-group-item-success'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
    
        // asdfasdfasdfasdf
    
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 121 ||
            (item.idbatallon > 1210 && item.idbatallon < 1215)
          ) {
            html +=
              "<li  class='list-group-item-danger'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 122 ||
            (item.idbatallon > 1220 && item.idbatallon < 1225)
          ) {
            html +=
              "<li  class='list-group-item-danger'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 123 ||
            (item.idbatallon > 1230 && item.idbatallon < 1235)
          ) {
            html +=
              "<li  class='list-group-item-danger'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 124 ||
            (item.idbatallon > 1240 && item.idbatallon < 1245)
          ) {
            html +=
              "<li  class='list-group-item-danger'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 125 ||
            (item.idbatallon > 1250 && item.idbatallon < 1255)
          ) {
            html +=
              "<li  class='list-group-item-danger'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
       
    // otra unidad
    html += "<ul class=''>";
    data.forEach(function (item) {
      if (
        item.idbatallon == 131 ||
        (item.idbatallon > 1310 && item.idbatallon < 1315)
      ) {
        html +=
          "<li  class='list-group-item-info'>" +
          item.batallon +
          "</li> " +
          "<ul class=''>" +
          "<li >" +
          "LOTE: " +
          item.lote +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.calibre +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.cantidad +
          "</li>" +
          "</ul>";
      }
    });
    html += "</ul>";
    html += "<ul class=''>";
    data.forEach(function (item) {
      if (
        item.idbatallon == 132 ||
        (item.idbatallon > 1320 && item.idbatallon < 1325)
      ) {
        html +=
          "<li  class='list-group-item-info'>" +
          item.batallon +
          "</li> " +
          "<ul class=''>" +
          "<li >" +
          "LOTE: " +
          item.lote +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.calibre +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.cantidad +
          "</li>" +
          "</ul>";
      }
    });
    html += "</ul>";
    html += "<ul class=''>";
    data.forEach(function (item) {
      if (
        item.idbatallon == 133 ||
        (item.idbatallon > 1330 && item.idbatallon < 1335)
      ) {
        html +=
          "<li  class='list-group-item-info'>" +
          item.batallon +
          "</li> " +
          "<ul class=''>" +
          "<li >" +
          "LOTE: " +
          item.lote +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.calibre +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.cantidad +
          "</li>" +
          "</ul>";
      }
    });
    html += "</ul>";
    html += "<ul class=''>";
    data.forEach(function (item) {
      if (
        item.idbatallon == 134 ||
        (item.idbatallon > 1340 && item.idbatallon < 1345)
      ) {
        html +=
          "<li  class='list-group-item-info'>" +
          item.batallon +
          "</li> " +
          "<ul class=''>" +
          "<li >" +
          "LOTE: " +
          item.lote +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.calibre +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.cantidad +
          "</li>" +
          "</ul>";
      }
    });
        html += "</ul>";
        html += "<ul class=''>";
    data.forEach(function (item) {
      if (
        item.idbatallon == 135||
        (item.idbatallon > 1350 && item.idbatallon < 1355)
      ) {
        html +=
          "<li  class='list-group-item-info'>" +
          item.batallon +
          "</li> " +
          "<ul class=''>" +
          "<li >" +
          "LOTE: " +
          item.lote +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.calibre +
          "</li>" +
          "<li>" +
          "CALIBRE: " +
          item.cantidad +
          "</li>" +
          "</ul>";
      }
    });
        html += "</ul>";
        
    
        // OTRA UNIDAD
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 141||
            (item.idbatallon > 1410 && item.idbatallon < 1415)
          ) {
            html +=
              "<li  class='list-group-item-info'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 142||
            (item.idbatallon > 1420 && item.idbatallon < 1425)
          ) {
            html +=
              "<li  class='list-group-item-info'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 143||
            (item.idbatallon > 1430 && item.idbatallon < 1435)
          ) {
            html +=
              "<li  class='list-group-item-info'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 144||
            (item.idbatallon > 1440 && item.idbatallon < 1445)
          ) {
            html +=
              "<li  class='list-group-item-info'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        html += "<ul class=''>";
        data.forEach(function (item) {
          if (
            item.idbatallon == 145||
            (item.idbatallon > 1450 && item.idbatallon < 1455)
          ) {
            html +=
              "<li  class='list-group-item-info'>" +
              item.batallon +
              "</li> " +
              "<ul class=''>" +
              "<li >" +
              "LOTE: " +
              item.lote +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.calibre +
              "</li>" +
              "<li>" +
              "CALIBRE: " +
              item.cantidad +
              "</li>" +
              "</ul>";
          }
        });
        html += "</ul>";
        
    
        cuadroSinoptico.innerHTML = html;
      } catch (error) {
        console.log(error);
      }
  };



coMando.addEventListener("change", buscarComando);