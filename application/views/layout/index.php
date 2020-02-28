<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Inventory System</title>

  <!-- Global stylesheets -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
  <link href="<?=base_url("assets/css/icons/icomoon/styles.css")?>" rel="stylesheet" type="text/css">
  <link href="<?=base_url("assets/css/bootstrap.css")?>" rel="stylesheet" type="text/css">
  <link href="<?=base_url("assets/css/core.css")?>" rel="stylesheet" type="text/css">
  <link href="<?=base_url("assets/css/components.css")?>" rel="stylesheet" type="text/css">
  <link href="<?=base_url("assets/css/colors.css")?>" rel="stylesheet" type="text/css">
  <link href="<?=base_url("assets/css/sweetalert.css")?>" rel="stylesheet" type="text/css">
  <link href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />


  <!-- /global stylesheets -->

  <!-- Core JS files -->
  <script type="text/javascript" src="<?=base_url("assets/js/core/libraries/jquery.min.js")?>"></script>

  <!-- Datepicker -->
  <!-- /theme JS files -->




</head>

<body>
  <?php
$this->load->view('notification/index.php');
?>
  <!-- Main navbar -->
  <div class="navbar navbar-inverse bg-teal">
    <div class="navbar-header">
      <a class="navbar-brand" href="<?=base_url()?>">
        <strong>Stocky Master</strong>
      </a>

      <ul class="nav navbar-nav visible-xs-block">
        <li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
        <li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
      </ul>
    </div>

    <div class="navbar-collapse collapse" id="navbar-mobile">
      <ul class="nav navbar-nav">
        <li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a>
        </li>
      </ul>

      <div class="navbar-right">
        <p class="navbar-text"><?php
// I'm India so my timezone is Asia/Calcutta
date_default_timezone_set('Asia/Calcutta');

// 24-hour format of an hour without leading zeros (0 through 23)
$Hour = date('G');

