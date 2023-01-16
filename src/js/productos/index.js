import { Dropdown } from "bootstrap";
import { validarFormulario, Toast } from "../funciones";

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

formProductos.addEventListener('submit', guardarProducto )