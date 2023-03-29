import { Dropdown, Modal } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";
// import { Modal } from "bootstrap";

const formIngresoFab = document.getElementById("formIngresoFab");
const formIngresoFab1 = document.getElementById("formIngresoFab1");
const formSalida1 = document.getElementById("formSalida1");
const formHistorial = document.getElementById("formHistorial");
const formDatosTablaFabrica = document.getElementById("formDatosTablaFabrica");
const btnGuardar = document.getElementById("btnGuardar");
const BtnCerrar = document.getElementById("BtnCerrar");
const btnTrasladar = document.getElementById("btnTrasladar");

const divTabla = document.getElementById("divTabla");
const divTabla1 = document.getElementById("divTabla1");
let tablaIngresoFab = new Datatable("#IngresoFabTabla");
let tablaIngresoFab1 = new Datatable("#IngresoFabTabla1");
let tablaSalidaFab1 = new Datatable("#SalidaFab1");
let historialFab = new Datatable("#historialFab");
const modalEntradaMunicion = new Modal(document.getElementById("entradafab"));
const GenerarSalida1 = new Modal(document.getElementById("GenerarSalida"));

const guardarIngresoFab = async (evento) => {
  evento.preventDefault();

  let formularioValido = validarFormulario(formIngresoFab, ["id"]);

  if (!formularioValido) {
    Toast.fire({
      icon: "warning",
      title: "Debe llenar todos los campos",
    });
    return;
  }

  try {
    //Crear el cuerpo de la consulta
    const url = "/ejemplo/API/IngresoFab/guardar";
    const body = new FormData(formIngresoFab);
    // body.append("cambio","1")
    body.delete("id");
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "POST",
      headers,
      body,
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();
    //console.log(data);
    const { resultado } = data;

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro guardado",
      });

      formIngresoFab.reset();
      formIngresoFab1.reset();
      buscarIngresoFab();
      buscarIngresoFab1();
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

const buscarIngresoFab = async (e) => {
  e && e.preventDefault();

  try {
    const url = "/ejemplo/API/IngresoFab/buscar";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    // console.log(data);

    tablaIngresoFab.destroy();
    let contador = 1;
    tablaIngresoFab = new Datatable("#IngresoFabTabla", {
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
            return `<a type="button" class="btn btn-danger" onclick="eliminarRegistro('${row.id}')">Eliminar</a>`;
          },
        },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const buscarIngresoFab1 = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/IngresoFab/buscaringreso";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    //console.log(data);

    tablaIngresoFab1.destroy();
    let contador = 1;
    tablaIngresoFab1 = new Datatable("#IngresoFabTabla1", {
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

const buscarSalidaFab1 = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/IngresoFab/buscarSalida";
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
    const url = "/ejemplo/API/IngresoFab/historialFabrica";
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
        { data: "fecha" },
        { data: "documento" },
        { data: "observaciones" },
        { data: "movimiento" },
       
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

buscarIngresoFab();
buscarIngresoFab1();
buscarSalidaFab1();
HistorialFabrica();

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
      const url = "/ejemplo/API/IngresoFab/eliminar";
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

        formIngresoFab.reset();
        buscarIngresoFab();
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
      const url = "/ejemplo/API/IngresoFab/validarRegistro";
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

        formIngresoFab.reset();
        formIngresoFab1.reset();
        buscarIngresoFab();
        buscarIngresoFab1();
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

  const url = `/ejemplo/API/IngresoFab/GenerarSalida`;
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

const guardarTraslado = async (evento) => {
  evento.preventDefault();
  let formularioValido = validarFormulario(formDatosTablaFabrica, ["id1"]);
  // console.log(formularioValido);

  if (!formularioValido) {
    Toast.fire({
      icon: "warning",
      title: "Debe llenar todos los campos",
    });
    return;
  }
  GenerarSalida1.hide();
  try {
    const url = "/ejemplo/API/IngresoFab/guardarTraslado";
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

      // formIngresoFab.reset();
      formHistorial.reset();
      formSalida1.reset();
      formDatosTablaFabrica.reset();
      buscarIngresoFab();
      buscarIngresoFab1();
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

formIngresoFab.addEventListener("submit", guardarIngresoFab);
formDatosTablaFabrica.addEventListener("submit", guardarTraslado);
formHistorial.addEventListener("submit", HistorialFabrica);
