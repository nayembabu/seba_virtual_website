<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $basic->site_name ?? $basic->site_title }} is a trusted platform for providing essential services in Bangladesh. Get all the information and tools you need with ease.">
    <meta name="keywords" content="{{ $basic->site_name ?? $basic->site_title }}, Bangladesh, services, information, tools">
    <meta name="robots" content="index, follow">
    <meta name="author" content="{{ $basic->site_name ?? $basic->site_title }} Team">
    <meta name="developer" content="Mokaddes Hosain">
    <title>@yield('title') | {{ $basic->site_name ??  $basic->site_title }} </title>
    
    <!-- Favicon -->
    <link rel="icon" href="{{url('')}}/assets/site/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="180x180" href="{{url('')}}/assets/site/favicon.ico">
    <link rel="icon" type="image/png" sizes="32x32" href="{{url('')}}/assets/site/favicon.ico">
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('')}}/assets/site/favicon.ico">
    
    <!-- Bootstrap and Fonts -->
    <link rel="stylesheet" href="{{url('')}}/assets/site/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,400i,700,700i,600,600i">
    <link rel="stylesheet" href="{{url('')}}/assets/site/fonts/simple-line-icons.min.css">
    
    <!-- Additional Stylesheets -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.css">
    <link rel="stylesheet" href="{{url('')}}/assets/site/css/styles.min.css">
    
    @stack('style')
    
    <style>
        /* Custom styles can go here */
    </style>
</head>

<body>
    <main class="page landing-page">
        @yield('content')
    </main>
  
    <!-- Scripts -->
    <script src="{{url('')}}/assets/site/js/jquery.min.js"></script>
    <script src="{{url('')}}/assets/site/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/baguettebox.js/1.10.0/baguetteBox.min.js"></script>
    <script src="{{url('')}}/assets/site/js/script.min.js"></script>
    
    @stack('script')
</body>

</html>
