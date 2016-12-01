<template>
	<section class="files-manager">
		<nav class="files-manager-side">
			<header class="files-manager-side-title">My files</header>
			<ul class="files-manager-side-list">
				<li v-for="dir in directories"><a href="#">{{ dir.name }}</a></li>
			</ul>
		</nav>

		<div class="files-manager-panel">
			<div class="files-manager-panel-in">
				<header class="files-manager-header">

					<div class="files-manager-header-left">
						<button type="button" class="btn btn-primary">
							<i class="fa fa-upload" aria-hidden="true"></i> Upload file
						</button>
					</div>

					<div class="files-manager-header-right">
						<div class="views">
							<button type="button" class="btn-icon view" @click="grid=true" v-bind:class="{ 'active': grid }">
								<i class="fa fa-th-large fa-lg" aria-hidden="true"></i>
							</button>
							<button type="button" class="btn-icon view" @click="grid=false" v-bind:class="{ 'active': !grid }">
								<i class="fa fa-list fa-lg" aria-hidden="true"></i>
							</button>
						</div>
						<div class="search">
							<input type="text" class="form-control form-control-rounded" placeholder="Search"/>
							<button type="submit" class="btn-icon">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</div>
				</header>

				<div class="files-manager-content">
					<div class="files-manager-content-in scrollable-block">
						<div v-bind:class="{'fm-file-grid': grid, 'fm-file-list': !grid}">
							<div class="fm-file" v-bind:class="{ 'selected': file == selected }" @click="selected=file" v-for="file in files">
								<div class="fm-file-icon">
									<img v-bind:src="fileIcon(file)" alt="">
								</div>
								<div class="fm-file-meta">
									<div class="fm-file-name">{{ file.name }}</div>
									<div class="fm-file-size">
										Size: {{ file.size }}
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<section class="files-manager-aside" v-if="selected">
					<div class="files-manager-aside-section">
						<div class="box-typical-header-sm">
							<img v-bind:src="fileIcon(selected)" alt="">
							{{ selected.name }}
						</div>
						<div class="info-list">
							<p v-for="meta in selected.meta">
								{{ meta.title }}: {{ meta.value }}
							</p>
						</div>
						<a href="#" class="btn btn-flat btn-default"><i class="fa fa-download"></i> Download</a>
					</div>
				</section>
			</div>
		</div>
	</section>
</template>

<script>
	export default {
		data() {
			return {
				grid: true,
				directories: [
					{
						name: 'Dir 1'
					},
					{
						name: 'Dir 2'
					},
					{
						name: 'Dir 3'
					}
				],
				files: [
					{
						name: 'Awesome file 1',
						size: '1gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '1gb'
							}
						]

					},
					{
						name: 'Awesome file 2',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 3',
						size: '2gb',
						type: 'file',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 4',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 5',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 6',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 6',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 6',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 6',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 6',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					},
					{
						name: 'Awesome file 6',
						size: '2gb',
						type: 'folder',
						meta: [
							{
								title: 'Size',
								value: '2gb'
							}
						]

					}
				],
				selected: null
			}
		},
		mounted() {
			let self = this;
			self.fileManagerHeight();

			$(window).resize(function () {
				self.fileManagerHeight();
			});
		},
		methods: {
			fileIcon(file) {
				return '/vendor/sleepingowl/admin-lte/images/filemanager/'+file.type+'.png'
			},
			fileManagerHeight() {
				$('.files-manager').each(function () {
					var box = $(this),
						boxColLeft = box.find('.files-manager-side'),
						boxSubHeader = box.find('.files-manager-header'),
						boxCont = box.find('.files-manager-content-in'),
						boxColRight = box.find('.files-manager-aside');

					var paddings = parseInt($('.content-wrapper').css('padding-top')) +
						parseInt($('.content-wrapper').css('padding-bottom')) +
						parseInt(box.css('margin-bottom')) + 2;

					boxColLeft.height('auto');
					boxCont.height('auto');
					boxColRight.height('auto');

					if (boxColLeft.height() <= ($(window).height() - paddings)) {
						boxColLeft.height(
							$(window).height() - paddings
						);
					}

					if (boxColRight.height() <= ($(window).height() - paddings - boxSubHeader.outerHeight())) {
						boxColRight.height(
							$(window).height() -
							paddings -
							boxSubHeader.outerHeight()
						);
					}

					boxCont.height(
						boxColRight.height()
					);
				});
			}
		}
	}


</script>