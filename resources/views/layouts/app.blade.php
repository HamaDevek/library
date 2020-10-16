<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body>
    <div class="container-scroller">
        @include('layouts.nav')

        <div class="container-fluid page-body-wrapper">
            @include('layouts.sidebar')

            <div class="main-panel">
                <div class="content-wrapper">
                    @yield('content')
                </div>
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                            {{date('Y')}} <a href="#" target="_blank">Library</a>. All rights reserved.</span>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    @include('layouts.script')
</body>
</html>