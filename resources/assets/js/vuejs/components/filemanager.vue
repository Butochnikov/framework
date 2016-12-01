<template>
	<section class="files-manager">
		<nav class="files-manager-side">
			<header class="files-manager-side-title">Directories</header>
			<ul class="files-manager-side-list">
				<li v-for="dir in directories">
					<a href="#" @click="openDir(dir.path)">{{ dir.path }}</a>
				</li>
			</ul>
		</nav>

		<div class="files-manager-panel">
			<div class="files-manager-panel-in">
				<header class="files-manager-header">

					<div class="files-manager-header-left">
						<button type="button" class="btn btn-primary" id="filemanager-upload">
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
						<div class="files-manager-breadcrumbs">
							<a class="label label-default" href="#" @click="openDir()">/root</a>

							<a class="label label-default" v-for="segment in breadcrumbs" href="#" @click="openDir(segment.path)" style="margin-right: 3px;">
								/{{ segment.name }}
							</a>
						</div>
						<div v-bind:class="{'fm-file-grid': grid, 'fm-file-list': !grid}">
							<div class="fm-file" v-bind:class="{ 'selected': file == selected }" @click="select(file)" v-for="file in files">
								<div class="fm-file-icon">
									<img v-bind:src="fileIcon(file)">
								</div>
								<div class="fm-file-meta">
									<div class="fm-file-name">{{ file.filename }}</div>
									<div class="fm-file-size" v-if="file.size">
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
							<img v-bind:src="fileIcon(selected)" width="50px"/> {{ selected.filename }}
						</div>
						<div class="info-list">
							<p>
								<b>Path:</b> {{ selected.path }}
							</p>
						</div>

						<a href="#" @click="deleteFile(selected)" class="btn btn-flat btn-danger">
							<i class="fa fa-trash"></i>
						</a>
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
				currentPath: '',
				grid: true,
				directories: [],
				files: [],
				selected: null
			}
		},
		mounted() {
			let self = this

			new Dropzone(".files-manager-content-in", {
				method: 'POST',
				headers: {
					'X-CSRF-TOKEN': window.Framework.Settings.token
				},
				previewsContainer: false,
				clickable: '#filemanager-upload',
				url: "/backend/api/filemanager",
				sending: function(file, xhr, formData){
					formData.append('path', self.currentPath);
				},
				success (file, response) {
					self.openDir(self.currentPath)
				}
			});

			this.openDir(this.currentPath)
		},
		methods: {
			fileIcon (file) {
				let types = {
					img: ['png', 'jpg', 'gif'],
					doc: ['doc', 'txt'],
					xls: ['xls', 'xlsx'],
					pdf: ['pdf']
				}, image;

				switch(file.type) {
				  case 'dir':
					image = 'folder';
					break
				  default:
					image = 'file';
				}
				return '/vendor/sleepingowl/admin-lte/images/filemanager/'+image+'.png'
			},
			deleteFile(file) {
				if (file.type != 'file') {
					swal('You can delete only files')
				}

				let self = this

				swal({
					title: 'Are you sure delete file ['+file.filename+'] ?',
					text: "You won't be able to revert this!",
					type: 'warning',
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Yes, delete it!'
				}).then(function () {
					self.$http.delete('/backend/api/filemanager', {params: {file: file.path}}).then((response) => {
						self.openDir(self.currentPath)
					}, (response) => {});
				})
			},
			openDir (path) {
				this.currentPath = path

				// GET /someUrl
				this.$http.get('/backend/api/filemanager', {params: {path: path}}).then((response) => {
					this.files = response.body.files
					this.directories = response.body.directories
				}, (response) => {});
			},
			select (file) {
				if(file.type == 'dir') {
					this.selected = null
					return this.openDir(file.path)
				}

				this.selected = file;
			}
		},
		computed: {
			breadcrumbs () {
				if (!this.currentPath) {
					return []
				}

				let segments = _.reject(this.currentPath.split('/'), function(segment) { return !segment.length }),
					path = '',
					crumbs = []

				for (let i in segments) {
					path += '/'+segments[i];
					crumbs.push({
						name: segments[i],
						path: path
					})
				}

				return crumbs;
			}
		}
	}

</script>