import { Alert, Dropdown, Modal } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";
// import { Modal } from "bootstrap";
const formbusqueda = document.querySelector("#formbusqueda");
const imprimir = document.getElementById("imprimir");

let tablabusqueda = new Datatable("#busquedaTabla");




const iniciarBusqueda = async (e) => {
  e && e.preventDefault();

  try {
      const url = "/ejemplo/API/busqueda/buscar";
      const body = new FormData(formbusqueda);
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
        method: "POST",
        headers,
      body,
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();
  

    // console.log(data);
    // return;

    tablabusqueda.destroy();
    let contador = 1;
    tablabusqueda = new Datatable("#busquedaTabla", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "loted" },
        { data: "calibred" },
        { data: "motivod" },
        { data: "departamentod" },
        { data: "cantidad" },
        // { data: "apellido" },
        // { data: "totalCantidad" },
        // { data: "documento" },
        // { data: "observaciones" },
        // { data: "catalogo" },

        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `${row.grado} ${" "} ${row.catalogo} `;
        //   },
        // },
        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `${row.gradosalida} ${" "} ${row.catalogosalida} `;
        //   },
        // },
        // { data: "departamento" },

        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `<a type="button" class="btn btn-success" onclick="GenerarSalida('${row.id}')">Trasladar</a>`;
        //   },
        // },
 
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const abrirpdfg3 = async (e) => {

let lotebuscado=formbusqueda.lote.value
let calibrebuscado=formbusqueda.calibre.value
let motivobuscado =formbusqueda.motivo.value
let catalogobuscado =formbusqueda.catalogo.value
let comandobuscado =formbusqueda.comando.value


  var url = `./Reporte`;

  // var url = `/ejemplo/impresion/pdf-operacional?catalogo=${catalogo}&catalogog3=${catalogog3}&inicio=${inicio}&fin=${fin}`;
  //   window.location.href = url;

  // redirigir el navegador a la URL
  window.location.href = url;
  
    
};



formbusqueda.addEventListener("submit", iniciarBusqueda);
imprimir.addEventListener("click", abrirpdfg3);
