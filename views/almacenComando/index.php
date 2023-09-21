<div class="row text-center">
    <div class="col">
        <h3>ALMACEN DE MUNICIÓN
            <?= $dependencia ?>
        </h3>
    </div>
    <input type="hidden" id="iddependencia" value="<?= $org_dep ?>">
</div>



<!--  -->

<div class="container-fluid">
    <div class="row justify-content-center">

        <form class="col-12 border p-2 mt-2 bg-light" enctype="multipart/form-data">
            <div class="col-10">
                <div class="row mb-3">

                    <div class="col-lg-8">
                        <div class="d-flex justify-content-center">


                            <a type=" button" class="btn btn-success m-1" data-bs-toggle="modal"
                                data-bs-target="#entradafab">Ingresos
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-bar-chart-steps" viewBox="0 0 16 16">
                                    <path
                                        d="M.5 0a.5.5 0 0 1 .5.5v15a.5.5 0 0 1-1 0V.5A.5.5 0 0 1 .5 0zM2 1.5a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-4a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-6a.5.5 0 0 1-.5-.5v-1zm2 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-1z" />
                                </svg>

                            </a>

                            <a type=" button" class="btn btn-danger m-1" data-bs-toggle="modal"
                                data-bs-target="#salidafab">Salidas
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-arrow-up-circle-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M16 8A8 8 0 1 0 0 8a8 8 0 0 0 16 0zm-7.5 3.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z" />
                                </svg>
                            </a>
                            <a type=" button" class="btn btn-info m-1" data-bs-toggle="modal"
                                data-bs-target="#HISTORIALmunicionfabrica">Historial
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z" />
                                    <path
                                        d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                </svg>
                            </a>
                            <!-- <a type=" button" class="btn btn-warning m-1" data-bs-toggle="modal"
                                data-bs-target="#Rechazofab">Rechazo Municion
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z" />
                                    <path
                                        d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                </svg>

                            </a> -->
                            <!-- <a type=" button" class="btn btn-secondary m-1" id="BtnAsignarmunicion"
                                name="BtnAsignarmunicion">Vista de Municion
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-calendar4-week" viewBox="0 0 16 16">
                                    <path
                                        d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM2 2a1 1 0 0 0-1 1v1h14V3a1 1 0 0 0-1-1H2zm13 3H1v9a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V5z" />
                                    <path
                                        d="M11 7.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-2 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm-3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1z" />
                                </svg>

                            </a> -->

                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="d-flex justify-content-end">

                            <a class="btn btn-warning m-1" data-bs-target='#reporteanterior' data-bs-toggle='modal'>

                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                    class="bi bi-stopwatch" viewBox="0 0 16 16">
                                    <path d="M8.5 5.6a.5.5 0 1 0-1 0v2.9h-3a.5.5 0 0 0 0 1H8a.5.5 0 0 0 .5-.5V5.6z" />
                                    <path
                                        d="M6.5 1A.5.5 0 0 1 7 .5h2a.5.5 0 0 1 0 1v.57c1.36.196 2.594.78 3.584 1.64a.715.715 0 0 1 .012-.013l.354-.354-.354-.353a.5.5 0 0 1 .707-.708l1.414 1.415a.5.5 0 1 1-.707.707l-.353-.354-.354.354a.512.512 0 0 1-.013.012A7 7 0 1 1 7 2.071V1.5a.5.5 0 0 1-.5-.5zM8 3a6 6 0 1 0 .001 12A6 6 0 0 0 8 3z" />
                                </svg> Reporte Dia <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                    fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                    <path
                                        d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                                </svg></a>

                        </div>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center p-2" id="divTabla">

                <div class="col-lg-10 p-2">

                    <table id="almacenComandoTabla" class="table table-bordered  table-responsive table-hover">

                        <thead>
                            <tr class="align-middle text-center">
                                <th>NO.</th>
                                <th>LOTE</th>
                                <th>CALIBRE</th>
                                <th>MOTIVO</th>
                                <th>CANTIDAD</th>
                                <th>DOCUMENTO</th>
                                <th>OBSERVACIONES</th>
                                <th>RECIBIDO POR</th>
                                <th>ASIGNADO A</th>
                                <th>DESIGNAR</th>

                                <!-- <th>ELIMINAR</th> -->
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



