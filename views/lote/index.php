<div class="row text-center">
    <div class="col">
        <h1>Registro de Lotificacion</h1>
    </div>
</div>


<div class="container-fluid">
        <div class="row justify-content-center">
            <center>
                <form class="col-12 border p-2 mt-5 bg-light" enctype="multipart/form-data">
                    <div class="col-10">


                        <div class="row mb-3">


                            <div class="col-lg-4 p-1">


                                <div class="d-flex justify-content-start">


                                    <a class="btn btn-success w-20" data-bs-target='#modallote'
                                        data-bs-toggle='modal'>Ingrese Nuevo Lote<svg xmlns="http://www.w3.org/2000/svg"
                                            width="16" height="16" fill="currentColor" class="bi bi-bookmark-plus"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z" />
                                            <path
                                                d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z" />
                                        </svg></a>


                                </div>
                            </div>
                        </div>
                        <table class="table table-bordered table-hover">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th>NO</th>
                                    <th>LOTE</th>
                                    <th>MODIFICAR</th>
                                    <th>ELIMINAR</th>

                                </tr>
                            </thead>
                            



                            </tbody>


                        </table>






                </form>
            </center>
        </div>
    </div>


<!-- //MODAL LOTE -->

<div class="modal fade" id="modallote" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Nuevo Lote</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <form class="col-12 border bg-light" enctype="multipart/form-data">

              <div class="row mb-3">


                <div class="col-lg-12">

                  <!-- <label for="lote">Tipo de Lote</label> -->
                  <input type="text" name="lote" id="lote" maxlgth="50" minlength="2" class="form-control"
                    onKeyUp="document.getElementById(this.id).value=document.getElementById(this.id).value.toUpperCase()"
                    require>

                </div>

              </div>



              <div class="col-lg-12">
                <br>
                <input class="btn btn-warning form-control bg-success" value="GUARDAR" data-bs-dismiss="modal"
                  onclick="guardarlote()" required></input>
              </div>



          </div>

          </form>
          <div class="col-lg-12">

            <br>
            <button type="button" class="btn btn-secondary form-control bg-danger" data-bs-dismiss="modal"
              id="cerrar">CERRAR</button>
          </div>
        </div>

      </div>
    </div>






<script src="build/js/Lote/index.js"></script>