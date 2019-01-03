'use strict';

var app = angular.module('LibreriaApp', ['ngRoute', 'ngResource', 'ngSanitize', 'ui.select', 'angucomplete-alt'])
        .filter('unsafe', function ($sce) {
            return $sce.trustAsHtml;
        })
        
        ;