<!-- Modal entrada municion-->

<div class="modal fade" id="entradafab" name="modalPersonal" tabindex="-1" role="dialog"
    aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">

        <form id="formalmacenComando1" class="col-12 border p-2 mt-2 bg-light" enctype="multipart/form-data">

            <div class="modal-content">
                <div class="modal-header ">
                    <h5 class="modal-title " id="infoModalLabel">Entrada de Municion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="divTabla1">
                        <table class="table table-hover table-condensed table-bordered w-100" id="almacenComandoTabla1">
                            <thead class="table-dark text-center">
                                <tr class="align-middle text-center">
                                    <th>NO</th>
                                    <th>LOTE</th>
                                    <th>CALIBRE</th>
                                    <th>DESTINO</th>
                                    <th>CANTIDAD</th>
                                    <th>FECHA</th>
                                    <th>DOCUMENTO</th>
                                    <th>OBS</th>
                                    <th>RECIBIDO POR</th>
                                    <th>ASIGNADO A</th>
                                    <th>VALIDAR</th>

                                </tr>
                            </thead>
                            <tbody class="align-middle text-center">


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" id="BtnCerrar" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </form>


    </div>

</div>






<!-- Modal Salida municion-->



<div class="modal fade" id="salidafab" name="modalPersonal" tabindex="-1" role="dialog" aria-labelledby="infoModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form id="formSalida1" class="col-12 border p-2 mt-2 bg-light">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Salida de Municion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="divTabla1">
                        <table class="table table-hover table-condensed table-bordered w-100 text-center small"
                            id="SalidaFab1">
                            <thead class="table-dark text-center">
                                <tr class="align-middle text-center">
                                    <th>NO</th>
                                    <th>LOTE</th>
                                    <th>CALIBRE</th>
                                    <th>DESTINO</th>
                                    <th>CANT</th>
                                    <th>FECHA</th>
                                    <th>DOCUMENTO</th>
                                    <th>OBS</th>
                                    <th>COMANDO</th>
                                    <th>RECIBIDO POR</th>
                                    <th>ASIGNADO A</th>

                                </tr>
                            </thead>
                            <tbody class="align-middle text-center">


                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">


                    </div>

                </div>
            </div>
        </form>
    </div>
</div>



<!-- Modal HISTORIAL municion-->

<div class="modal fade" id="HISTORIALmunicionfabrica" name="modalPersonal" tabindex="-1" role="dialog"
    aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form id="formHistorial" class="col-12 border p-2 mt-2 bg-light">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Registro de Municion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="divTabla1">
                        <table class="table table-hover table-condensed table-bordered w-100 small" id="historialFab">
                            <thead class="table-dark text-center">
                                <tr class="align-middle text-center">
                                    <th>NO</th>
                                    <th>LOTE</th>
                                    <th>CALIBRE</th>
                                    <th>DESTINO</th>
                                    <th>CANT</th>
                                    <th>DOCUMENTO</th>
                                    <th>OBS</th>
                                    <th>MOVIMIENTO</th>
                                    <th>FECHA</th>
                                    <th>RECIBIDO POR</th>
                                    <th>ASIGNADO POR</th>
                                    <!-- <th>COMANDO</th> -->
                                    <!-- <th>SITUACION</th> -->

                                </tr>
                            </thead>
                            <tbody class="align-middle text-center">


                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <!--  -->
                    </div>

                </div>
            </div>
        </form>
    </div>
</div>




