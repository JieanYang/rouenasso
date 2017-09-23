'use strict';

function homeController(homeFactory) {
  var vm = this;
  vm.a = homeFactory.getA();
  vm.b = '官网';
}

homeController.$inject = ['sampleService'];

module.exports = homeController;
