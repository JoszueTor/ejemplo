const formulario = document.getElementById('formBusqueda')

const obtenerProductos = async (e) => {
    e.preventDefault();
    let id = formulario.id.value
    try{
        const url = `/ejemplo/api/productos?id=${id}`;
        const config = {
            method : 'GET'
        }

        const response = await fetch(url, config);
        const productos = await response.json();

        console.log(productos);
    }catch(e){
        console.log(e);
    }
}


formulario.addEventListener('submit', obtenerProductos)