<!-- Modal Modal GENERAR Salida municion-->
<div class="modal fade" id="GenerarSalida" name="GenerarSalida" tabindex="-1" role="dialog"
    aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content small">
            <div class="modal-header ">
                <h5 class="modal-title " id="infoModalLabel">Traslado de Municion a Batallon</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body container">


                <form class="badge-light p-1 was-validated" id="formDatosTablaFabrica">
                    <input type="hidden" name="id1" id="id1">
                    <input type="hidden" name="catalogo1" id="catalogo1">
                    <input type="hidden" name="idcomando" id="idcomando" value="<?= $org_dep ?>">
                    <div class="row mb-3">
                        <div class='col-lg-4'>
                            <label for="lote">
                                LOTE
                            </label>
                            <input type="hidden" id="idlote1" name="idlote1" class="form-control" required readonly>
                            <input type="text" id="lote1" name="lote1" class="form-control" required readonly>

                        </div>
                        <div class='col-lg-4'>
                            <label for="calibre">
                                CALIBRE
                            </label>
                            <input type="hidden" id="idcalibre1" name="idcalibre1" class="form-control" required
                                readonly>
                            <input type="text" id="calibre1" name="calibre1" class="form-control" required readonly>
                        </div>
                        <div class='col-lg-4'>
                            <label for="cantidad">
                                CANTIDAD ACTUAL
                            </label>
                            <input type="text" id="cantidad1" name="cantidad1" class="form-control" required readonly>

                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class='col-lg-4'>
                            <label for="motivo">
                                MOTIVO
                            </label>
                            <input type="hidden" id="idmotivo1" name="idmotivo1" class="form-control" required readonly>
                            <input type="text" id="motivo1" name="motivo1" class="form-control" required readonly>

                        </div>
                        <div class="col-lg-8">
                            <label for="documento1">DOCUMENTO DE REFERENCIA</label>
                            <input type="text" name="documento1" id="documento1" class="form-control"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                readonly>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="observaciones1">OBSERVACIONES DE MUNICION</label>
                            <textarea type="tex" name="observaciones1" id="observaciones1" class="form-control" rows="3"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                                readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-4">
                            <label for="select_movimiento">BATALLON</label>
                            <select class="form-control" name="batallon" id="batallon" required>
                                <option value="">Seleccione ...</option>
                                <?php foreach ($batallon as $batallon):
                                    $id = $batallon['id_dependencia'];
                                    $jerarquia = $batallon['jerarquia'];
                                    $nombre = $batallon['nombre'];
                                    ?>
                                    <option value="<?= $jerarquia ?>"><?= $nombre ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class='col-lg-4'>
                            <label> CANTIDAD A ENVIAR </label>
                            <input type="number" id="cantidadnew1" name="cantidadnew1" class="form-control" required>
                        </div>
                        <div class="col-lg-4">
                            <label for="catalogo">CATALOGO</label>
                            <input type="text" class="form-control text-center" id="catalogoTraslado"
                                name="catalogoTraslado" maxlength="8" value="" required>
                            <span class="form-text text-center" id="textNombreTraslado"></span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col">
                            <button id="btnTrasladar" type="submit" class="btn btn-success w-100">Trasladar</button>
                        </div>

                    </div>

                </form>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                <!-- <button type="submit" form="formIngreso" class="btn btn-primary" id="buttonGuardar">Guardar información</button> -->
            </div>
        </div>
    </div>
