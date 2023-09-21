import { Alert, Dropdown, Modal } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from "datatables.net-bs5";
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";
// import { Modal } from "bootstrap";
const formIngresoAlmacen = document.querySelector("#formIngresoAlmacen");
const formIngresoAlmacen1 = document.getElementById("formIngresoAlmacen1");
const formDatosTablaFabrica = document.querySelector("#formDatosTablaFabrica");
const formSalida1 = document.getElementById("formSalida1");
const formRechazo1 = document.getElementById("formRechazo1");
const formRegreso1 = document.getElementById("formRegreso1");
const formHistorial = document.getElementById("formHistorial");
const formGenerarSalidaMunicionDestinada1 = document.getElementById("formGenerarSalidaMunicionDestinada");
const formGenerarSalidaMunicionDestinada = document.querySelector("#formGenerarSalidaMunicionDestinada");
const formdatosTablaRegreso = document.getElementById("formdatosTablaRegreso");
const formDatosRegistroComando = document.querySelector("#formDatosRegistroComando");

const btnGuardar = document.getElementById("btnGuardar");
const BtnCerrar = document.getElementById("BtnCerrar");
const btnTrasladar = document.getElementById("btnTrasladar");
const btnTrasladarMunicion = document.getElementById("btnTrasladarMunicion");
const btnRegresar = document.getElementById("btnRegresar");
const coMando = document.getElementById("comando");
const divTabla = document.getElementById("divTabla");
const divTabla1 = document.getElementById("divTabla1");
let tablaIngresoAlmacen = new Datatable("#IngresoAlmacenTabla");

let tablaIngresoAlmacen1 = new Datatable("#IngresoAlmacenTabla1");
let tablaSalidaFab1 = new Datatable("#SalidaFab1");
let tablaRechazoAlmacen = new Datatable("#RechazoAlmacen");
let historialFab = new Datatable("#historialFab");
let tablaRegistroComando = new Datatable("#tablaRegistroComando");

const InputCatalogo = document.getElementById("catalogo");
const spanText = document.querySelector("#textNombre");

const catalogoTraslado = document.getElementById("catalogoTraslado");
const textNombreTraslado = document.querySelector("#textNombreTraslado");

const spanTextSalidaTraslado = document.querySelector("#textNombreSalidaTraslado");
const catalogosalidaTraslado = document.getElementById("catalogosalidatraslado");

const modalEntradaMunicion = new Modal(document.getElementById("entradafab"));
const GenerarSalida1 = new Modal(document.getElementById("GenerarSalida"));
const GenerarRegreso1 = new Modal(document.getElementById("GenerarRegreso"));
const GenerarSalidaMunicionDestinada = new Modal(document.getElementById("GenerarSalidaMunicionDestinada"));
const MunicionDestinada = new Modal(document.getElementById("MunicionDestinada"));

