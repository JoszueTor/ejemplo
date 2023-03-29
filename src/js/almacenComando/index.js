import { Dropdown, Modal } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";
// import { Modal } from "bootstrap";

const formalmacenComando = document.getElementById("formalmacenComando");
const formalmacenComando1 = document.getElementById("formalmacenComando1");
const formalmacenComandoAsignado1 = document.getElementById(
  "formalmacenComandoAsignado"
);
const formSalida1 = document.getElementById("formSalida1");
const formRechazo1 = document.getElementById("formRechazo1");
const formRegreso1 = document.getElementById("formRegreso1");
const formHistorial = document.getElementById("formHistorial");
const formDatosTablaFabrica = document.getElementById("formDatosTablaFabrica");
const formdatosTablaRegreso = document.getElementById("formdatosTablaRegreso");
const btnGuardar = document.getElementById("btnGuardar");
const BtnCerrar = document.getElementById("BtnCerrar");
const btnTrasladar = document.getElementById("btnTrasladar");
const btnRegresar = document.getElementById("btnRegresar");

const divTabla = document.getElementById("divTabla");
const divTabla1 = document.getElementById("divTabla1");
const divTablaASIG = document.getElementById("divTablaASIG");
let tablaalmacenComando = new Datatable("#almacenComandoTabla");
let tablaalmacenComando1 = new Datatable("#almacenComandoTabla1");
let tablaalmacenComandoAsignado = new Datatable("#almacenComandoAsignado");
let tablaSalidaFab1 = new Datatable("#SalidaFab1");
let tablaRechazoAlmacen = new Datatable("#RechazoAlmacen");
let historialFab = new Datatable("#historialFab");
const modalEntradaMunicion = new Modal(document.getElementById("entradafab"));
const GenerarSalida1 = new Modal(document.getElementById("GenerarSalida"));
const GenerarRegreso1 = new Modal(document.getElementById("GenerarRegreso"));

// const guardaralmacenComando = async (evento) => {
//   evento.preventDefault();

//   let formularioValido = validarFormulario(formalmacenComando, ["id"]);

//   if (!formularioValido) {
//     Toast.fire({
//       icon: "warning",
//       title: "Debe llenar todos los campos",
//     });
//     return;
//   }

//   try {
//     //Crear el cuerpo de la consulta
//     const url = "/ejemplo/API/almacenComando/guardar";
//     const body = new FormData(formalmacenComando);
//     // body.append("cambio","1")
//     body.delete("id");
//     const headers = new Headers();
//     headers.append("X-requested-With", "fetch");

//     const config = {
//       method: "POST",
//       headers,
//       body,
//     };

//     const respuesta = await fetch(url, config);
//     const data = await respuesta.json();
//     //console.log(data);
//     const { resultado } = data;

//     if (resultado == 1) {
//       Toast.fire({
//         icon: "success",
//         title: "Registro guardado",
//       });

//       formalmacenComando.reset();
//       formalmacenComando1.reset();
//       buscaralmacenComando();
//       buscaralmacenComando1();
//       buscarSalidaFab1();
//       HistorialFabrica();
//     } else {
//       Toast.fire({
//         icon: "error",
//         title: "Ocurrió un error",
//       });
//     }
//   } catch (error) {
//     console.log(error);
//   }
// };

