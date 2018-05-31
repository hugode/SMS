<?php if ($this->input->get('opt')=='' || !$this->input->get('opt'))
{show_404();}?>
<div id="kerkesa" style="display: none;"><?php echo $this->input->get('opt');?></div>
<ol class="breadcrumb">
	<li><a href="<?php echo base_url('dashboard') ?>">Home</a></li>
	<?php
	if($this->input->get('opt')=='mngms')
	{echo ' <li class="active">Menagjo Marksheet</li>';}
	else if ($this->input->get('opt')=='mngmk')
	{echo ' <li class="active">Menagjo Marks</li>';}
	?>
</ol>
<?php if($this->input->get('opt')=='mngms'){?>
	<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading " ><h4><b>Klaset Aktuale te Regjistruara<b></h4></div>
			<ul class="nav nav-pills nav-stacked">
				<?php if($classData) {
					$x=1;
					foreach ($classData as $value){
						?>
						<li role="presentation"><a role="tab" data-toggle="tab" class="list-group-item classSideBar"  id="classId<?php echo$value['class_id']?>"
												   onclick="getClassMarksheet(<?php echo$value['class_id']?>)"><b><!--fUNKSIONI getClassSection e perdorim kur ta ndrrojm klasen te
						ekzekutohet qaj funksion me qit id te shfaq te dhana-->
									<?php echo $value['class_name'] ?>(<?php echo $value['numeric_name']?>)
								</b></a></li>
						<?php
						$x++;
					}
				} else{
					?>
					<a href="" class="list-group-item">No data</a>
					<?php
				} ?>
			</ul>
		</div>
	</div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">Menage Marksheet</div>
			<div class="panel-body">
				<div id="message"></div>
				<div class="result">
					<!--Ne kete div class result shfaqen te gjitha te dhenat te cilat vin prej funksionit getClassSection()
					ku bene te mundur permes class id te shfaqen te gjith section te cilat kane kete classid-->
				</div>
			</div>
	</div>
</div>
</div>


<?php
}else if( $this->input->get('opt')=='mngmk'){


}?>

<script type="text/javascript" src="custom/js/marksheet.js"></script>
