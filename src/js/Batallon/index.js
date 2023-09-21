import { Alert, Dropdown, Modal } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";
import { createElement } from "fullcalendar";
// import { Modal } from "bootstrap";
const formBatallon = document.getElementById("formBatallon");
const formBatallon1 = document.getElementById("formBatallon1");
const formBatallonAsignado1 = document.getElementById("formBatallonAsignado");
const formSalida1 = document.getElementById("formSalida1");
const formRechazo1 = document.getElementById("formRechazo1");
const formRegreso1 = document.getElementById("formRegreso1");
const formHistorial = document.getElementById("formHistorial");

const formCompania = document.getElementById("formCompania");
const formPeloton = document.getElementById("formPeloton");
const formDatosTablaFabrica = document.querySelector("#formDatosTablaFabrica");
const formdatosTablaRegreso = document.querySelector("#formdatosTablaRegreso");
const formdatosTablaRegresoComando = document.querySelector("#formdatosTablaRegresoComando");
const btnGuardar = document.getElementById("btnGuardar");
const BtnCerrar = document.getElementById("BtnCerrar");
const btnTrasladar = document.getElementById("btnTrasladar");
const btnRegresar = document.getElementById("btnRegresar");
const iddependencia = document.getElementById("iddependencia");
const BtnAsignarmunicion = document.getElementById("BtnAsignarmunicion");

const catalogoTraslado = document.getElementById("catalogoTraslado");
const textNombreTraslado = document.querySelector("#textNombreTraslado");

const divTabla = document.getElementById("divTabla");
const divTabla1 = document.getElementById("divTabla1");
const divTablaASIG = document.getElementById("divTablaASIG");
let tablaBatallon = new Datatable("#BatallonTabla");
let tablaCompania = new Datatable("#CompaniaTabla");
let tablaPeloton = new Datatable("#PelotonTabla");
let tablaBatallon1 = new Datatable("#BatallonTabla1");
let tablaBatallonAsignado = new Datatable("#BatallonAsignado");
let tablaSalidaFab1 = new Datatable("#SalidaFab1");
let tablaRechazoAlmacen = new Datatable("#RechazoAlmacen");
let historialFab = new Datatable("#historialFab");
const modalEntradaMunicion = new Modal(document.getElementById("entradafab"));
const GenerarSalida1 = new Modal(document.getElementById("GenerarSalida"));
const GenerarRegreso1 = new Modal(document.getElementById("GenerarRegreso"));
const GenerarRegresoComando1 = new Modal(document.getElementById("GenerarRegresoComando"));

const buscarBatallon = async (e) => {
  e && e.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/buscar";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    // console.log(data);
    // exit;

    tablaBatallon.destroy();
    let contador = 1;
    tablaBatallon = new Datatable("#BatallonTabla", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "lote" },
        { data: "calibre" },
        { data: "motivo" },
        { data: "cantidad" },
        { data: "documento" },
        { data: "observaciones" },

        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
        // { data: "catalogosalida" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.gradosalida} ${" "} ${row.catalogosalida} `;
          },
        },
        { data: "batallon" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-success" onclick="GenerarSalida('${row.id}')">Trasladar</a>`;
          },
        },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-warning" onclick="GenerarRegresoComando('${row.id}')">Regresar</a>`;
          },
        },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const buscarCompaniaTabla = async (e) => {
  e && e.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/CompaniaTabla";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    tablaCompania.destroy();
    let contador = 1;
    tablaCompania = new Datatable("#CompaniaTabla", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "lote" },
        { data: "calibre" },
        { data: "motivo" },
        { data: "cantidad" },
        { data: "documento" },
        { data: "observaciones" },

        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
        // { data: "catalogosalida" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.gradosalida} ${" "} ${row.catalogosalida} `;
          },
        },
        { data: "batallon" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-success" onclick="GenerarSalida('${row.id}')">Trasladar</a>`;
          },
        },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-warning" onclick="GenerarRegreso('${row.id}')">Regresar</a>`;
          },
        },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};
