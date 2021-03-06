        module.exports = routesConfig;

/** @ngInject */
function routesConfig($stateProvider, $urlRouterProvider, $locationProvider) {
  $locationProvider.html5Mode(true).hashPrefix('!');
  $urlRouterProvider.otherwise('/');

  $stateProvider
    .state('index', {
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
    .state('home', {
      url: '/home',
      views: {
        header: {
          component: 'smallHeader'
        },
        content: {
          component: 'fountainContents'
        },
        footer: {
          component: 'fountainFooter'
        }
      }
    })

    .state('home.register', {
      url: '/register/:link',
      views: {
        'content@': {
          component: 'register'
        }
      }
    })
    .state('home.guides', {
      url: '/guides',
      views: {
        'content@': {
          component: 'guides'
        }
      }
    })
    .state('home.guide', {
      url: '/guides&id=:id',
      views: {
        'content@': {
          component: 'guide'
        }
      }
    })
    .state('home.aboutus', {
      url: '/aboutus',
      views: {
        'content@': {
          component: 'aboutus'
        }
      }
    })
    .state('home.contactus', {
      url: '/contactus',
      views: {
        'content@': {
          component: 'contactus'
        }
      }
    })
    .state('home.login', {
      url: '/login',
      views: {
        'content@': {
          component: 'login'
        }
      }
    })
    .state('home.movements', {
      url: '/movements',
      views: {
        'content@': {
          component: 'movements'
        }
      }
    })
    .state('home.movementDetails', {
      url: '/movements&id=:id',
      views: {
        'content@': {
          component: 'movementDetails'
        }
      }
    })
    .state('home.works', {
      url: '/works',
      views: {
        'content@': {
          component: 'works'
        }
      }
    })
    .state('home.work', {
      url: '/works&id=:id',
      views: {
        'content@': {
          component: 'work'
        }
      }
    })
    .state('home.writing', {
      url: '/writing',
      views: {
        'content@': {
          component: 'writing'
        }
      }
    })
    .state('home.writing_detail', {
      url: '/writing&id=:id',
      views: {
        'content@': {
          component: 'writingDetail'
        }
      }
    });
}
