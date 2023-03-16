import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";

const formCalibre = document.getElementById('formCalibre');
const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const divTabla = document.getElementById('divTabla');
let tablaCalibre = new Datatable('#CalibreTabla');

btnModificar.parentElement.style.display = 'none';
btnGuardar.disabled = false;
btnModificar.disabled = true;

const guardarCalibre = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formCalibre, ['id']);

    if(!formularioValido ){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/ejemplo/API/Calibre/guardar'
        const body = new FormData(formCalibre);
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
        console.log(data);
        const {resultado} = data;
    

        if(resultado == 1){
            Toast.fire({
                icon : 'success',
                title : 'Registro guardado'
            })

            formCalibre.reset();
            buscarCalibre();
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


const buscarCalibre = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/ejemplo/API/Calibre/buscar'
        const headers = new Headers();
        headers.append("X-requested-With", "fetch");

        const config = {
            method : 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        console.log(data);

        
        tablaCalibre.destroy();
        let contador = 1;
        tablaCalibre = new Datatable('#CalibreTabla', {
            language : lenguaje,
            data : data,
            columns : [
                { 
                    data : 'id',
                    render : () => {      
                        return contador++;
                    }
                },
                { data : 'descripcion'},
              
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-warning" onclick="asignarValores('${row.id}', '${row.descripcion}')">Modificar</button>`
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

const modificarCalibre = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formCalibre);

    if(!formularioValido){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/ejemplo/API/Calibre/modificar'
        const body = new FormData(formCalibre);
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
            buscarCalibre();
            formCalibre.reset();
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

buscarCalibre();

window.asignarValores = (id, descripcion) => {
    formCalibre.id.value = id;
    formCalibre.descripcion.value = descripcion;
 
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
            const url = '/ejemplo/API/Calibre/eliminar'
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
    
                formCalibre.reset();
                buscarCalibre();
            }else{
                Toast.fire({
                    icon : 'error',
                    title : 'Ocurrió un error'
                })
            }
        }
    })
}

formCalibre.addEventListener('submit', guardarCalibre )
btnModificar.addEventListener('click', modificarCalibre);