const buscarPelotonTabla = async (e) => {
  e && e.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/PelotonTabla";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    // console.log(data);
    // return;
    tablaPeloton.destroy();
    let contador = 1;
    tablaPeloton = new Datatable("#PelotonTabla", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "lote" },
        { data: "calibre" },
        { data: "motivo" },
        { data: "cantidad" },
        { data: "documento" },
        { data: "observaciones" },

        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
        // { data: "catalogosalida" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.gradosalida} ${" "} ${row.catalogosalida} `;
          },
        },
        { data: "batallon" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-success" onclick="GenerarSalida('${row.id}')">Trasladar</a>`;
          },
        },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-warning" onclick="GenerarRegreso('${row.id}')">Regresar</a>`;
          },
        },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const buscarBatallon1 = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/buscaringreso";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    //console.log(data);

    tablaBatallon1.destroy();
    let contador = 1;
    tablaBatallon1 = new Datatable("#BatallonTabla1", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "lote" },
        { data: "calibre" },
        { data: "motivo" },
        { data: "cantidad" },
        // { data: "movimiento" },
        { data: "fecha" },
        { data: "documento" },
        { data: "observaciones" },
        // { data: "batallon" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
        // { data: "catalogosalida" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.gradosalida} ${" "} ${row.catalogosalida} `;
          },
        },
        { data: "batallon" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-info" onclick="validarRegistro('${row.id}')">Validar</a>`;
          },
        },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const buscarBatallonAsignado = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/buscaringresoAsignado";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
      headers,
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    // console.log(data);

    tablaBatallonAsignado.destroy();
    let contador = 1;
    tablaBatallonAsignado = new Datatable("#BatallonAsignado", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "lote" },
        { data: "calibre" },
        { data: "cantidad" },
        { data: "motivo" },
        { data: "documento" },
        { data: "observaciones" },
        // { data: "movimiento" },
        { data: "fecha" },
        { data: "departamento" },
        //   { data: "idbat" },
        { data: "batallon" },
        { data: "cuatrimestre" },
        // { data: "fecha" },
        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `<a type="button" class="btn btn-info" onclick="validarRegistro('${row.id}')">Validar</a>`;
        //   },
        // },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const buscarSalidaFab1 = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/buscarSalida";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();
    //console.log(data);

    tablaSalidaFab1.destroy();
    let contador = 1;
    tablaSalidaFab1 = new Datatable("#SalidaFab1", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "lote" },
        { data: "calibre" },
        { data: "motivo" },
        { data: "cantidad" },
        { data: "fecha" },
        { data: "documento" },
        { data: "observaciones" },
        // { data: "departamento" },
        { data: "batallon" },

        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
        // { data: "catalogosalida" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.gradosalida} ${" "} ${row.catalogosalida} `;
          },
        },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const buscarRechazoAlmacen = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/buscarRechazo";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    //console.log(data);

    tablaRechazoAlmacen.destroy();
    let contador = 1;
    tablaRechazoAlmacen = new Datatable("#RechazoAlmacen", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "lote" },
        { data: "calibre" },
        { data: "motivo" },
        { data: "cantidad" },
        { data: "fecha" },
        { data: "documento" },
        { data: "observaciones" },
        { data: "departamento" },
        // { data: "fecha" },
        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `<a type="button" class="btn btn-info" onclick="validarRegistro('${row.id}')">Validar</a>`;
        //   },
        // },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const HistorialFabrica = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/historialFabrica";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    //console.log(data);

    historialFab.destroy();
    let contador = 1;
    historialFab = new Datatable("#historialFab", {
      language: lenguaje,
      data: data,
      columns: [
        {
          data: "id",
          render: () => {
            return contador++;
          },
        },
        { data: "lote" },
        { data: "calibre" },
        { data: "motivo" },
        { data: "cantidad" },
        // { data: "fecha" },
        { data: "documento" },
        { data: "observaciones" },
        { data: "movimiento" },
        { data: "fecha" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
        // { data: "catalogosalida" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.gradosalida} ${" "} ${row.catalogosalida} `;
          },
        },
        { data: "batallon" },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

buscarPelotonTabla();
buscarBatallon();
buscarCompaniaTabla();
buscarBatallon1();
buscarBatallonAsignado();
buscarSalidaFab1();
HistorialFabrica();
buscarRechazoAlmacen();

window.eliminarRegistro = async (id) => {
  //alert(id);
  // evento.preventDefault();
  Swal.fire({
    title: "Confirmación",
    icon: "warning",
    text: "¿Esta seguro que desea eliminar este registro?",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, eliminar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const url = "/ejemplo/API/Batallon/eliminar";
      const body = new FormData();
      body.append("id", id);
      const headers = new Headers();
      headers.append("X-requested-With", "fetch");

      const config = {
        method: "POST",
        headers,
        body,
      };

      const respuesta = await fetch(url, config);
      const data = await respuesta.json();
      const { resultado } = data;
      // const resultado = data.resultado;

      if (resultado == 1) {
        Toast.fire({
          icon: "success",
          title: "Registro eliminado",
        });

        formBatallon.reset();
        buscarBatallon();
      } else {
        Toast.fire({
          icon: "error",
          title: "Ocurrió un error",
        });
      }
    }
  });
};

window.validarRegistro = (id) => {
  // alert(id);
  modalEntradaMunicion.hide();
  Swal.fire({
    title: "Confirmación",
    icon: "warning",
    text: "¿Esta seguro que desea validar este registro?",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si, validar",
  }).then(async (result) => {
    if (result.isConfirmed) {
      const url = "/ejemplo/API/Batallon/validarRegistro";
      const body = new FormData();
      body.append("id", id);
      const headers = new Headers();
      headers.append("X-requested-With", "fetch");

      const config = {
        method: "POST",
        headers,
        body,
      };

      const respuesta = await fetch(url, config);
      const data = await respuesta.json();
      const { resultado } = data;
      // const resultado = data.resultado;

      if (resultado == 1) {
        Toast.fire({
          icon: "success",
          title: "Registro validado",
        });
        buscarCompaniaTabla();
        buscarBatallon();
        buscarBatallon1();
        buscarSalidaFab1();
        HistorialFabrica();
      } else {
        Toast.fire({
          icon: "error",
          title: "Ocurrió un error",
        });
      }
    }
  });
};




window.GenerarSalida = async (id) => {
  // console.log(tipo1)
  // alert(id);
  const selectCompañia = document.getElementById("batallon");

  const url = `/ejemplo/API/Batallon/GenerarSalida`;
  const body = new FormData();
  body.append("id", id);
  const headers = new Headers();
  headers.append("X-Requested-With", "fetch");

  const config = {
    method: "POST",
    headers,
    body,
  };

  const respuesta = await fetch(url, config);
  const info = await respuesta.json();
  //  console.log(info);
  // return;
  GenerarSalida1.show();
  let batallon1 = info[0].batallon;
  let comando1 = info[0].departamento;
  const url1 = `/ejemplo/API/Batallon/buscarCompania?batallon1=${batallon1}&comando1=${comando1}`;
  
  // console.log(info1);
  // return;
  const headers1 = new Headers();
  headers1.append("X-Requested-With", "fetch");
  
  const config1 = {
    method: "GET",
  };
  
  const respuesta1 = await fetch(url1, config1);
  const info1 = await respuesta1.json();
  // console.log(info1);
  // return;
  info.forEach((info1) => {
    formDatosTablaFabrica.id1.value = info1.id;
    formDatosTablaFabrica.idlote1.value = info1.idlote;
    formDatosTablaFabrica.lote1.value = info1.lote;
    formDatosTablaFabrica.idcalibre1.value = info1.idcalibre;
    formDatosTablaFabrica.calibre1.value = info1.calibre;
    formDatosTablaFabrica.idmotivo1.value = info1.idmotivo;
    formDatosTablaFabrica.motivo1.value = info1.motivo;
    formDatosTablaFabrica.cantidad1.value = info1.cantidad;
    formDatosTablaFabrica.documento1.value = info1.documento;
    formDatosTablaFabrica.observaciones1.value = info1.observaciones;
    formDatosTablaFabrica.departamento1.value = info1.departamento;
    formDatosTablaFabrica.batallon1.value = info1.batallon;
    formDatosTablaFabrica.catalogo1.value = info1.catalogo;
  });

  for (let i = selectCompañia.options.length; i >= 0; i--) {
    selectCompañia.remove(i);
  }
  const option = document.createElement("option");
  option.value = "";
  option.innerText = "SELECCIONE...";
  selectCompañia.appendChild(option);

 
    info1.forEach((info2) => {
      let option = document.createElement("option");
      option.value = info2.jerarquia;
      option.innerText = info2.nombre;
      selectCompañia.appendChild(option);
    });


  
};

window.GenerarRegreso = async (id) => {
  // console.log(tipo1)
  // alert(id);
  const selectCompañia = document.getElementById("batallonSalida");

  const url = `/ejemplo/API/Batallon/GenerarSalida`;
  const body = new FormData();
  body.append("id", id);
  const headers = new Headers();
  headers.append("X-Requested-With", "fetch");

  const config = {
    method: "POST",
    headers,
    body,
  };

  const respuesta = await fetch(url, config);
  const info = await respuesta.json();
//   console.log(info);
//  return;
  
  GenerarRegreso1.show();
  let batallon1 = info[0].batallon;
  let comando1 = info[0].departamento;
  const url1 = `/ejemplo/API/Batallon/buscarCompaniaSalida?batallon1=${batallon1}&comando1=${comando1}`;
    
  const headers1 = new Headers();
  headers1.append("X-Requested-With", "fetch");

  const config1 = {
    method: "GET",
  };

  const respuesta1 = await fetch(url1, config1);
  const info1 = await respuesta1.json();
  // console.log(info1);
  // return;
  info.forEach((info1) => {
    formdatosTablaRegreso.id1.value = info1.id;
    formdatosTablaRegreso.idlote1.value = info1.idlote;
    formdatosTablaRegreso.lote1.value = info1.lote;
    formdatosTablaRegreso.idcalibre1.value = info1.idcalibre;
    formdatosTablaRegreso.calibre1.value = info1.calibre;
    formdatosTablaRegreso.idmotivo1.value = info1.idmotivo;
    formdatosTablaRegreso.motivo1.value = info1.motivo;
    formdatosTablaRegreso.cantidad1.value = info1.cantidad;
    formdatosTablaRegreso.documento1.value = info1.documento;
    formdatosTablaRegreso.observaciones1.value = info1.observaciones;
    formdatosTablaRegreso.departamento1.value = info1.departamento;
    formdatosTablaRegreso.batallon1.value = info1.batallon;
    formdatosTablaRegreso.catalogo1.value = info1.catalogo;
  });

  for (let i = selectCompañia.options.length; i >= 0; i--) {
    selectCompañia.remove(i);
  }
  const option = document.createElement("option");
  option.value = "";
  option.innerText = "SELECCIONE...";
  selectCompañia.appendChild(option);


  
    info1.forEach((info2) => {
      let option = document.createElement("option");
      option.value = info2.jerarquia;
      option.innerText = info2.nombre;
      selectCompañia.appendChild(option);
    });

};

window.GenerarRegresoComando = async (id) => {
  // console.log(tipo1)
  // alert(id);
  const selectCompañiaComando = document.getElementById("batallonSalidaComando");

  const url = `/ejemplo/API/Batallon/GenerarSalida`;
  const body = new FormData();
  body.append("id", id);
  const headers = new Headers();
  headers.append("X-Requested-With", "fetch");

  const config = {
    method: "POST",
    headers,
    body,
  };

  const respuesta = await fetch(url, config);
  const info = await respuesta.json();
//   console.log(info);
//  return;
  
  GenerarRegresoComando1.show();
  let batallon1 = info[0].batallon;
  let comando1 = info[0].departamento;
  const url1 = `/ejemplo/API/Batallon/buscarCompaniaSalida?batallon1=${batallon1}&comando1=${comando1}`;
    
  const headers1 = new Headers();
  headers1.append("X-Requested-With", "fetch");

  const config1 = {
    method: "GET",
  };

  const respuesta1 = await fetch(url1, config1);
  const info1 = await respuesta1.json();
  // console.log(info1);
  // return;
  info.forEach((info1) => {
    formdatosTablaRegresoComando.id1.value = info1.id;
    formdatosTablaRegresoComando.idlote1.value = info1.idlote;
    formdatosTablaRegresoComando.lote1.value = info1.lote;
    formdatosTablaRegresoComando.idcalibre1.value = info1.idcalibre;
    formdatosTablaRegresoComando.calibre1.value = info1.calibre;
    formdatosTablaRegresoComando.idmotivo1.value = info1.idmotivo;
    formdatosTablaRegresoComando.motivo1.value = info1.motivo;
    formdatosTablaRegresoComando.cantidad1.value = info1.cantidad;
    formdatosTablaRegresoComando.documento1.value = info1.documento;
    formdatosTablaRegresoComando.observaciones1.value = info1.observaciones;
    formdatosTablaRegresoComando.departamento1.value = info1.departamento;
    formdatosTablaRegresoComando.batallon1.value = info1.batallon;
    formdatosTablaRegresoComando.catalogo1.value = info1.catalogo;
  });

  for (let i = selectCompañiaComando.options.length; i >= 0; i--) {
    selectCompañiaComando.remove(i);
  }
  const option = document.createElement("option");
  option.value = "";
  option.innerText = "SELECCIONE...";
  selectCompañiaComando.appendChild(option);


  
    info1.forEach((info2) => {
      let option = document.createElement("option");
      option.value = info2.jerarquia;
      option.innerText = info2.nombre;
      selectCompañiaComando.appendChild(option);
    });

};

const guardarTraslado = async (evento) => {
  evento.preventDefault();

  GenerarSalida1.hide();

  try {
    const url = "/ejemplo/API/Batallon/guardarTraslado";
    const body = new FormData(formDatosTablaFabrica);
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

    const { resultado } = data;

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro guardado",
      });
      buscarSinoptico();
      
      formDatosTablaFabrica.reset();
      buscarPelotonTabla();
      buscarBatallon();
      buscarBatallon1();
      buscarCompaniaTabla();
      buscarBatallonAsignado();
      buscarSalidaFab1();
      HistorialFabrica();
    } else {
      Toast.fire({
        icon: "error",
        title: "Ocurrió un error",
      });
    }
  } catch (error) {
    console.log(error);
  }
};