if ($Hour >= 5 && $Hour <= 11) {
    echo "Good Morning";
} else if ($Hour >= 12 && $Hour <= 18) {
    echo "Good Afternoon";
} else if ($Hour >= 19 || $Hour <= 4) {
    echo "Good Evening";
}
?>, <strong><?php echo $this->session->userdata('admin_id'); ?> !</strong></p>
        <p class="navbar-text"><span class="label bg-success-400">Online</span></p>

        <ul class="nav navbar-nav">
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="icon-bell2"></i>
              <span class="visible-xs-inline-block position-right">Activity</span>
              <span class="status-mark border-orange-400"></span>
            </a>

            <div class="dropdown-menu dropdown-content">
              <div class="dropdown-content-heading">
                Activity
                <ul class="icons-list">
                  <li><a href="#"><i class="icon-menu7"></i></a></li>
                </ul>
              </div>

              <ul class="media-list dropdown-content-body width-350">
                <li class="media">
                  <div class="media-left">
                    <a href="#" class="btn bg-success-400 btn-rounded btn-icon btn-xs"><i class="icon-mention"></i></a>
                  </div>

                  <div class="media-body">
                    <a href="#">Taylor Swift</a> mentioned you in a post "Angular JS. Tips and
                    tricks"
                    <div class="media-annotation">4 minutes ago</div>
                  </div>
                </li>

                <li class="media">
                  <div class="media-left">
                    <a href="#" class="btn bg-pink-400 btn-rounded btn-icon btn-xs"><i class="icon-paperplane"></i></a>
                  </div>

                  <div class="media-body">
                    Special offers have been sent to subscribed users by <a href="#">Donna
                      Gordon</a>
                    <div class="media-annotation">36 minutes ago</div>
                  </div>
                </li>

                <li class="media">
                  <div class="media-left">
                    <a href="#" class="btn bg-blue btn-rounded btn-icon btn-xs"><i class="icon-plus3"></i></a>
                  </div>

                  <div class="media-body">
                    <a href="#">Chris Arney</a> created a new <span class="text-semibold">Design</span> branch in <span
                      class="text-semibold">Limitless</span> repository
                    <div class="media-annotation">2 hours ago</div>
                  </div>
                </li>

                <li class="media">
                  <div class="media-left">
                    <a href="#" class="btn bg-purple-300 btn-rounded btn-icon btn-xs"><i class="icon-truck"></i></a>
                  </div>

                  <div class="media-body">
                    Shipping cost to the Netherlands has been reduced, database updated
                    <div class="media-annotation">Feb 8, 11:30</div>
                  </div>
                </li>

                <li class="media">
                  <div class="media-left">
                    <a href="#" class="btn bg-warning-400 btn-rounded btn-icon btn-xs"><i class="icon-bubble8"></i></a>
                  </div>

                  <div class="media-body">
                    New review received on <a href="#">Server side integration</a> services
                    <div class="media-annotation">Feb 2, 10:20</div>
                  </div>
                </li>

                <li class="media">
                  <div class="media-left">
                    <a href="#" class="btn bg-teal-400 btn-rounded btn-icon btn-xs"><i class="icon-spinner11"></i></a>
                  </div>

                  <div class="media-body">
                    <strong>January, 2016</strong> - 1320 new users, 3284 orders, $49,390 revenue
                    <div class="media-annotation">Feb 1, 05:46</div>
                  </div>
                </li>
              </ul>
            </div>
          </li>


        </ul>

        <a class="navbar-text" href="<?=base_url('login/logout');?>"><span>Logout</span> <i class="icon-switch2"></i>
        </a>
      </div>
    </div>
  </div>
  <!-- /main navbar -->


  <!-- Page container -->
  <div class="page-container">

    <!-- Page content -->
    <div class="page-content">

      <!-- Main sidebar -->
      <div class="sidebar sidebar-main sidebar-default">
        <div class="sidebar-content">

          <!-- User menu -->
          <div class="sidebar-user-material">
            <div class="category-content">
              <div class="sidebar-user-material-content">
                <a href="#" style="box-shadow: none;"><img
                    src="https://img.icons8.com/bubbles/2x/admin-settings-male.png" class="img-circle img-responsive"
                    alt=""></a>
                <h6><?=$this->session->userdata('admin_id');?></h6>
                <span class="text-size-small">Surat, Gujarat, India</span>
              </div>

              <div class="sidebar-user-material-menu">
                <a href="#user-nav" data-toggle="collapse"><span>My account</span> <i class="caret"></i></a>
              </div>
            </div>

            <div class="navigation-wrapper collapse" id="user-nav">
              <ul class="navigation">
                <li><a href="#"><i class="icon-user-plus"></i> <span>My profile</span></a></li>
                <li><a href="#"><i class="icon-coins"></i> <span>My balance</span></a></li>
                <li><a href="#"><i class="icon-comment-discussion"></i> <span><span
                        class="badge bg-teal-400 pull-right">58</span> Messages</span></a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-cog5"></i> <span>Account settings</span></a></li>
                <li><a href="<?=base_url('login/logout');?>"><i class="icon-switch2"></i>
                    <span>Logout</span></a></li>
              </ul>
            </div>
          </div>
          <!-- /user menu -->


          <div class="sidebar-category sidebar-category-visible" style="height: 100vh;">
            <div class="category-content no-padding">
              <ul class="navigation navigation-main navigation-accordion">

                <li class="active"><a href="<?=base_url();?>"><i class="icon-home4"></i>
                    <span>Dashboard</span></a></li>
                <li>
                  <a href="#"><i class="icon-stack2"></i> <span>Master</span></a>
                  <ul>
                    <li><a href="<?=base_url("/suppliers");?>"><i class="icon-truck"></i>
                        <span>Supplier</span></a></li>
                    <li><a href="<?=base_url("/brands");?>"><i class="icon-users4"></i>
                        <span>Brands</span></a></li>
                    <li><a href="<?=base_url("/product-category");?>"><i class="icon-list2"></i> <span>Product
                          Category</span></a></li>
                    <li><a href="<?=base_url("/products");?>"><i class="icon-grid2"></i>
                        <span>Products </span></a></li>
                    <li><a href="<?=base_url("/unit");?>"><i class="icon-rulers"></i>
                        <span>Unit of Measurement </span></a></li>
                  </ul>
                </li>
                <li>
                  <a href="#"><i class="icon-cash"></i> <span>Purchase</span></a>
                  <ul>
                    <li><a href="<?=base_url("/purchase");?>"><i class="icon-cash"></i>
                        <span>Invoice</span></a></li>
                    <li><a href="<?=base_url("/purchase-return");?>"><i class="icon-cash"></i>
                        <span>Return</span></a></li>
                  </ul>
                </li>
                <li>
                  <a href="#"><i class="icon-cart"></i> <span>Sales</span></a>
                  <ul>
                    <li><a href="<?=base_url("/sales");?>"><i class="icon-cart"></i>
                        <span>Invoice</span></a></li>
                    <li><a href="<?=base_url("/sales-return");?>"><i class="icon-cart"></i>
                        <span>Return</span></a></li>
                  </ul>
                </li>
                <li><a href="<?=base_url("/customer");?>"><i class="icon-users4"></i>
                    <span>Customer</span></a></li>
                <li><a href="<?=base_url("/expense");?>"><i class="icon-sigma"></i>
                    <span>Expense</span></a></li>
                <li>
                  <a href="#"><i class="icon-cart"></i> <span>Reports</span></a>
                  <ul>
                    <li><a href="<?=base_url("/reports/purchases");?>"><i class="icon-cart"></i>
                        <span>Purchases Invoice</span></a></li>
                    <li><a href="<?=base_url("/reports/sales");?>"><i class="icon-cart"></i>
                        <span>Sales Invoice</span></a></li>
                  </ul>
                </li>
                <li><a href="<?=base_url("/company-details/edit");?>"><i class="icon-cog4"></i>
                    <span>My Company</span></a></li>

              </ul>
            </div>
          </div>

        </div>
      </div>
      <div class="content-wrapper">
        <?php echo $content; ?>
      </div>
    </div>
    <!-- Footer -->
    <!-- <div class="footer text-muted">
						&copy; 2015. <a href="#">Limitless Web App Kit</a> by <a href="http://themeforest.net/user/Kopyov" target="_blank">Eugene Kopyov</a>
					</div> -->
    <!-- /footer -->
  </div>
