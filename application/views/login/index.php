<title>Login | Inventory System </title>
<link href="<?= base_url('assets/css/icons/icomoon/styles.css')?>" rel="stylesheet" type="text/css">
<link href="<?= base_url('assets/css/bootstrap.css')?>" rel="stylesheet" type="text/css">
<link href="<?= base_url('assets/css/core.css')?>" rel="stylesheet" type="text/css">
<link href="<?= base_url('assets/css/components.css')?>" rel="stylesheet" type="text/css">
<link href="<?= base_url('assets/css/colors.css')?>" rel="stylesheet" type="text/css">
<!-- /global stylesheets -->

<!-- Core JS files -->
<script type="text/javascript" src="<?= base_url('assets/js/plugins/loaders/pace.min.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/core/libraries/jquery.min.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/core/libraries/bootstrap.min.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/plugins/loaders/blockui.min.js')?>"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="text/javascript" src="<?= base_url('assets/js/plugins/forms/styling/uniform.min.js')?>"></script>

<script type="text/javascript" src="<?= base_url('assets/js/core/app.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/pages/login.js')?>"></script>

<script type="text/javascript" src="<?= base_url('assets/js/plugins/ui/ripple.min.js')?>"></script>
<!-- /theme JS files -->

<body class="login-container bg-slate-800">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">


<script type="text/javascript">


<?php if($this->session->flashdata('success')){ ?>
    toastr.success("<?php echo $this->session->flashdata('success'); ?>");
<?php }else if($this->session->flashdata('error')){  ?>
    toastr.error("<?php echo $this->session->flashdata('error'); ?>");
<?php }else if($this->session->flashdata('warning')){  ?>
    toastr.warning("<?php echo $this->session->flashdata('warning'); ?>");
<?php }else if($this->session->flashdata('info')){  ?>
    toastr.info("<?php echo $this->session->flashdata('info'); ?>");
<?php } ?>


</script>
	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">
					<!-- Advanced login -->
					<form  method="POST" action="<?= base_url('login/checkLogin') ?>">
						<div style="width:480px" class="panel panel-body login-form">
							<div class="text-center">
								<div class="icon-object border-warning-400 text-warning-400"><i class="icon-people"></i></div>
                                <h5 class="content-group-lg">Login to your account <small class="display-block">Enter your credentials</small></h5>
                                <?php
                                    if($this->session->flashdata('msg')!==null){
                                        ?>
                                        <span class="" style="color:red;font-weight:bold" role="alert">
                                            <?=$this->session->flashdata('msg'); ?>
                                        </span>
                                        <?php
                                    }
                                ?>
                                <br/>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="text"  name="Username" class="form-control" placeholder="Username">
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-left">
								<input type="password" name="Password" class="form-control" placeholder="Password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>
							</div>

							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										<label class="checkbox-inline">
											<input type="checkbox" class="styled" checked="checked">
											Remember
										</label>
									</div>

									<div class="col-sm-6 text-right">
										<a href="login_password_recover.html">Forgot password?</a>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-pink-400 btn-block">Login <i class="icon-circle-right2 position-right"></i></button>
							</div>
						</div>
					</form>
					<!-- /advanced login -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
