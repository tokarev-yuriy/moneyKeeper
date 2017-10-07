<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width">

    <title><?=trans('mkeep.title')?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:100,300,400,700">

    <!-- Styles -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/app.css">

</head>
<body id="app-layout">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="/img/logo.svg" alt="<?=trans('mkeep.title')?>" class="rounded-circle bg-light" /> <?=trans('mkeep.title')?>
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#app-navbar-collapse" aria-controls="app-navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav">                    
					@if (!Auth::guest())
                        <li class="nav-item"><a href="{{ url('/account/operations/spend') }}" class="nav-link"><?=trans('mkeep.spends')?></a></li>
                        <li class="nav-item"><a href="{{ url('/account/operations/income') }}" class="nav-link"><?=trans('mkeep.incomes')?></a></li>
                        <li class="nav-item"><a href="{{ url('/account/operations/transfer') }}" class="nav-link"><?=trans('mkeep.transfers')?></a></li>
                        
                        <li class="nav-item d-lg-none"><li class="dropdown-divider"></li>
                        <li class="nav-item d-lg-none"><a href="{{ url('/account/wallets') }}" class="nav-link"><i class="fa fa-btn fa-credit-card"></i><?=trans('mkeep.wallets')?></a></li>
                        <li class="nav-item d-lg-none"><a href="{{ url('/account/categories') }}" class="nav-link"><i class="fa fa-btn fa-list"></i><?=trans('mkeep.categories')?></a></li>
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
                                <div class="dropdown-divider"></div>
                                <a href="{{ url('/account/logout') }}" class="dropdown-item"><i class="fa fa-btn fa-sign-out"></i><?=trans('mkeep.logout')?></a>
                            </div>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="container mt-5">
    @yield('content')
    </div>

    <!-- JavaScripts -->
    <script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="/js/bootstrap.min.js"></script>   
    @yield('appjsfile')
</body>
</html>
