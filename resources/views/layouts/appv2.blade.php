<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">
    
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

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/bootstrap.min.css?v=<?=time()?>">
    <link rel="stylesheet" href="/js/slider/assets/owl.carousel.min.css?v=<?=time()?>" />
    <link rel="stylesheet" href="/js/slider/assets/owl.theme.default.min.css?v=<?=time()?>" />
    <link rel="stylesheet" href="/css/app.css?v=<?=time()?>">
    <link rel="stylesheet" type="text/css" href="/css/lib/control/iconselect.css?v=<?=time()?>" >
    
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
<div id="wrap">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/logo.png?v=<?=time()?>" alt="<?=trans('mkeep.title')?>" class="rounded-circle bg-light" /> <?=trans('mkeep.title')?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-navbar-collapse" aria-controls="app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse col-9" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav">                    
					@if (!Auth::guest())
                        <li class="nav-item"><a href="{{ url('/account/operations/spend') }}" class="nav-link"><i class="fa fa-btn fa-long-arrow-left text-danger"></i><?=trans('mkeep.spends')?></a></li>
                        <li class="nav-item"><a href="{{ url('/account/operations/income') }}" class="nav-link"><i class="fa fa-btn fa-long-arrow-right text-success"></i><?=trans('mkeep.incomes')?></a></li>
                        <li class="nav-item"><a href="{{ url('/account/operations/transfer') }}" class="nav-link"><i class="fa fa-btn fa-exchange"></i><?=trans('mkeep.transfers')?></a></li>
                        <li class="nav-item"><a href="{{ url('/account/plans') }}" class="nav-link"><i class="fa fa-btn fa-check-square-o"></i><?=trans('mkeep.plans')?></a></li>
                        <li class="nav-item"><a href="{{ url('/account/import') }}" class="nav-link"><i class="fa fa-btn fa-upload"></i><?=trans('mkeep.import')?></a></li>
                        
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-nowrap" data-toggle="dropdown" role="button" aria-expanded="true">
                                <i class="fa fa-btn fa-line-chart"></i><?=trans('mkeep.statistics')?>
                            </a>

                            
                            <div class="dropdown-menu">
                                <a href="{{ url('/account/stat/month') }}" class="dropdown-item"><i class="fa fa-btn fa-area-chart"></i><?=trans('mkeep.stat_monthly')?></a>
                                <a href="{{ url('/account/stat/monthavg') }}" class="dropdown-item"><i class="fa fa-btn fa-pie-chart"></i><?=trans('mkeep.stat_monthly_avg')?></a>
                                <a href="{{ url('/account/stat/monthplan') }}" class="dropdown-item"><i class="fa fa-btn fa-pie-chart"></i><?=trans('mkeep.stat_monthly_plan')?></a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('/account/stat/year') }}" class="dropdown-item"><i class="fa fa-btn fa-area-chart"></i><?=trans('mkeep.stat_year')?></a>
                                <a href="{{ url('/account/stat/yearavg') }}" class="dropdown-item"><i class="fa fa-btn fa-pie-chart"></i><?=trans('mkeep.stat_year_avg')?></a>
                                <a href="{{ url('/account/stat/yearplan') }}" class="dropdown-item"><i class="fa fa-btn fa-pie-chart"></i><?=trans('mkeep.stat_year_plan')?></a>
                            </div>
                        </li>                        
                        
                        
                        <li class="nav-item d-lg-none"><li class="dropdown-divider"></li>
                        <li class="nav-item d-lg-none"><a href="{{ url('/account/wallets') }}" class="nav-link"><i class="fa fa-btn fa-credit-card"></i><?=trans('mkeep.wallets')?></a></li>
                        <li class="nav-item d-lg-none"><a href="{{ url('/account/categories') }}" class="nav-link"><i class="fa fa-btn fa-list"></i><?=trans('mkeep.categories')?></a></li>
                        <li class="nav-item d-lg-none"><a href="{{ url('/account/import/profile') }}" class="nav-link"><i class="fa fa-btn fa-upload"></i><?=trans('mkeep.import_profile')?></a></li>
                        <li class="nav-item d-lg-none"><li class="dropdown-divider"></li>
                        <li class="nav-item d-lg-none"><a href="{{ url('/account/logout') }}" class="nav-link"><i class="fa fa-btn fa-sign-out"></i><?=trans('mkeep.logout')?></a></li>
                        
                    @endif         
                        
                </ul>
            </div>
            
            <div class="collapse navbar-collapse justify-content-end">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li class="nav-item"><a href="{{ url('/account/login') }}" class="nav-link"><?=trans('mkeep.login')?></a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle text-nowrap" data-toggle="dropdown" role="button" aria-expanded="true">
                                <i class="fa fa-btn fa-gear"></i>{{ Auth::user()->name }}
                            </a>

                            
                            <div class="dropdown-menu">
                                <a href="{{ url('/account/wallets') }}" class="dropdown-item"><i class="fa fa-btn fa-credit-card"></i><?=trans('mkeep.wallets')?></a>
                                <a href="{{ url('/account/categories') }}" class="dropdown-item"><i class="fa fa-btn fa-list"></i><?=trans('mkeep.categories')?></a>
                                <a href="{{ url('/account/import/profile') }}" class="dropdown-item"><i class="fa fa-btn fa-upload"></i><?=trans('mkeep.import_profile')?></a>
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('/account/logout') }}" class="dropdown-item"><i class="fa fa-btn fa-sign-out"></i><?=trans('mkeep.logout')?></a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container widget" id="wallets-sum" data-url="/account/stat/wallets">
    </div>
    
    <div class="container main-container">
    
    @yield('content')
    </div>
    <div class="clearfix"></div>
    <div id="push"></div>
