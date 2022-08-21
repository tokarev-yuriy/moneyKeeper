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
    
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700"/>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet"/>

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" />
    
    
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
<body class="bg-gray-200">
    <noscript>
      <strong
        >We're sorry but <%= htmlWebpackPlugin.options.title %> doesn't work
        properly without JavaScript enabled. Please enable it to
        continue.</strong
      >
    </noscript>
    <div id="app" class="g-sidenav-show">
    @yield('content')
    </div>
    <!-- built files will be auto injected -->
    <script src="{{ mix('/js/main.js') }}"></script>
    <script type="text/javascript">
        var langTranslations = {};
        langTranslations['mkeep.hide_pie_chart'] = '<?=trans('mkeep.hide_pie_chart')?>';
        langTranslations['mkeep.show_pie_chart'] = '<?=trans('mkeep.show_pie_chart')?>';
    </script>
    @yield('appjsfile')
    
    <script>
        window.translations = {!! Cache::get('translations') !!};
    </script>
    <script>
        window.dictionary = {
            categories: <?=json_encode(\App\MoneyKeeper\Helpers\Dictionary::getCategories())?>,
            wallets: <?=json_encode(\App\MoneyKeeper\Helpers\Dictionary::getWallets())?>,
            walletGroups: <?=json_encode(\App\MoneyKeeper\Helpers\Dictionary::getWalletGroups())?>,
        };
    </script>
    
</body>
</html>