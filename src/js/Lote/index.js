import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formLote = document.getElementById('form');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const divTabla = document.getElementById('divTabla');
let tablaLote = new Datatable('#LoteTabla');

btnModificar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnModificar.disabled = true;

const guardarLote = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formLote, ['id']);

    if(!formularioValido < 1 ){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/ejemplo/API/Lote/guardar'
        const body = new FormData(formLote);
        body.delete('id');
        const headers = new Headers();
        headers.append("X-requested-With", "fetch");

        const config = {
            method : 'POST',
            headers,
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const {resultado} = data;
        // const resultado = data.resultado;

        if(resultado == 1){
            Toast.fire({
                icon : 'success',
                title : 'Registro guardado'
            })

            formLote.reset();
            buscarLote();
        }else{
            Toast.fire({
                icon : 'error',
                title : 'Ocurrió un error'
            })
        }

    } catch (error) {
        console.log(error);
    }
}


const buscarLote = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/ejemplo/API/Lote/buscar'
        const headers = new Headers();
        headers.append("X-requested-With", "fetch");

        const config = {
            method : 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        // console.log(data);

        
        tablaLote.destroy();
        let contador = 1;
        tablaLote = new Datatable('#LoteTabla', {
            language : lenguaje,
            data : data,
            columns : [
                { 
                    data : 'id',
                    render : () => {      
                        return contador++;
                    }
                },
                { data : 'nombre'},
                { 
                    data : 'precio',
                    render : (data, type, row, meta) => {
                        return `Q. ${data}`
                    } 
                },
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-warning" onclick="asignarValores('${row.id}', '${row.nombre}', '${row.precio}')">Modificar</button>`
                    } 
                },
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-danger" onclick="eliminarRegistro('${row.id}')">Eliminar</button>`
                    } 
                },
            ]
        })

    } catch (error) {
        console.log(error);
    }
}

const modificarLote = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formLote);

    if(!formularioValido || formLote.precio.value < 1 ){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/ejemplo/API/Lote/modificar'
        const body = new FormData(formLote);
        const headers = new Headers();
        headers.append("X-requested-With", "fetch");

        const config = {
            method : 'POST',
            headers,
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        const {resultado} = data;
        // const resultado = data.resultado;

        if(resultado == 1){
            Toast.fire({
                icon : 'success',
                title : 'Registro modificado'
            })
            buscarLote();
            formLote.reset();
            btnModificar.parentElement.style.display = 'none';
            btnGuardar.parentElement.style.display = '';
            btnGuardar.disabled = false;
            btnModificar.disabled = true;
        
            divTabla.style.display = ''
        }else{
            Toast.fire({
                icon : 'error',
                title : 'Ocurrió un error'
            })
        }

    } catch (error) {
        console.log(error);
    }
}

buscarLote();

window.asignarValores = (id, nombre, precio) => {
    formLote.id.value = id;
    formLote.nombre.value = nombre;
    formLote.precio.value = precio;
    btnModificar.parentElement.style.display = '';
    btnGuardar.parentElement.style.display = 'none';
    btnGuardar.disabled = true;
    btnModificar.disabled = false;

    divTabla.style.display = 'none'
}

window.eliminarRegistro = (id) => {
    Swal.fire({
        title : 'Confirmación',
        icon : 'warning',
        text : '¿Esta seguro que desea eliminar este registro?',
        showCancelButton : true,
        confirmButtonColor : '#3085d6',
        cancelButtonColor : '#d33',
        confirmButtonText: 'Si, eliminar'
    }).then( async (result) => {
        if(result.isConfirmed){
            const url = '/ejemplo/API/Lote/eliminar'
            const body = new FormData();
            body.append('id', id);
            const headers = new Headers();
            headers.append("X-requested-With", "fetch");
    
            const config = {
                method : 'POST',
                headers,
                body
            }
    
            const respuesta = await fetch(url, config);
            const data = await respuesta.json();
            const {resultado} = data;
            // const resultado = data.resultado;
    
            if(resultado == 1){
                Toast.fire({
                    icon : 'success',
                    title : 'Registro eliminado'
                })
    
                formLote.reset();
                buscarLote();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
        }
    })
}

formLote.addEventListener('submit', guardarLote )
btnModificar.addEventListener('click', modificarLote);

