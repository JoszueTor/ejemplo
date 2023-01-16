
import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";
import Datatable from 'datatables.net-bs5';
import { lenguaje } from "../lenguaje";

const formProductos = document.getElementById('formProductos');

const guardarProducto = async (evento) => {
    evento.preventDefault();
    
    let formularioValido = validarFormulario(formProductos, ['id']);

    if(!formularioValido || formProductos.precio.value < 1 ){ 
        Toast.fire({
            icon : 'warning',
            title : 'Debe llenar todos los campos'
        })
        return;
    }

    try {
        //Crear el cuerpo de la consulta
        const url = '/ejemplo/API/productos/guardar'
        const body = new FormData(formProductos);
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

            formProductos.reset();
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

const buscarProducto = async (evento) => {
    evento && evento.preventDefault();

    try {
        const url = '/ejemplo/API/productos/buscar'
        const headers = new Headers();
        headers.append("X-requested-With", "fetch");

        const config = {
            method : 'GET',
        }

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        // console.log(data);

        const tablaProductos = new Datatable('#productosTabla');
        tablaProductos.destroy();

        new Datatable('#productosTabla', {
            language : lenguaje,
            data : data,
            columns : [
                { data : 'id'},
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
                        return `<button class="btn btn-warning">Modificar</button>`
                    } 
                },
                { 
                    data : 'id',
                    'render': (data, type, row, meta) => {
                        return `<button class="btn btn-danger">Eliminar</button>`
                    } 
                },
            ]
        })

    } catch (error) {
        console.log(error);
    }
}

buscarProducto();

formProductos.addEventListener('submit', guardarProducto )

