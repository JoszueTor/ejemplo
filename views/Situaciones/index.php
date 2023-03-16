<div class="row text-center">
    <div class="col">
        <h1>Situaciones</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formSituaciones" class="col-lg-4 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">
        <div class="row mb-3">
            <div class="col-lg-12">
                <label for="descripcion">Descripcion del Situaciones</label>
                <input type="text" name="descripcion" id="descripcion" class="form-control" onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col">
                <button id="btnGuardar" type="submit" class="btn btn-primary w-100">Guardar</button>
            </div>
            <div class="col">
                <button id="btnModificar" type="button" class="btn btn-warning w-100">Modificar</button>
            </div>
        </div>
    </form>
</div>
<div class="row justify-content-center" id="divTabla">
    <div class="col-lg-10">
        <table id="SituacionesTabla" class="table table-bordered table-hover w-100">
            <thead>
                <tr>
                    <th>NO.</th>
                    <th>NOMBRE</th>
                    
                    <th>MODIFICAR</th>
                    <th>ELIMINAR</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
<script src="build/js/Situaciones/index.js"></script>