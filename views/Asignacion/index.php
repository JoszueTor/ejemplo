<div class="row text-center">
    <div class="col">
        <h3>ASIGNACION
            <?= $dependencia ?>

        </h3>
    </div>
</div>
<input type="text" id="identificacion" name="identificacion" value="<?= $org_dep ?>">
<div class="container-fluid">
    <div class="row text-center justify-content-center">
        <form id="formTabla" class="col-lg-12 ">
            <table class="table table-hover table-condensed table-bordered w-100 small" id="tablaComando">
                <thead class="table-dark ">

                    <tr>
                        <th>No.</th>
                        <th>Calibre</th>
                        <th>Lote</th>
                        <th>Cantidad</th>
                        <th>Almacen</th>

                    </tr>
                </thead>
                <tbody>
              
                </tbody>

            </table>

        </form>

    </div>



    <script src="build/js/Asignacion/index.js"></script>