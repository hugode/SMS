<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<li class="active">Manage Classes</li>
</ol>
<!-------------------------------------------------------->
<div class="panel panel-default">
	<div class="panel-heading">Classe</div>
	<div class="panel-body">
		<div id="message"></div>

		<div class="pull pull-right">
			<!-- Button trigger modal -->
			<button type="button" class="btn btn-success" data-toggle="modal" data-target="#addClass" id="addClassModelBtn" >
				<i class="glyphicon glyphicon-plus-sign"></i> Add Class
			</button>
		</div>
		<br/><br/><br/><br/><br/>
		<table id="manageClassTable" class="table table-responsive table-bordered">
			<thead>
			<tr>
				<th>ID</th>
				<th>Emri i Klases</th>
				<th>Numri i Klases</th>
				<th>Action</th>
			</tr>

			</thead>
		</table>
	</div>
</div>
<!--Shto classen modeli-->
<div class="modal fade" tabindex="-1" role="dialog" id="addClass">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Shto Klasen</h4>
			</div>
			<form class="form-horizontal" method="post" id="createClassForm" action="<?php echo base_url('classes/create')?>">
			    <div class="modal-body">
					<div id="class-message"></div><!--Shfaqja e mesazhit-->
					<!--Form grupi-->
					<div class="form-group">
						 <label for="className" class="col-sm-4 control-label">Emri i Klases:</label>
						<div class="col-sm-8">
							<input type="text" id="className" name="className" class="form-control" placeholder="Emri i Klases">
						</div>
					</div>
					<!------------------------------------------------------------>
					<div class="form-group">
						<label for="numricName" class="col-sm-4 control-label">Numri i Klases:</label>
						<div class="col-sm-8">
							<input type="text" id="numricName" name="numricName" class="form-control" placeholder="Numri i Klases">
						</div>
					</div>



			    </div>
			    <div class="modal-footer">
				   <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				   <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
			    </div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--Moduli per editimin e klases-->
<div class="modal fade" tabindex="-1" role="dialog" id="editClass">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Edito Klasen</h4>
			</div>
			<form class="form-horizontal" method="post" id="editClassForm" action="<?php echo base_url().'classes/update'?>">
				<div class="modal-body">
					<div id="edit-message"></div><!--Shfaqja e mesazhit-->
					<!--Form grupi-->
					<div class="form-group">
						<label for="editClassName" class="col-sm-4 control-label">Emri i Klases:</label>
						<div class="col-sm-8">
							<input type="text" id="editClassName" name="editClassName" class="form-control" placeholder="Emri i Klases">
						</div>
					</div>
					<!------------------------------------------------------------>
					<div class="form-group">
						<label for="editNumricName" class="col-sm-4 control-label">Numri i Klases:</label>
						<div class="col-sm-8">
							<input type="text" id="editNumricName" name="editNumricName" class="form-control" placeholder="Numri i Klases">
						</div>
					</div>



				</div>
				<div class="modal-footer">
					<input type="hidden" name="edit_class_id" id="edit_class_id" value="">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" name="submit" id="edit" class="btn btn-primary">Ruaj Ndryshimin</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--Fshirja e klases------------------------------------------------------------------------->
<div class="modal fade" tabindex="-1" role="dialog" id="removeClassModel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Fshirja e Klases</h4>
			</div>
				<div class="modal-body">
					<div id="remove-message"></div><!--Shfaqja e mesazhit-->
					<p>A jeni i sigurt per fshirjen e klases</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id="mbyll" data-dismiss="modal">Mbyll</button>
					<button type="submit" name="removeBtn" id="removeBtn" class="btn btn-danger">Po</button>
				</div>

		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--JavaScript extenal file--------------------------------------------------------------------->
<script type="text/javascript" src="<?php echo base_url('custom/js/classes.js')?>"></script>

