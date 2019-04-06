'use strict';
importScripts("/sw-toolbox.js"); 
toolbox.precache(["/app.html","/css/bootstrap.min.css","/css/app.css"]); 
toolbox.router.get('/img/*', toolbox.cacheFirst); 