</div>
    
    <footer class="footer">
      <nav class="navbar navbar-dark bg-dark">
        <div class="container text-white  justify-content-end text-right">
            <div>
                Money Keeper 2017. Source code available on <a href="https://github.com/tokarev-yuriy/moneyKeeper">GitHub</a>.<br/>
                Code licensed <a href="https://github.com/tokarev-yuriy/moneyKeeper/blob/master/LICENSE.md" target="_blank" rel="license noopener">MIT</a>.
            </div>
        </div>
      </nav>
    </footer>
    <script type="text/javascript">
        var langTranslations = {};
        langTranslations['mkeep.hide_pie_chart'] = '<?=trans('mkeep.hide_pie_chart')?>';
        langTranslations['mkeep.show_pie_chart'] = '<?=trans('mkeep.show_pie_chart')?>';
    </script>
    <!-- JavaScripts -->
    <script src="//code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="/js/popper.min.js?v=<?=time()?>" crossorigin="anonymous"></script>
    <script src="/js/bootstrap.min.js?v=<?=time()?>"></script>   
    <script src="/js/slider/owl.carousel.min.js?v=<?=time()?>"></script>   
    <script src="/js/widget.js?v=<?=time()?>"></script>   
    <script src="/js/widget_chart.js?v=<?=time()?>"></script>   
    <script src="/js/widget_manager.js?v=<?=time()?>"></script>   
    <script src="//www.amcharts.com/lib/3/amcharts.js"></script>
    <script src="//www.amcharts.com/lib/3/pie.js"></script>
    <script src="//www.amcharts.com/lib/3/serial.js"></script>
    <script src="//www.amcharts.com/lib/3/plugins/dataloader/dataloader.min.js"></script>
    <script src="//www.amcharts.com/lib/3/themes/light.js"></script>
    <script src="/js/amcharts.responsive.min.js?v=<?=time()?>"></script>
    <script type="text/javascript" src="/js/lib/control/iconselect.js?v=<?=time()?>"></script>
    <script type="text/javascript" src="/js/lib/iscroll.js?v=<?=time()?>"></script>
    @yield('appjsfile')
</body>
</html>