const guardarIngresoAlmacen = async (evento) => {
  evento.preventDefault();

  let formularioValido = validarFormulario(formIngresoAlmacen, ["id"]);

  if (!formularioValido) {
    Toast.fire({
      icon: "warning",
      title: "Debe llenar todos los campos",
    });
    return;
  }

  try {
    //Crear el cuerpo de la consulta
    const url = "/ejemplo/API/IngresoAlmacen/guardar";
    const body = new FormData(formIngresoAlmacen);
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

      formIngresoAlmacen.reset();
      formIngresoAlmacen1.reset();
      buscarIngresoAlmacen();
      buscarIngresoAlmacen1();
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

const buscarIngresoAlmacen = async (e) => {
  e && e.preventDefault();

  try {
    const url = "/ejemplo/API/IngresoAlmacen/buscar";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    // console.log(data);

    tablaIngresoAlmacen.destroy();
    let contador = 1;
    tablaIngresoAlmacen = new Datatable("#IngresoAlmacenTabla", {
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
        // { data: "catalogo" },

        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.gradosalida} ${" "} ${row.catalogosalida} `;
          },
        },
        // { data: "departamento" },

        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-success" onclick="GenerarSalida('${row.id}')">Trasladar</a>`;
          },
        },
        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `<a type="button" class="btn btn-info" onclick="GenerarRegreso('${row.id}')">Regresar</a>`;
        //   },
        // },
        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `<a type="button" class="btn btn-danger" onclick="eliminarRegistro('${row.id}')">Eliminar</a>`;
        //   },
        // },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const buscarIngresoAlmacen1 = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/IngresoAlmacen/buscaringreso";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    //console.log(data);

    tablaIngresoAlmacen1.destroy();
    let contador = 1;
    tablaIngresoAlmacen1 = new Datatable("#IngresoAlmacenTabla1", {
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
        { data: "movimiento" },
        { data: "fecha" },
        { data: "documento" },
        { data: "observaciones" },
        { data: "departamento" },
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
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
    const url = "/ejemplo/API/IngresoAlmacen/buscarSalida";
    const headers = new Headers();
    headers.append("X-requested-With", "fetch");

    const config = {
      method: "GET",
    };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();

    // console.log(data);

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
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
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
    const url = "/ejemplo/API/IngresoAlmacen/buscarRechazo";
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
        
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

const HistorialFabrica = async (evento) => {
  evento && evento.preventDefault();

  try {
    const url = "/ejemplo/API/IngresoAlmacen/historialFabrica";
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
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `${row.grado} ${" "} ${row.catalogo} `;
          },
        },
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

const buscarComando = async (e) => {
  // alert('funciona_');
  let valor = e.target.value;
  // alert(valor);
  // let comando = formDatosRegistroComando.comando.value;

  try {
    const url = `/ejemplo/API/IngresoAlmacen/comando?valor=${valor}`;
    const config = { method: "GET" };

    const respuesta = await fetch(url, config);
    const data = await respuesta.json();
    // console.log(data);
    // return;

    tablaRegistroComando.destroy();
    let contador = 1;
    tablaRegistroComando = new Datatable("#tablaRegistroComando", {
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
        {
          data: "id",
          render: (data, type, row, meta) => {
            return `<a type="button" class="btn btn-success" onclick="GenerarSalidaMunicionDestinada('${row.id}')">Trasladar</a>`;
          },
        },
        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `<a type="button" class="btn btn-info" onclick="GenerarRegreso('${row.id}')">Regresar</a>`;
        //   },
        // },
        // {
        //   data: "id",
        //   render: (data, type, row, meta) => {
        //     return `<a type="button" class="btn btn-danger" onclick="eliminarRegistro('${row.id}')">Eliminar</a>`;
        //   },
        // },
      ],
    });
  } catch (error) {
    console.log(error);
  }
};

// buscarComando();
buscarIngresoAlmacen();
buscarIngresoAlmacen1();
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
      const url = "/ejemplo/API/IngresoAlmacen/eliminar";
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

        formIngresoAlmacen.reset();
        buscarIngresoAlmacen();
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
  // return;
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
   
      const url = "/ejemplo/API/IngresoAlmacen/validarRegistro";
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

        formIngresoAlmacen.reset();
        formIngresoAlmacen1.reset();
        buscarIngresoAlmacen();
        buscarIngresoAlmacen1();
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

  const url = `/ejemplo/API/IngresoAlmacen/GenerarSalida`;
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
    formDatosTablaFabrica.catalogo1.value =info1.catalogo;

  });
};
window.GenerarRegreso = async (id) => {
  // console.log(tipo1)

  const url = `/ejemplo/API/IngresoAlmacen/GenerarRegreso`;
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
  let formularioValido = validarFormulario(formDatosTablaFabrica, ["id1"]);
  // console.log(formularioValido);

  if (!formularioValido) {
    Toast.fire({
      icon: "warning",
      title: "Debe llenar todos los campos",
    });
    return;
  }
 
  
  try {
    const url = "/ejemplo/API/IngresoAlmacen/guardarTraslado";
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
    const { resultado } = data;
   

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro guardado",
      });

      GenerarSalida1.hide();
      formHistorial.reset();
      formSalida1.reset();
      formDatosTablaFabrica.reset();
      buscarIngresoAlmacen();
      buscarIngresoAlmacen1();
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
const generarTraslado = async (evento) => {
  evento.preventDefault();
  let formularioValido = validarFormulario(formGenerarSalidaMunicionDestinada, ["id1"]);
  // console.log(formularioValido);

  if (!formularioValido) {
    Toast.fire({
      icon: "warning",
      title: "Debe llenar todos los campos",
    });
    return;
  }
  GenerarSalidaMunicionDestinada.hide();
  try {
    const url = "/ejemplo/API/IngresoAlmacen/generarTraslado";
    const body = new FormData(formGenerarSalidaMunicionDestinada);
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
    const { resultado } = data;

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro guardado",
      });
      // tablaRegistroComando.destroy();
      // formGenerarSalidaMunicionDestinada1.reset();
      formHistorial.reset();
      formSalida1.reset();
      // formGenerarSalidaMunicionDestinada1.reset();
      formDatosTablaFabrica.reset();
      buscarIngresoAlmacen();
      buscarIngresoAlmacen1();
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
    const url = "/ejemplo/API/IngresoAlmacen/guardarRegreso";
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
    const { resultado } = data;

    if (resultado == 1) {
      Toast.fire({
        icon: "success",
        title: "Registro Retornado",
      });
      formdatosTablaRegreso.reset();
      buscarIngresoAlmacen();
      buscarIngresoAlmacen1();
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

let catalogoValido = false;
const buscarCatalogo = async (e) => {
  // evento.preventDefault();
  // alert('funciona_');
  let catalogo = e.target.value;

  if (catalogo.length < 6) {
    spanText.textContent = "CATÁLOGO MUY CORTO";
    spanText.classList.add("text-danger");
    spanText.classList.remove("text-success");
    catalogoValido = false;
    return;
  }

  try {
    const url = `/ejemplo/API/IngresoAlmacen/catalogo?catalogo=${catalogo}`;
    const config = { method: "GET" };
    const response = await fetch(url, config);

    const info = await response.json();
    // console.log(info);

    info;

    if (info != "") {
      if (info[0]["ape_id"] != "") {
        info.forEach((i) => {
          spanText.textContent = i.grado + " " + i.nombre;
          spanText.classList.remove("text-danger");
          spanText.classList.add("text-success");
          catalogoValido = true;
          // btn_guardar.style.display= 'none'
          // btn_guardar.disabled = true
          // btn_modificar.disabled = false
          // btn_modificar.style.display=''
        });
      } else {
        info.forEach((i) => {
          spanText.textContent = i.grado + " " + i.nombre;
          spanText.classList.remove("text-danger");
          spanText.classList.add("text-success");
          catalogoValido = true;
        });
      }
    } else {
      spanText.textContent = "NO SE ENCONTRARON DATOS";
      spanText.classList.add("text-danger");
      spanText.classList.remove("text-success");
      catalogoValido = false;
    }
  } catch (error) {
    console.log(error);
    spanText.classList.add("text-danger");
    spanText.classList.remove("text-success");
    catalogoValido = false;
  }
};

let catalogoTrasladoValidar = false;
const catalogoTraslado1 = async (e) => {
  // evento.preventDefault();
  // alert('funciona_');
  let catalogo = e.target.value;

  if (catalogo.length < 6) {
    textNombreTraslado.textContent = "CATÁLOGO MUY CORTO";
    textNombreTraslado.classList.add("text-danger");
    textNombreTraslado.classList.remove("text-success");
    catalogoTrasladoValidar = false;
    return;
  }

  try {
    const url = `/ejemplo/API/IngresoAlmacen/catalogo?catalogo=${catalogo}`;
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


let catalogoValidoTraslado = false;
const buscarCatalogoTraslado = async (e) => {
 
  let catalogosalida = e.target.value;

  if (catalogosalida.length < 6) {
    spanTextSalidaTraslado.textContent = "CATÁLOGO MUY CORTO";
    spanTextSalidaTraslado.classList.add("text-danger");
    spanTextSalidaTraslado.classList.remove("text-success");
    catalogoValidoTraslado = false;
    return;
  }

  try {
    const url = `/ejemplo/API/IngresoAlmacen/catalogosalida?catalogosalida=${catalogosalida}`;
    const config = { method: "GET" };
    const response = await fetch(url, config);

    const info = await response.json();
    // console.log(info);

    info;

    if (info != "") {
      if (info[0]["ape_id"] != "") {
        info.forEach((i) => {
          spanTextSalidaTraslado.textContent = i.grado + " " + i.nombre;
          spanTextSalidaTraslado.classList.remove("text-danger");
          spanTextSalidaTraslado.classList.add("text-success");
          catalogoValidoTraslado = true;
          // btn_guardar.style.display= 'none'
          // btn_guardar.disabled = true
          // btn_modificar.disabled = false
          // btn_modificar.style.display=''
        });
      } else {
        info.forEach((i) => {
          spanTextSalidaTraslado.textContent = i.grado + " " + i.nombre;
          spanTextSalidaTraslado.classList.remove("text-danger");
          spanTextSalidaTraslado.classList.add("text-success");
          catalogoValidoTraslado = true;
        });
      }
    } else {
      spanTextSalidaTraslado.textContent = "NO SE ENCONTRARON DATOS";
      spanTextSalidaTraslado.classList.add("text-danger");
      spanTextSalidaTraslado.classList.remove("text-success");
      catalogoValidoTraslado = false;
    }
  } catch (error) {
    console.log(error);
    spanTextSalidaTraslado.classList.add("text-danger");
    spanTextSalidaTraslado.classList.remove("text-success");
    catalogoValidoTraslado = false;
  }
};

window.GenerarSalidaMunicionDestinada = async (id) => {
  // console.log(tipo1)

  const url = `/ejemplo/API/IngresoAlmacen/GenerarSalidaMunicionDestinada`;
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
  // console.log(info);

  MunicionDestinada.hide();
  GenerarSalidaMunicionDestinada.show();
  info.forEach((info1) => {
    formGenerarSalidaMunicionDestinada.id1.value = info1.id;
    formGenerarSalidaMunicionDestinada.idlote1.value = info1.idlote;
    formGenerarSalidaMunicionDestinada.lote1.value = info1.lote;
    formGenerarSalidaMunicionDestinada.idcalibre1.value = info1.idcalibre;
    formGenerarSalidaMunicionDestinada.calibre1.value = info1.calibre;
    formGenerarSalidaMunicionDestinada.idmotivo1.value = info1.idmotivo;
    formGenerarSalidaMunicionDestinada.motivo1.value = info1.motivo;
    formGenerarSalidaMunicionDestinada.cantidad1.value = info1.cantidad;
    formGenerarSalidaMunicionDestinada.documento1.value = info1.documento;
    formGenerarSalidaMunicionDestinada.observaciones1.value =info1.observaciones;
    formGenerarSalidaMunicionDestinada.catalogo1.value =info1.catalogo;
  });
};

// let catalogoValido = false;

formIngresoAlmacen.addEventListener("submit", guardarIngresoAlmacen);
formDatosTablaFabrica.addEventListener("submit", guardarTraslado);
formGenerarSalidaMunicionDestinada.addEventListener("submit", generarTraslado);
formdatosTablaRegreso.addEventListener("submit", guardarRegreso);
formHistorial.addEventListener("submit", HistorialFabrica);
InputCatalogo.addEventListener("change", buscarCatalogo);
catalogoTraslado.addEventListener("change", catalogoTraslado1);
coMando.addEventListener("change", buscarComando);
catalogosalidaTraslado.addEventListener("change", buscarCatalogoTraslado);
