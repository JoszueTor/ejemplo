import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";
import Swal from "sweetalert2";



const btnGuardar = document.getElementById('btnGuardar');
const btnModificar = document.getElementById('btnModificar');
const divTabla = document.getElementById('divTabla');
let tablaLote = new Datatable('#tablalote');

const formLote = document.getElementById('formLote')


const guardarLote = async (evento) => {
    evento.preventDefault();

    let formularioValido = validarFormulario(formLote, ['id']);
    if (!formularioValido) {
        Toast.fire({
            icon: 'warning',
            title: 'Debe llenar todos los campos'
        })
        return;
    }



    try {
        //Crear el cuerpo de la consulta
        const url = '/ejemplo/API/Lote/guardar'
        const body = new FormData(formLote);
        body.delete('id');
        const headers = new Headers();
        headers.append("X-Requested-With", "fetch");

        const config = {
            method: 'POST',
            headers,
            body
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        
        const { resultado, mensaje } = data;
        // const resultado = data.resultado;
        // console.log(data);
        
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

        console.log(data);

        
        tablaLote.destroy();
        let contador = 1;
        tablaLote = new Datatable('#tablaLote', {
            language : lenguaje,
            data : data,
            columns : [
                { 
                    data : 'lote_id',
                    render : () => {      
                        return contador++;
                    }
                },
                { data : 'lote_id'},
               
                { 
                    data : 'lote_id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-warning" onclick="asignarValores('${row.id}', '${row.desc}', '${row.dep}')">Modificar</button>`
                    } 
                },
                { 
                    data : 'lote_id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-danger" onclick="eliminarRegistro('${row.lote_id}')">Eliminar</button>`
                    } 
                },
            ]
        })

    } catch (error) {
        console.log(error);
    }
}

buscarLote();

window.asignarValores = (id, nombre, precio) => {
    formProductos.id.value = id;
    formProductos.nombre.value = nombre;
    formProductos.precio.value = precio;
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
    
                formProductos.reset();
                buscarProducto();
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