const guardarRegreso = async (evento) => {
  evento.preventDefault();
  GenerarRegreso1.hide();

  try {
    const url = "/ejemplo/API/Batallon/guardarTrasladoRegreso";
    const body = new FormData(formdatosTablaRegreso);
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

    const { resultado } = data;

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro guardado",
      });
      buscarSinoptico();
      formdatosTablaRegreso.reset();
      buscarPelotonTabla();
      buscarBatallon();
      buscarBatallon1();
      buscarCompaniaTabla();
      buscarBatallonAsignado();
      buscarSalidaFab1();
      HistorialFabrica();
    } else {
      Toast.fire({
        icon: "error",
        title: "Ocurrió un error",
      });
    }
  } catch (error) {
    console.log(error);
  }
};
const guardarRegresoComando = async (evento) => {
  evento.preventDefault();
  GenerarRegresoComando1.hide();

  try {
    const url = "/ejemplo/API/Batallon/guardarTrasladoRegresoComando";
    const body = new FormData(formdatosTablaRegresoComando);
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

    const { resultado } = data;

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro guardado",
      });
      buscarSinoptico();
      formdatosTablaRegresoComando.reset();
      buscarPelotonTabla();
      buscarBatallon();
      buscarBatallon1();
      buscarCompaniaTabla();
      buscarBatallonAsignado();
      buscarSalidaFab1();
      HistorialFabrica();
    } else {
      Toast.fire({
        icon: "error",
        title: "Ocurrió un error",
      });
    }
  } catch (error) {
    console.log(error);
  }
};

