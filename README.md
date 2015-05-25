LemonRestBundle Demo App
========================

This is a symfony standard edition application using the [LemonRestBundle](https://github.com/stanlemon/rest-bundle) and [ng-admin](https://github.com/marmelab/ng-admin) to show easy it is to create a simple REST api.  For more information please consult the bundle's documentation.

This application is deployed to http://restdemo-stanlemon.rhcloud.com if you'd like to see it in action. The database is reset every minute.

Or try it out yourself...

    composer.phar install
    php -S localhost:8383 -t ./web/
    
Then hit http://localhost:8383 in your browser and enjoy!

The configuration for ng-admin was generated using [NgAdminGeneratorBundle](https://github.com/marmelab/NgAdminGeneratorBundle) written by [jpetitcolas](https://github.com/jpetitcolas) you can check this out by running the following command:

    ./app/console ng-admin:configuration:generate > ./web/js/config.js

You will need to edit the bottom of ./web/js/config.js to set the base uri and application title, like so:

    var admin = NgAdminConfigurationProvider
        .application('LemonRestBundle Demo')
        .baseApiUrl(location.protocol + '//' + location.hostname + (location.port ? ':' + location.port : '') + '/app.php/api/')
