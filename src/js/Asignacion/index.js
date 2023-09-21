// import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";
import { Alert, Dropdown, Modal } from "bootstrap";

// const identificacion = document.getElementById("identificacion");

// const btnAsignar = document.getElementById("btnAsignar");

// let tablaalmacenComandoAsignado = new Datatable("#almacenComandoAsignado");

// const GenerarSalida1 = new Modal(document.getElementById("AsignacionTabla"));
// const AsignacionComando = new Modal(document.getElementById("asignadoAlmacen"));
// const tablaComando = document.getElementById("tablaComando");
// let tablaComando = new Datatable("#tablaComando");

const buscarComandoAsignado = async (e) => {
  var dependencianew = document.getElementById("identificacion").value;

  // alert(dependencianew);

  try {
    const url = `/ejemplo/API/Asignacion/buscarComando?buscarComando=${dependencianew}`;
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
      headers,
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    console.log(data);


    

    // tablaComando.destroy();
    // let contador = 1;
    // var jeraquia1;
    // var nombre1;
    
    // tablaComando = new Datatable("#tablaComando", {
    //   language: lenguaje,
    //   data: data,

    //   columns: [

    //     { data: "jerarquia" },
       
    //     {
    //       data: function (row, type, set) {
    //         if (row.jerarquia > 0) {
    //           return ` ${row.nombre}`;
    //         }
    //       },
    //     },

        

      
    //   ],
      
      
    // }
    // );
  } catch (error) {
    console.log(error);
  }
};

buscarComandoAsignado();

identificacion.addEventListener("change", buscarComandoAsignado);
