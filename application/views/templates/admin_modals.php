<!-- Show the classes list -->
<div class="modal fade" id="addClassesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adaugarea Obiectului</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
			<form action="#" id="addObjectForm">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<input type="text" class='form-control' id='obj_name' required>
					</div>

					<div class="col-xs-8 col-md-8" style='margin-top: 5px;'>
						<select id="avgTypeObj" class='form-control'>
							<option value="de">50 / 50</option>
							<option value="pr">60 / 40</option>
						</select>
					</div>

					<div class="col-xs-4 col-md-4" style='margin-top: 5px;'>
						<button class='btn btn-success' style='width: 100%;'>Submit</button>
					</div>
				</div>
			</form>
		</div>
    </div>
  </div>
</div>

<!-- Show the classes list -->
<div class="modal fade" id="showClassesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Lista Claselor Active</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
			<ul class="list-group activeClassesList">
				
			</ul>
		</div>
    </div>
  </div>
</div>

<!-- Show the classes list -->
<div class="modal fade" id="regClassModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adaugarea Clasei</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
		<div class="modal-body">
			<form action="#" id="regClassForm">
				<div class="row">
					<div class="col-12 col-xs-12 col-md-12">
						<label for="">Nume</label>
						<input type="text" class='form-control' id='dirLastName' required>
					</div>
					
					<div class="col-12 col-xs-12 col-md-12">
						<label for="">Prenume</label>
						<input type="text" class='form-control' id='dirFirstName' required>
					</div>

					<div class="col-4 col-xs-4 col-md-4" style='margin-top: 5px;'>
						<label for="">Clasa (ex: 10B)</label>
						<input type="text" class='form-control'  id='regClassClassname' required>
					</div>

					<div class="col-4 col-xs-4 col-md-4" style='margin-top: 5px;'>
						<label for="">Ani de studii</label>
						<input type="number" class='form-control'  id='regClassYears' min='1' max='3' required>
					</div>

					<div class="col-4 col-xs-4 col-md-4" style='margin-top: 5px;'>
						<label for="">Profil</label>
						<select class='form-control' id="regUsrProfil">
							<?php if($type == 'lc'):?>
								<option value="real">Real</option>
								<option value="uman">Umanist</option>
								<option value="arte">Arte</option>
							<?php endif;?>
							<?php if($type == 'cld'):?>
								<!-- TODO: Fill it with the cook's profiles -->
							<?php endif;?>
						</select>
					</div>

					<div class="col-12 col-xs-12 col-md-12" style='margin-top: 15px;'>
						<button class='btn btn-success' style='width: 100%;'>Acceptare</button>
					</div>
				</div>
			</form>
		</div>
    </div>
  </div>
</div>