</div>
<!-- Modal Modal GENERAR Regreso municion-->
<div class="modal fade" id="GenerarRegreso" name="GenerarRegreso" tabindex="-1" role="dialog"
    aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
        <div class="modal-content small">
            <div class="modal-header ">
                <h5 class="modal-title " id="infoModalLabel">Regreso de Municion a Comando</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body ">


                <form class="badge-light p-1 was-validated" id="formdatosTablaRegreso">
                    <input type="hidden" name="id1" id="id1">

                    <div class="row mb-3">
                        <div class='col-lg-6'>
                            <label for="lote">
                                LOTE
                            </label>
                            <input type="hidden" id="idlote1" name="idlote1" class="form-control" required readonly>
                            <input type="text" id="lote1" name="lote1" class="form-control" required readonly>

                        </div>
                        <div class='col-lg-6'>
                            <label for="calibre">
                                CALIBRE
                            </label>
                            <input type="hidden" id="idcalibre1" name="idcalibre1" class="form-control" required
                                readonly>
                            <input type="text" id="calibre1" name="calibre1" class="form-control" required readonly>


                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class='col-lg-6'>
                            <label for="motivo">
                                MOTIVO
                            </label>
                            <input type="hidden" id="idmotivo1" name="idmotivo1" class="form-control" required readonly>
                            <input type="text" id="motivo1" name="motivo1" class="form-control" required readonly>

                        </div>
                        <div class='col-lg-6'>
                            <label for="cantidad">
                                CANTIDAD ACTUAL
                            </label>
                            <input type="text" id="cantidad1" name="cantidad1" class="form-control" required readonly>


                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class='col-lg-4'>
                            <label> CANTIDAD A ENVIAR </label>
                            <input type="number" id="cantidadnew1" name="cantidadnew1" class="form-control" required>
                        </div>
                        <div class="col-lg-8">
                            <label for="documento1">DOCUMENTO DE REFERENCIA</label>
                            <input type="text" name="documento1" id="documento1" class="form-control"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()">
                        </div>


                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="observaciones1">OBSERVACIONES DE MUNICION</label>
                            <textarea type="tex" name="observaciones1" id="observaciones1" class="form-control" rows="3"
                                onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <button id="btnRegreso" type="submit" class="btn btn-success w-100">Regreso</button>
                        </div>

                    </div>

                </form>



            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>

            </div>
        </div>
    </div>
</div>


<!-- Modal Rechazo municion-->



<div class="modal fade" id="Rechazofab" name="modalPersonal" tabindex="-1" role="dialog"
    aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form id="formRechazo1" class="col-12 border p-2 mt-2 bg-light">
            <div class="modal-content small">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Rechazo de Municion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="divTabla1">
                        <table class="table table-hover table-condensed table-bordered w-100 text-center"
                            id="RechazoAlmacen">
                            <thead class="table-dark text-center">
                                <tr class="align-middle text-center">
                                    <th>NO</th>
                                    <th>LOTE</th>
                                    <th>CALIBRE</th>
                                    <th>DESTINO</th>
                                    <th>CANT</th>
                                    <th>FECHA</th>
                                    <th>DOCUMENTO</th>
                                    <th>OBS</th>
                                    <th>COMANDO</th>
                                    <!-- <th>FECHA</th> -->

                                </tr>
                            </thead>
                            <tbody class="align-middle text-center">


                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="BtnCerrar"
                            data-bs-dismiss="modal">Close</button>

                    </div>

                </div>
            </div>
        </form>
    </div>
</div>
<!-- Modal Rechazo municion-->



<div class="modal fade" id="asignadoAlmacen" name="asignadoAlmacen" tabindex="-1" role="dialog"
    aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <form id="formalmacenComandoAsignado" class="col-12 border p-2 mt-2 bg-light" enctype="multipart/form-data">

            <div class="modal-content small">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Municion Asignada</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive" id="divTablaASIG">
                        <table class="table table-hover table-condensed table-bordered w-100 text-center"
                            id="almacenComandoAsignado">
                            <thead class="table-dark text-center">
                                <tr class="align-middle text-center">
                                    <th>NO</th>
                                    <th>LOTE</th>
                                    <th>CALIBRE</th>
                                    <th>CANT</th>
                                    <th>MOTIVO</th>
                                    <th>DOCUMENTO</th>
                                    <th>OBS</th>
                                    <th>FECHA</th>
                                    <th>COMANDO</th>
                                    <th>BATALLON</th>

                                    <th>CUATRIMESTRE</th>

                                    <!-- <th>FECHA</th>
                                    <th>FECHA</th>
                                    <th>FECHA</th> -->

                                </tr>
                            </thead>
                            <tbody class="align-middle text-center">


                            </tbody>
                        </table>
                    </div>



                </div>
            </div>

        </form>
    </div>
</div>
<script src="build/js/almacenComando/index.js"></script>