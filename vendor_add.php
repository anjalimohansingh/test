<?php
        $mod=$_GET['mod']; 
	$page=$_REQUEST['page'];
?>
<script type="text/javascript">
	function int(id)
	{
		var field=document.getElementById(id);
		if (isNaN(field.value))
		{
			alert ("Please Enter a Numeric value");
			field.focus();
		}
	}
	function check()
	{ 
		if(document.manual_time_new.venname.value=='')
		{
			alert("Please enter a vendor name");
			document.manual_time_new.venname.focus();
		}
		else if(document.manual_time_new.qc_rq.value=='')
		{
			alert("Select QC Require");
			document.manual_time_new.qc_rq.focus();
		}	
		else
		{
			document.manual_time_new.submit();
		}
	}
</script>
<div id="content_inner">
  	<div class="page_header">
	<div id="search"></div></div></div>
    <div id="quick_access_overview"></div>
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1>Vendor Master <?php if($mod=='add'){ echo "Add";}else{ echo "Edit";}?></h1>
				</div>
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="index.php">Home</a></li>
						<li class="breadcrumb-item "><a href="#">Master</a></li>
						<li class="breadcrumb-item active">Vendor Master</li>
					</ol>
				</div>
			</div>
		</div><!-- /.container-fluid -->
		
		<!-- Main content -->
		<section class="content">
			<div class="container-fluid">
				<!-- SELECT2 EXAMPLE -->
				<div class="card">
					<div class="card-header">
						<h3 class="card-title">Enter Details</h3>
					</div>
					
					
					
					<?php
						
						
						
						if($mod=="edt")
						{
							$vencode=$_REQUEST['vendorcode'];
                                                        $sql="select * from vendormaster where `Vendor_Id`='$vencode'  AND Vendor_Del=0";
							$ret=mysql_query($sql);
							$row=mysql_fetch_object($ret);
							$venname.=$row->Vendor_Name;
                                                        $qc_rq=$row->Qc_Req;
                                                       
						}
						if($mod=="add")
						{
							$sql="select max(Vendor_Id) as maxvendor from vendormaster";
							$ret=mysql_query($sql);	
							$row=mysql_fetch_object($ret);	 
							if(mysql_num_rows($ret))
							{
								$vencode.=$row->maxvendor+1;
							}
						}
					?>  
					
					
					<!-- /.card-header -->
					<div class="col-md-6">
						<form class="form-horizontal" action="vendor_validate.php" method="post" name="manual_time_new" id="manual_time_new" >
							<div class="card-body">
                                                                                <input name="mod" value="<?=$mod?>" type="hidden" />	
										<input name="page" value="<?=$page?>" type="hidden" />	
										<input name="vencode" type="hidden" value="<?=$vencode?>" />
									
                                                                    <div class="form-group row">
                                                                        <label for="Scrap Value" class="col-sm-3 control-label">Vendor Name <font color="#FF0000" size="">*</font> </label>
                                                                        <div class="col-sm-9">
                                                                            <input name="venname" id="venname" value="<?php echo htmlspecialchars($venname)?>" type="text" class="form-control form-control-sm" size="32" />
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group row">
                                                                        <label for="Scrap Value" class="col-sm-3 control-label">QC Required <font color="#FF0000" size="">*</font> </label>
                                                                        <div class="col-sm-9">
                                                                            <select name="qc_rq" id="qc_rq" class="form-control select2">
                                                                                <option value="">--select--</option>
                                                                                <option value="1" <?php if($qc_rq==1){ echo "selected='selected'";} ?>>Yes</option>
                                                                                <option value="2" <?php if($qc_rq==2){ echo "selected='selected'";} ?>>No</option>
                                                                            </select>
                                                                                                
                                                                        </div>
                                                                    </div>
							</div>
                                                    <div class="card-body">
                                                        <input type="button" name="Submit" class="btn btn-primary" value="<?php echo ($mod=="add")?"Add":"Update";?>" onClick="check();">
                                                        &nbsp;
                                                        <input type="reset" name="Submit2" class="btn btn-default" value="Clear" />
                                                    </div>
						</form>
						
						<!-- /.col -->
					</div>
					<!-- /.row -->
				</div>
			</div>
		</section>	
	</div>			
	<script>
   
    
   $(function () {
   //Initialize Select2 Elements
   $('.select2').select2()
   
   //Initialize Select2 Elements
   $('.select2bs4').select2({
   theme: 'bootstrap4'
   })
   });
   
</script>