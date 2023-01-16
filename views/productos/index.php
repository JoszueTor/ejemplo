<div class="row text-center">
    <div class="col">
        <h1>Productos</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formProductos" class="col-lg-4 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="nombre">Nombre del producto</label>
                <input type="text" name="nombre" id="nombre" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="precio">Precio del producto</label>
                <input type="number" name="precio" id="precio" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <button class="btn btn-primary w-100">Guardar</button>
            </div>
        </div>
    </form>
</div>

<script src="build/js/productos/index.js"></script>