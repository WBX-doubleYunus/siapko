<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>@yield('title') &mdash; SIAPKO</title>

    @include('template.partials._style')
</head>

<body>
    <div id="app">
        <div class="main-wrapper">
            @include('template.partials._navbar')

            @include('template.partials._sidebar')

            <!-- Main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            
            @include('template.partials._footer')
        </div>
    </div>

    @include('template.partials._script')
</body>

</html>
