<!-- Add Mark Modal -->
<div class="modal fade" id="addMarkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adaugarea Notei</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class='row'>
				<div class="col-xs-12 col-md-3">
					<div>
						<label for="amMark">Nota</label> 
						<input type="number" id="amMark" class='form-control' min='1' max='10' required/><br /> 
					</div>
				</div>
				<div class="col-xs-12 col-md-3">
					<div>
						<label for="amMonth">Luna</label> 
						<input type='number' id="amMonth" class='form-control' min='<?php echo $semMin; ?>' max='<?php echo $semMax; ?>' required/><br /> 
					</div>
				</div>
				<div class="col-xs-12 col-md-3">
					<div>
						<label for="amDay">Ziua</label> 
						<input type='number' id="amDay" class='form-control' min='1' max='31' required/><br /> 
					</div>
				</div>
				<div class="col-xs-12 col-md-3">
					<label for="amTest">Test</label>
					<label class="switch">
						<input type="checkbox" id="amTest">
						<span class="slider round"></span>
					</label>
				</div>
				<input type="hidden" id='amUserId'>
				<input type="hidden" id='amLesson'>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Inchide</button>
        <button type="button" class="btn btn-primary" id='amSubmitButton'>Salveaza</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Mark Modal-->
<div class="modal fade" id="deleteMarkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Stergerea Notei</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<h3>Doriti sa stergeti aceasta nota?</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Inchide</button>
        <button type="button" class="btn btn-danger" id='dmSubmitButton'>Stergere</button>
      </div>
    </div>
  </div>
</div>

<!-- Edit Mark Modal-->
<div class="modal fade" id="editMarkModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editarea Notei</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class='row'>
				<div class="col-xs-12 col-md-3">
					<div>
						<label for="edMark">Nota</label> 
						<input type="number" id="edMark" class='form-control' min='1' max='10' required/><br /> 
					</div>
				</div>
				<div class="col-xs-12 col-md-3">
					<div>
						<label for="edMonth">Luna</label> 
						<input type='number' id="edMonth" class='form-control' min='<?php echo $semMin; ?>' max='<?php echo $semMax; ?>' required/><br /> 
					</div>
				</div>
				<div class="col-xs-12 col-md-3">
					<div>
						<label for="edDay">Ziua</label> 
						<input type='number' id="edDay" class='form-control' min='1' max='31' required/><br /> 
					</div>
				</div>
				<div class="col-xs-12 col-md-3">
					<label for="edTest">Test</label>
					<label class="switch">
						<input type="checkbox" id="edTest">
						<span class="slider round"></span>
					</label>
				</div>
				<input type="hidden" id='edUserId'>
				<input type="hidden" id='edLesson'>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Inchide</button>
        <button type="button" class="btn btn-danger" id='edSubmitButton'>Editeaza</button>
      </div>
    </div>
  </div>
</div>

<!-- Add Absence Modal -->
<div class="modal fade" id="addAbsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adaugarea Absentei</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class='row'>
				<div class="col-xs-12 col-md-4">
					<div>
						<label for="abType">Tipul</label> 
						<select id="abType" class='form-control'>
							<option value="1">Motivat</option>
							<option value="2">Nemotivat</option>
						</select>
					</div>
				</div>
				<div class="col-xs-12 col-md-4">
					<div>
						<label for="abMonth">Luna</label> 
						<input type='number' id="abMonth" class='form-control' min='<?php echo $semMin; ?>' max='<?php echo $semMax; ?>' required/><br /> 
					</div>
				</div>
				<div class="col-xs-12 col-md-4">
					<div>
						<label for="abDay">Ziua</label> 
						<input type='number' id="abDay" class='form-control' min='1' max='31' required/><br /> 
					</div>
				</div>
				<input type="hidden" id='abUserId'>
				<input type="hidden" id='abLesson'>
			</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Inchide</button>
        <button type="button" class="btn btn-primary" id='abSubmitButton'>Salveaza</button>
      </div>
    </div>
  </div>
</div>

<!-- Delete Absence Modal-->
<div class="modal fade" id="deleteAbsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Stergerea Absentei</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<h3>Doriti sa stergeti aceasta absenta?</h3>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Inchide</button>
        <button type="button" class="btn btn-danger" id='daSubmitButton'>Stergere</button>
      </div>
    </div>
  </div>
</div>

<!-- Add a new student -->
<div class="modal fade" id="addStudentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adaugarea Elevului</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
				<form action="" id='addUsrForm' style='width: 100%;'>
					<label for="">Nume</label>
					<input type="text" name='lastname' class='form-control' required>
					<label for="">Prenume</label>
					<input type="text" name='firstname' class='form-control' required>
					<label for="">Limba Invatata</label>
					<?php if($profil == 'real'): ?>
						<select name="language" id="" class='form-control'>
							<option value="eng">Engleza</option>
							<option value="franc">Franceza</option>
						</select>
					<?php endif; if($profil == 'uman' || $profil == 'art'): ?>
						<input type="hidden" name='language' value='both'>
					<?php endif; ?>
				</form>
			</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Inchide</button>
        <button type="button" class="btn btn-primary" id='addUsrSubmitButton'>Salveaza</button>
      </div>
    </div>
  </div>
</div>

<!-- Assign Lessons -->
<div class="modal fade" id="editAssignLesson" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editarea Atribuirii</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <div class='row assignUsrModalList'>
		
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Inchide</button>
        <button type="button" class="btn btn-success" id='editAssignButton'>Salveaza</button>
      </div>
    </div>
  </div>
</div>