// const ApiDerrota = async (e) => {
//   //  var  dependencianew = document.getElementById('iddependencia').value;

//   // alert(dependencianew);
//   // ?dependencia=${dependencianew}

//   var url = `./Asignacion`;

//   // redirigir el navegador a la URL
//   window.location.href = url;
// };

let catalogoTrasladoValidar = false;
const catalogoTraslado1 = async (e) => {
  // evento.preventDefault();
  // alert('funciona_');
  let catalogo = e.target.value;
  // alert(catalogo);
  if (catalogo.length < 6) {
    textNombreTraslado.textContent = "CATÁLOGO MUY CORTO";
    textNombreTraslado.classList.add("text-danger");
    textNombreTraslado.classList.remove("text-success");
    catalogoTrasladoValidar = false;
    return;
  }

  try {
    const url = `/ejemplo/API/Batallon/catalogo?catalogo=${catalogo}`;
    const config = { method: "GET" };
    const response = await fetch(url, config);

    const info = await response.json();
    // console.log(info);

    info;

    if (info != "") {
      if (info[0]["ape_id"] != "") {
        info.forEach((i) => {
          textNombreTraslado.textContent = i.grado + " " + i.nombre;
          textNombreTraslado.classList.remove("text-danger");
          textNombreTraslado.classList.add("text-success");
          catalogoTrasladoValidar = true;
          // btn_guardar.style.display= 'none'
          // btn_guardar.disabled = true
          // btn_modificar.disabled = false
          // btn_modificar.style.display=''
        });
      } else {
        info.forEach((i) => {
          textNombreTraslado.textContent = i.grado + " " + i.nombre;
          textNombreTraslado.classList.remove("text-danger");
          textNombreTraslado.classList.add("text-success");
          catalogoTrasladoValidar = true;
        });
      }
    } else {
      textNombreTraslado.textContent = "NO SE ENCONTRARON DATOS";
      textNombreTraslado.classList.add("text-danger");
      textNombreTraslado.classList.remove("text-success");
      catalogoTrasladoValidar = false;
    }
  } catch (error) {
    console.log(error);
    textNombreTraslado.classList.add("text-danger");
    textNombreTraslado.classList.remove("text-success");
    catalogoTrasladoValidar = false;
  }
};

const buscarSinoptico = async (e) => {
  e && e.preventDefault();

  try {
    const url = "/ejemplo/API/Batallon/buscarSinoptico";
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
      "CANTIDAD: " +
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
      "CANTIDAD: " +
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
      "CANTIDAD: " +
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
      "CANTIDAD: " +
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
      "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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
          "CANTIDAD: " +
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

buscarSinoptico();

// formBatallon.addEventListener("submit", guardarBatallon);
formDatosTablaFabrica.addEventListener("submit", guardarTraslado);
formdatosTablaRegreso.addEventListener("submit", guardarRegreso);
formdatosTablaRegresoComando.addEventListener("submit", guardarRegresoComando);
formHistorial.addEventListener("submit", HistorialFabrica);
// BtnAsignarmunicion.addEventListener("click", ApiDerrota);
catalogoTraslado.addEventListener("change", catalogoTraslado1);