const buscaralmacenComando = async (e) => {
  e && e.preventDefault();

  try {
    const url = "/ejemplo/API/almacenComando/buscar";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    // console.log(data);

    tablaalmacenComando.destroy();
    let contador = 1;
    tablaalmacenComando = new Datatable("#almacenComandoTabla", {
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
            return `<a type="button" class="btn btn-success" onclick="GenerarSalida('${row.id}')">Trasladar</a>`;
          },
        },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-info" onclick="GenerarRegreso('${row.id}')">Regresar</a>`;
          },
        },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-danger" onclick="eliminarRegistro('${row.id}')">Eliminar</a>`;
          },
        },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const buscaralmacenComando1 = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/almacenComando/buscaringreso";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    //console.log(data);

    tablaalmacenComando1.destroy();
    let contador = 1;
    tablaalmacenComando1 = new Datatable("#almacenComandoTabla1", {
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

const buscaralmacenComandoAsignado = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/almacenComando/buscaringresoAsignado";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
      headers,
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    console.log(data);

    tablaalmacenComandoAsignado.destroy();
    let contador = 1;
    tablaalmacenComandoAsignado = new Datatable("#almacenComandoAsignado", {
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
        { data: "movimiento" },
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
    const url = "/ejemplo/API/almacenComando/buscarSalida";
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

const buscarRechazoAlmacen = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/almacenComando/buscarRechazo";
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
    const url = "/ejemplo/API/almacenComando/historialFabrica";
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
        { data: "departamento" },
        { data: "situacion" },
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

buscaralmacenComando();
buscaralmacenComando1();
buscaralmacenComandoAsignado();
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
      const url = "/ejemplo/API/almacenComando/eliminar";
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

        formalmacenComando.reset();
        buscaralmacenComando();
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
      const url = "/ejemplo/API/almacenComando/validarRegistro";
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

        buscaralmacenComando();
        buscaralmacenComando1();
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
  const url = `/ejemplo/API/almacenComando/GenerarSalida`;
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
  //console.log(info);
  GenerarSalida1.show();
  info.forEach((info1) => {
    formDatosTablaFabrica.id1.value = info1.id;
    formDatosTablaFabrica.idlote1.value = info1.idlote;
    formDatosTablaFabrica.lote1.value = info1.lote;
    formDatosTablaFabrica.idcalibre1.value = info1.idcalibre;
    formDatosTablaFabrica.calibre1.value = info1.calibre;
    formDatosTablaFabrica.idmotivo1.value = info1.idmotivo;
    formDatosTablaFabrica.motivo1.value = info1.motivo;
    formDatosTablaFabrica.cantidad1.value = info1.cantidad;
  });
};

window.GenerarRegreso = async (id) => {
  // console.log(tipo1)

  const url = `/ejemplo/API/almacenComando/GenerarRegreso`;
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
  //console.log(info);
  GenerarRegreso1.show();
  info.forEach((info1) => {
    formdatosTablaRegreso.id1.value = info1.id;
    formdatosTablaRegreso.idlote1.value = info1.idlote;
    formdatosTablaRegreso.lote1.value = info1.lote;
    formdatosTablaRegreso.idcalibre1.value = info1.idcalibre;
    formdatosTablaRegreso.calibre1.value = info1.calibre;
    formdatosTablaRegreso.idmotivo1.value = info1.idmotivo;
    formdatosTablaRegreso.motivo1.value = info1.motivo;
    formdatosTablaRegreso.cantidad1.value = info1.cantidad;
  });
};

const guardarTraslado = async (evento) => {
  evento.preventDefault();
  //   let formularioValido = validarFormulario(formDatosTablaFabrica, ["id1"]);
  //   // console.log(formularioValido);

  //   if (!formularioValido) {
  //     Toast.fire({
  //       icon: "warning",
  //       title: "Debe llenar todos los campos",
  //     });
  //     return;
  //   }
  GenerarSalida1.hide();
  try {
    const url = "/ejemplo/API/almacenComando/guardarTraslado";
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
    console.log(data);
    const { resultado } = data;

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro guardado",
      });

      // formalmacenComando.reset();
      formHistorial.reset();
      formSalida1.reset();
      formDatosTablaFabrica.reset();
      buscaralmacenComando();
      buscaralmacenComando1();
      buscaralmacenComandoAsignado();
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
  let formularioValido = validarFormulario(formdatosTablaRegreso, ["id1"]);
  // console.log(formularioValido);

  if (!formularioValido) {
    Toast.fire({
      icon: "warning",
      title: "Debe llenar todos los campos",
    });
    return;
  }
  GenerarRegreso1.hide();
  try {
    const url = "/ejemplo/API/almacenComando/guardarRegreso";
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
    console.log(data);
    const { resultado } = data;

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro Retornado",
      });
      formdatosTablaRegreso.reset();
      buscaralmacenComando();
      buscaralmacenComando1();
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

// formalmacenComando.addEventListener("submit", guardaralmacenComando);
formDatosTablaFabrica.addEventListener("submit", guardarTraslado);
formdatosTablaRegreso.addEventListener("submit", guardarRegreso);
formHistorial.addEventListener("submit", HistorialFabrica);
