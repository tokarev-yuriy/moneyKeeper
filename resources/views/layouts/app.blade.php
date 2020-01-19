<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Money">
    <meta name="apple-mobile-web-app-title" content="Money">
    <meta name="msapplication-starturl" content="/">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title><?=trans('mkeep.title')?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />

   <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/8879f0fb4a.js" crossorigin="anonymous"></script>
    
    <!-- CSS Files -->
    <link href="/css/material-dashboard.css?v=2.1.1" rel="stylesheet" />    
    <link rel="stylesheet" href="/js/slider/assets/owl.carousel.min.css?v=<?=time()?>" />
    <link rel="stylesheet" href="/js/slider/assets/owl.theme.default.min.css?v=<?=time()?>" />
    <link rel="stylesheet" href="/css/app.css?v=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="/css/lib/control/iconselect.css?v=<?=time()?>" >
    <link rel="stylesheet" type="text/css" href="/css/fontawesome-iconpicker.min.css?v=<?=time()?>" >
    
    <script>
    if ('serviceWorker' in navigator) {
     window.addEventListener('load', function() {  
       navigator.serviceWorker.register('/sw.js').then(
         function(registration) {
           // Registration was successful
           console.log('ServiceWorker registration successful with scope: ', registration.scope); },
         function(err) {
           // registration failed :(
           console.log('ServiceWorker registration failed: ', err);
         });
     });
    }
    </script>

</head>
<body id="app-layout">
<div id="wrap" class="wrapper">
  <div class="sidebar" data-color="purple" data-background-color="black" data-image="/material/assets/img/sidebar-1.jpg">
    <div class="logo">
      <a href="{{ url('/') }}" class="simple-text logo-mini">
        <div class="logo-img">
          <img src="/img/logo.png" alt="<?=trans('mkeep.title')?>">
        </div>
      </a>
      <a href="{{ url('/') }}" class="simple-text logo-normal">
      <?=trans('mkeep.title')?>
      </a>
    </div>
    
    <div class="sidebar-wrapper">
      <ul class="nav">
        @if (Auth::guest())
          <li class="nav-item"><a href="{{ url('/account/login') }}" class="nav-link">
            <i class="material-icons">input</i>
            <p><?=trans('mkeep.login')?></p>
          </a></li>
        @else
        <li class="nav-item dropdown">
            <a href="#" class="nav-link text-nowrap" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="material-icons">person</i>
              <p class="dropdown-toggle">{{ Auth::user()->name }}</p>
            </a>

            <div class="dropdown-menu">
                <a href="{{ url('/account/wallets/groups') }}" class="dropdown-item">
                  <i class="material-icons">list</i>
                  <p><?=trans('mkeep.wallets_groups')?></p>
                </a>
                <a href="{{ url('/account/wallets') }}" class="dropdown-item">
                  <i class="material-icons">credit_card</i>
                  <p><?=trans('mkeep.wallets')?></p>
                </a>
                <a href="{{ url('/account/categories') }}" class="dropdown-item">
                  <i class="material-icons">list</i>
                  <p><?=trans('mkeep.categories')?></p>
                </a>
                <a href="{{ url('/account/import/profile') }}" class="dropdown-item">
                  <i class="material-icons">cloud_upload</i>
                  <p><?=trans('mkeep.import_profile')?></p>
                </a>
                <a href="{{ url('/account/import/integration') }}" class="dropdown-item">
                  <i class="material-icons">sync</i>
                  <p><?=trans('mkeep.integration')?></p>
                </a>
                <div class="dropdown-divider"></div>
                <a href="{{ url('/account/logout') }}" class="dropdown-item">
                  <i class="material-icons">exit_to_app</i>
                  <p><?=trans('mkeep.logout')?></p>
                </a>
            </div>
        </li>
        <li class="nav-item"><a href="{{ url('/account/plans') }}" class="nav-link">
           <i class="material-icons">done_all</i>
           <p><?=trans('mkeep.plans')?></p>
         </a></li>
         
         <li class="nav-item dropdown">
             <a href="#" class="nav-link text-nowrap" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">assignment</i>
                <p class=" dropdown-toggle"><?=trans('mkeep.operations')?></p>
             </a>

             
             <div class="dropdown-menu">
                 <a href="{{ url('/account/operations/spend') }}" class="dropdown-item">
                   <i class="material-icons text-danger">arrow_back</i>
                   <p><?=trans('mkeep.spends')?></p>
                 </a>
                 <a href="{{ url('/account/operations/income') }}" class="dropdown-item">
                   <i class="material-icons text-success">arrow_forward</i>
                   <p><?=trans('mkeep.incomes')?></p>
                 </a>
                 <a href="{{ url('/account/operations/transfer') }}" class="dropdown-item">
                   <i class="material-icons">swap_horiz</i>
                   <p><?=trans('mkeep.transfers')?></p>
                 </a>
             </div>
         </li>
         
         <li class="nav-item dropdown">
             <a href="#" class="nav-link text-nowrap" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">sync</i>
                <p class=" dropdown-toggle"><?=trans('mkeep.integrations')?></p>
             </a>

             
             <div class="dropdown-menu">
                 <a href="{{ url('/account/import') }}" class="dropdown-item">
                   <i class="material-icons">cloud_upload</i>
                   <p><?=trans('mkeep.import')?></p>
                 </a>
                 
                 <a href="{{ url('/account/sync') }}" class="dropdown-item">
                   <i class="material-icons">sync</i>
                   <p><?=trans('mkeep.sync')?></p>
                 </a>
             </div>
         </li>
         
         <li class="nav-item dropdown">
             <a href="#" class="nav-link text-nowrap" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="material-icons">trending_up</i>
                 <p class=" dropdown-toggle"><?=trans('mkeep.statistics')?></p>
             </a>

             
             <div class="dropdown-menu">
                 <a href="{{ url('/account/stat/month') }}" class="dropdown-item">
                   <i class="material-icons">show_chart</i>
                   <p><?=trans('mkeep.stat_monthly')?></p>
                 </a>
                 <a href="{{ url('/account/stat/monthavg') }}" class="dropdown-item">
                   <i class="material-icons">pie_chart</i>
                   <p><?=trans('mkeep.stat_monthly_avg')?></p>
                 </a>
                 <a href="{{ url('/account/stat/monthplan') }}" class="dropdown-item">
                   <i class="material-icons">done_all</i>
                   <p><?=trans('mkeep.stat_monthly_plan')?></p>
                 </a>
             </div>
         </li>
     @endif        
      </ul>

    </div>
  </div>
    
  <div  class="main-panel">
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
      <div class="container-fluid">
        <div class="navbar-wrapper">
          <a class="navbar-brand" href="{{ url('/') }}">
            <?=trans('mkeep.title')?>
          </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="sr-only">Toggle navigation</span>
          <span class="navbar-toggler-icon icon-bar"></span>
          <span class="navbar-toggler-icon icon-bar"></span>
          <span class="navbar-toggler-icon icon-bar"></span>
        </button>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="content">
      @if (!Auth::guest())
      <div class="container-fluid widget" id="wallets-sum" data-url="/account/stat/wallets">
      </div>
      @endif
      
      <div class="container-fluid main-container">
      
      @yield('content')
      </div>
      <div class="clearfix"></div>
    </div>
    
    <footer class="footer">
        <div class="container-fluid">          
          <div class="text-right float-right">
            Money Keeper {{ date("Y") }}. Source code available on <a href="https://github.com/tokarev-yuriy/moneyKeeper">GitHub</a>.<br/>
            Code licensed <a href="https://github.com/tokarev-yuriy/moneyKeeper/blob/master/LICENSE.md" target="_blank" rel="license noopener">MIT</a>.
          </div>
        </div>
      </footer>
    
  </div>
