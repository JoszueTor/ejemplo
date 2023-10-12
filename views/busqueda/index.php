<div class="row text-center">
    <div class="col">
        <h1>Formulario Ingreso de Munición Almacen</h1>
    </div>
</div>
<div class="row justify-content-center">
    <form id="formbusqueda" class="col-lg-8 border rounded bg-light p-3">
        <input type="hidden" name="id" id="id">

        <div class="row mb-3">
            <div class="col-4">
                <label for="select_lote">Lote</label>
                <select class="form-control" name="lote" id="lote">
                    <option value="">Seleccione ...</option>
                    <?php foreach ($lote as $fila): ?>
                        <option value="<?= $fila['id'] ?>">
                            <?= $fila['descripcion'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-4">
                <label for="select_calibre">Calibre</label>
                <select class="form-control" name="calibre" id="calibre">
                    <option value="">Seleccione ...</option>
                    <?php foreach ($calibre as $calibre): ?>
                        <option value="<?= $calibre['id'] ?>">
                            <?= $calibre['descripcion'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-4">
                <label for="select_movimiento">Motivo</label>
                <select class="form-control" name="motivo" id="motivo">
                    <option value="">Seleccione ...</option>
                    <?php foreach ($movimiento as $movimiento): ?>
                        <option value="<?= $movimiento['id'] ?>">
                            <?= $movimiento['descripcion'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
        </div>
        <div class="row mb-3">
           
            <div class="col-lg-4">
                <label for="catalogo">Catalogo</label>
                <input type="text" class="form-control" id="catalogo" name="catalogo" maxlength="8" value="">
                <span class="form-text" id="textNombre"></span>
            </div>
            <div class="col-lg-4">
                <label for="select_movimiento">Comando</label>
                <select class="form-control" name="comando" id="comando">
                    <option value="">Seleccione ...</option>
                    <?php foreach ($comando as $comando): ?>
                        <option value="<?= $comando['dep_llave'] ?>">
                            <?= $comando['dep_desc_md'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
           
        </div>
       

        <div class="row mb-3">
            <div class="col">
                <button id="buscar" type="submit" class="btn btn-primary w-100">Buscar</button>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col">
                <button id="imprimir" type="button" class="btn btn-success w-100">Imprimir</button>
            </div>

        </div>
    </form>
</div>

<!--  -->

<div class="container-fluid">
    <div class="row justify-content-center">

        <form class="col-12 border p-2 mt-2 bg-light" enctype="multipart/form-data">
            
            <div class="row justify-content-center  p-2" id="divTabla">
                <div class="col-lg-10 p-2">
                    <table id="busquedaTabla"
                        class="table table-bordered  table-responsive table-hover small middle">
                        <thead>
                            <tr class="align-middle text-center">
                                <th>NO.</th>
                                <th>LOTE</th>
                                <th>CALIBRE</th>
                                <th>MOTIVO</th>
                                <th>COMANDO</th>
                                <th>CANTIDAD</th>
                              
                             
                            </tr>
                        </thead>
                        <tbody class="align-middle text-center">

                        </tbody>
                    </table>
                </div>


            </div>

        </form>

    </div>
</div>







<script src="build/js/busqueda/index.js"></script>