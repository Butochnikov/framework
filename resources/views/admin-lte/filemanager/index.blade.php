@extends(theme()->viewPath('layouts.backend'))

@section('block.content')

    {{--}
    <section class="files-manager">
        <nav class="files-manager-side">
            <header class="files-manager-side-title">My files</header>
            <ul class="files-manager-side-list">
                <li><a href="#">Recived</a></li>
                <li><a href="#">Sent</a></li>
                <li><a href="#">Recent</a></li>
                <li><a href="#">Shared with me</a></li>
                <li><a href="#" class="active">Trash</a></li>
                <li><a href="#">Inviations</a></li>
            </ul>
        </nav><!--.files-manager-side-->

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
                            <button type="button" class="btn-icon view active">
                                <i class="fa fa-th-large fa-lg" aria-hidden="true"></i>
                            </button>
                            <button type="button" class="btn-icon view">
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

                </header><!--.files-manager-header-->

                <div class="files-manager-content">
                    <div class="files-manager-content-in scrollable-block">
                        <div class="fm-file-grid">
                            <div class="fm-file selected">
                                <div class="fm-file-icon">
                                    <img src="{{ backend_url()->asset('images/filemanager/folder.png') }}" alt="">
                                </div>
                                <div class="fm-file-meta">
                                    <div class="fm-file-name">App design assets</div>
                                    <div class="fm-file-size">7 files, 358 MB</div>
                                </div>

                            </div>
                            <div class="fm-file">
                                <div class="fm-file-icon">
                                    <img src="{{ backend_url()->asset('images/filemanager/folder.png') }}" alt="">
                                </div>
                                <div class="fm-file-meta">
                                    <div class="fm-file-name">Inspiration</div>
                                    <div class="fm-file-size">144 files, 52 MB</div>
                                </div>
                            </div>
                            <div class="fm-file">
                                <div class="fm-file-icon">
                                    <img src="{{ backend_url()->asset('images/filemanager/folder.png') }}" alt="">
                                </div>
                                <div class="fm-file-meta">
                                    <div class="fm-file-name">2014_projects.rar</div>
                                    <div class="fm-file-size">4 MB</div>
                                </div>
                            </div>
                            <div class="fm-file">
                                <div class="fm-file-icon">
                                    <img src="{{ backend_url()->asset('images/filemanager/file.png') }}" alt="">
                                </div>
                                <div class="fm-file-meta">
                                    <div class="fm-file-name">Inspiration</div>
                                    <div class="fm-file-size">144 files, 52 MB</div>
                                </div>
                            </div>
                        </div>


                        <div class="fm-file-list">
                            <div class="fm-file selected">
                                <div class="fm-file-icon">
                                    <img src="{{ backend_url()->asset('images/filemanager/folder.png') }}" alt="">
                                </div>
                                <div class="fm-file-meta">
                                    <div class="fm-file-name">App design assets</div>
                                    <div class="fm-file-size">7 files, 358 MB</div>
                                </div>

                            </div>
                            <div class="fm-file">
                                <div class="fm-file-icon">
                                    <img src="{{ backend_url()->asset('images/filemanager/folder.png') }}" alt="">
                                </div>
                                <div class="fm-file-meta">
                                    <div class="fm-file-name">Inspiration</div>
                                    <div class="fm-file-size">144 files, 52 MB</div>
                                </div>
                            </div>
                            <div class="fm-file">
                                <div class="fm-file-icon">
                                    <img src="{{ backend_url()->asset('images/filemanager/folder.png') }}" alt="">
                                </div>
                                <div class="fm-file-meta">
                                    <div class="fm-file-name">2014_projects.rar</div>
                                    <div class="fm-file-size">4 MB</div>
                                </div>
                            </div>
                            <div class="fm-file">
                                <div class="fm-file-icon">
                                    <img src="{{ backend_url()->asset('images/filemanager/file.png') }}" alt="">
                                </div>
                                <div class="fm-file-meta">
                                    <div class="fm-file-name">Inspiration</div>
                                    <div class="fm-file-size">144 files, 52 MB</div>
                                </div>
                            </div>
                        </div>
                    </div><!--.files-manager-content-in-->
                </div><!--.files-manager-content-->

                <section class="files-manager-aside">
                    <div class="files-manager-aside-section">
                        <div class="box-typical-header-sm">PSD</div>
                        <div class="info-list">
                            <p>Owner: Mark Osborn</p>
                            <p>Changed: 08.01.2016  12:45</p>
                            <p>Downloaded: 9 times</p>
                            <p>The link was viewed: 83 times</p>
                        </div>
                        <a href="#" class="btn btn-rounded"><i class="font-icon-left font-icon-download-3"></i>Download</a>
                    </div>
                    <div class="files-manager-aside-section">
                        <div class="box-typical-header-sm">Share a folder</div>
                        <input type="text" class="form-control" value="http://yadi.sk/d/kitSdZIXmjnD8"/>
                        <a href="#" class="soc"><i class="font-icon font-icon-fb-fill"></i></a>
                        <a href="#" class="soc"><i class="font-icon font-icon-vk-fill"></i></a>
                        <a href="#" class="soc"><i class="font-icon font-icon-ok-fill"></i></a>
                        <a href="#" class="soc"><i class="font-icon font-icon-tw-fill"></i></a>
                        <a href="#" class="soc"><i class="font-icon font-icon-gp-fill"></i></a>
                    </div>
                </section><!--.files-manager-aside-->
            </div><!--.files-manager-panel-in-->
        </div><!--.files-manager-panels-->
    </section><!--.files-manager-->
    --}}

    <filemanager></filemanager>
@stop