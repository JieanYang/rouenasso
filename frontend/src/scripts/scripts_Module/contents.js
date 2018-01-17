module.exports = {
  template: require('../../views/views_Module/contents.html'),
  controller: ContentsController,
  controllerAs: 'vm'
};

/** @ngInject */
function ContentsController($http, $sce) {
	var vm = this;
	vm.showAnnouncement = false;

	$http
	.get('https://api.acecrouen.com/posts/category/99?latest=true')
	.then(function (response) {
		if (response.data.preview_text == 'hiding'){
			vm.showAnnouncement = false;
		}else if (response.data.preview_text == 'showing'){
			vm.announcement_title = $sce.trustAsHtml(response.data.title);
			vm.announcement = $sce.trustAsHtml(response.data.html_content);
			vm.showAnnouncement = true;
		}

	});

	$http.get('https://api.acecrouen.com/log');
}
