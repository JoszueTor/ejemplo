
<style>
    ul {
        list-style-type: none;
    }


    #cuadroSinoptico ul {
        /* margin-left: 20px; */
        padding: 5px;
        border: 1px solid #ccc;
        background-color: #f9f9f9;

    }
</style>


<div class="row text-center">
    <div class="col">
        <h3>INSPECTORIA GENERAL
            <?= $dependencia ?>
        </h3>
    </div>
    <input type="hidden" id="iddependencia" value="<?= $org_dep ?>">
</div>
<form class="badge-light p-1 was-validated " id="formDatosRegistroComando">
    <div class="col-12 mb-5 text-center">
        <label for="select_movimiento">COMANDO</label>
        <select class="form-control text-center" name="comando" id="comando">
            <option value="" type="text">Seleccione Comando</option>
            <?php foreach ($comando as $comando): ?>
                <option value="<?= $comando['dep_llave'] ?>">
                    <?= $comando['dep_desc_lg'] ?>
                </option>
            <?php endforeach ?>
        </select>
    </div>
    <div class="modal-body">
        <div class="container ">

            <div class=" text-center " id="cuadroSinoptico">

            </div>

        </div>


    </div>
</form>

<script src="build/js/inspectoriaG/index.js"></script>