</div>
    
    <script type="text/javascript">
        var langTranslations = {};
        langTranslations['mkeep.hide_pie_chart'] = '<?=trans('mkeep.hide_pie_chart')?>';
        langTranslations['mkeep.show_pie_chart'] = '<?=trans('mkeep.show_pie_chart')?>';
    </script>
    <!-- JavaScripts -->
    <!--   Core JS Files   -->
    <script src="/js/material/core/jquery.min.js" type="text/javascript"></script>
    <script src="/js/material/core/popper.min.js" type="text/javascript"></script>
    <script src="/js/material/core/bootstrap-material-design.min.js" type="text/javascript"></script>
    <script src="/js/material/plugins/perfect-scrollbar.jquery.min.js"></script>
    
    <!-- Plugin for the momentJs  -->
    <script src="/js/material/plugins/moment.min.js"></script>
    <!--  Plugin for Sweet Alert -->
    <script src="/js/material/plugins//sweetalert2.js"></script>
    <!-- Forms Validations Plugin -->
    <script src="/js/material/plugins//jquery.validate.min.js"></script>
    <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
    <script src="/js/material/plugins//jquery.bootstrap-wizard.js"></script>
    <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
    <script src="/js/material/plugins//bootstrap-selectpicker.js"></script>
    <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
    <script src="/js/material/plugins//bootstrap-datetimepicker.min.js"></script>
    <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
    <script src="/js/material/plugins//jquery.dataTables.min.js"></script>
    <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
    <script src="/js/material/plugins//bootstrap-tagsinput.js"></script>
    <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
    <script src="/js/material/plugins//jasny-bootstrap.min.js"></script>
    <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
    <script src="/js/material/plugins//fullcalendar.min.js"></script>
    <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
    <script src="/js/material/plugins//jquery-jvectormap.js"></script>
    <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
    <script src="/js/material/plugins//nouislider.min.js"></script>
    <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
    <!-- Library for adding dinamically elements -->
    <script src="/js/material/plugins//arrive.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="/js/material/plugins//bootstrap-notify.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="/js/material-dashboard.js?v=2.1.1" type="text/javascript"></script>
    
    <script src="/js/slider/owl.carousel.min.js?v=<?=time()?>"></script>   
    <script src="/js/widget.js?v=<?=time()?>"></script>   
    <script src="/js/widget_chart.js?v=<?=time()?>"></script>   
    <script src="/js/widget_vue.js?v=<?=time()?>"></script>   
    <script src="/js/widget_manager.js?v=<?=time()?>"></script>   
    <script src="//www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="//www.amcharts.com/lib/3/pie.js"></script>
    <script src="//www.amcharts.com/lib/3/serial.js"></script>
    <script src="//www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
    <script src="//www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="/js/lib/amcharts.responsive.min.js?v=<?=time()?>"></script>
    <script type="text/javascript" src="/js/lib/control/iconselect.js?v=<?=time()?>"></script>
    <script type="text/javascript" src="/js/lib/iscroll.js?v=<?=time()?>"></script>
    <script type="text/javascript" src="/js/lib/fontawesome-iconpicker.min.js?v=<?=time()?>"></script>
	<script src="//cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    @yield('appjsfile')
</body>
</html>
