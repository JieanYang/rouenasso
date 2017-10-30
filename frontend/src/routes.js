module.exports = routesConfig;

/** @ngInject */
function routesConfig($stateProvider, $urlRouterProvider, $locationProvider) {
  $locationProvider.html5Mode(true).hashPrefix('!');
  $urlRouterProvider.otherwise('/');

  $stateProvider
    .state('home', {
      url: '/',
      // this two forms are valid writing
      // component: 'app'
      // template: '<app></app>'
      views: {
        header: {
          component: 'bigHeader'
        },
        content: {
          component: 'fountainContents'
        },
        footer: {
          component: 'fountainFooter'
        }
      }
    })
    .state('home.data', {
      url: 'data',
      views: {
        // this change the content views in the state home
        // and hold the header and footer views
        'header@': {
          component: 'smallHeader'
        },
        'content@': {
          template: '<h2>I\'m the home.data page</h2>'
        }
      }
    })
    .state('home.register', {
      url: 'register',
      views: {
        // this change the content views in the state home
        // and hold the header and footer views
        'header@': {
          component: 'smallHeader'
        },
        'content@': {
          component: 'register'
        }
      }
    })
    .state('guide', {
      url: '/guide',
      views: {
        // this change the content views in the state home
        // and hold the header and footer views
        'header@': {
          component: 'smallHeader'
        },
        'content@': {
          component: 'guide'
        }
      }
    })
    ;
}
