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
      url: '/register',
      views: {
        'content@': {
          component: 'register'
        }
      }
    })
    .state('home.guide', {
      url: '/guide',
      views: {
        'content@': {
          component: 'guide'
        }
      }
    })
    .state('home.present', {
      url: '/present',
      views: {
        'content@': {
          template: '<h2>这里是学联介绍</h2>'
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
          template: '<h2>这是活动目录页面</h2>'
        }
      }
    })
    .state('home.works', {
      url: '/works',
      views: {
        'content@': {
          template: '<h2>这是工作目录页面</h2>'
        }
      }
    })
    .state('home.writing', {
      url: '/writing',
      views: {
        'content@': {
          template: '<h2>这是生活随笔目录页面</h2>'
        }
      }
    });
}
