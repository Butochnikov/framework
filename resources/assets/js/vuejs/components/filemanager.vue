<template>
    <section class="files-manager">
        <nav class="files-manager-side">
            <header class="files-manager-side-title">Directories</header>
            <ul class="files-manager-side-list">
                <li v-for="dir in directories">
                    <a href="#" @click="openDir(dir)">{{ dir }}</a>
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
                            <input type="text" class="form-control form-control-rounded" placeholder="Search" />
                            <button type="submit" class="btn-icon">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </header>

                <div class="files-manager-content">
                    <div class="files-manager-content-in scrollable-block">
                        <div class="files-manager-breadcrumbs">
                            <a class="label label-default" @click="openDir()">/root</a>

                            <a class="label label-default" v-for="segment in breadcrumbs" @click="openDir(segment.path)" style="margin-right: 3px;">
                                /{{ segment.name }}
                            </a>
                        </div>
                        <div v-bind:class="{'fm-file-grid': grid, 'fm-file-list': !grid}">
                            <div class="fm-file" v-bind:class="{ 'selected': file == selected }" @click="select(file)" v-on:dblclick="file.type == 'dir' && openDir(file.path)" v-for="file in files">
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
                            <img v-bind:src="fileIcon(selected)" width="50px" /> {{ selected.filename }}
                        </div>
                        <div class="info-list">
                            <p>
                                <b>Path:</b> {{ selected.path }}
                            </p>
                        </div>

                        <span v-if="selected.type == 'file'">
							<button @click="deleteFile(selected)" class="btn btn-flat btn-danger">
								<i class="fa fa-trash"></i>
							</button>

							<a v-bind:href="downloadPath(selected)" href="#" class="btn btn-flat btn-default">
								<i class="fa fa-download"></i> Download
							</a>
						</span>
                        <span v-if="selected.type == 'dir'">
							<button @click="deleteDir(selected)" class="btn btn-flat btn-danger">
								<i class="fa fa-trash"></i>
							</button>

							<button @click="openDir(selected.path)" class="btn btn-flat btn-default">
								<i class="fa fa-level-up"></i> Open
							</button>
						</span>
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
                currentPath: Framework.Url.hash,
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
                    'X-CSRF-TOKEN': Framework.token
                },
                previewsContainer: false,
                clickable: '#filemanager-upload',
                url: Framework.Url.api('filemanager'),
                sending: function (file, xhr, formData) {
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
                    pdf: ['pdf'],
                    php: ['php'],
                    js: ['js'],
                    less: ['less'],
                    scss: ['scss'],
                    css: ['css']
                }, image = 'file'

                switch (file.type) {
                    case 'file':
                        for (let ext in types) {
                            if (_.indexOf(types[ext], file.extension) !== -1) {
                                image = `file-${ext}`;
                                break
                            }
                        }
                        break
                    case 'dir':
                        image = 'folder';
                        break
                }

                return Framework.Url.asset(`images/filemanager/${image}.png`)
            },
            deleteDir(dir) {
                let self = this

                Framework.Message.confirm()
                swal({
                    title: `Are you sure delete directory [${file.filename}] ?`,
                    text: `You won't be able to revert this!`,
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function () {
                    self.$http.delete(Framework.Url.api('filemanager/dir'), {params: {file: file.path}}).then((response) => {
                        self.openDir(self.currentPath)
                    }, (response) => {
                    });
                })
            },
            deleteFile(file) {
                let self = this

                swal({
                    title: `Are you sure delete file [${file.filename}] ?`,
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then(function () {
                    self.$http.delete(Framework.Url.api('filemanager'), {params: {file: file.path}}).then((response) => {
                        self.openDir(self.currentPath)
                    }, (response) => {
                    });
                })
            },
            openDir (path) {
                if (this.currentPath != path) {
                    this.currentPath = path || ''
                    window.location.href = path ? "#" + path : '#'

                    this.select(null)
                }

                // GET /someUrl
                this.$http.get(Framework.Url.api('filemanager'), {params: {path: path}}).then((response) => {
                    this.populateResponseData(response)
                }, (response) => {
                });
            },
            select (file) {
                this.selected = file;
            },
            downloadPath(file) {
                // TODO не работает
                return Framework.Url.api(`filemanager/download`, {file: file.path})
            },
            populateResponseData(response) {
                this.files = response.body.files
                this.directories = response.body.directories
            }
        },
        computed: {
            breadcrumbs () {
                if (!this.currentPath) {
                    return []
                }

                let segments = _.reject(this.currentPath.split('/'), function (segment) {
                        return !segment.length
                    }),
                    path = '',
                    crumbs = []

                for (let i in segments) {
                    path += '/' + segments[i];
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