</body>

</html>


<script type="text/javascript" src="<?=base_url("assets/js/plugins/loaders/pace.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/loaders/blockui.min.js")?>"></script>
<!-- /core JS files -->

<!-- Theme JS files -->
<script type="text/javascript" src="<?=base_url("assets/js/plugins/tables/datatables/datatables.min.js")?>">
</script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/tables/datatables/extensions/responsive.min.js")?>">
</script>
<script type="text/javascript" src="<?=base_url("assets/js/pages/datatables_responsive.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/core/app.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/visualization/d3/d3.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/visualization/d3/d3_tooltip.js")?>"> </script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/forms/styling/switchery.min.js")?>"> </script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/forms/styling/uniform.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/forms/selects/bootstrap_multiselect.js")?>">
</script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/ui/moment/moment.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/core/libraries/bootstrap.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/core/libraries/jquery_ui/widgets.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/pages/jqueryui_forms.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/forms/selects/select2.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/pages/form_select2.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/pages/datatables_advanced.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/pages/dashboard.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/ui/ripple.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/notifications/sweet_alert.min.js")?>"></script>
<script type="text/javascript" src="<?=base_url("assets/js/plugins/pickers/daterangepicker.js")?>"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>




<script>
$('input[id$=datepicker]').datepicker({
  dateFormat: 'dd-mm-yy'
});
</script>