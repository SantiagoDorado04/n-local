<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">
   
   <!-- CSS -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
   <link href="{{ asset('template/css/style.css') }}" rel="stylesheet">
   <!-- FONT -->
   <link href="https://fonts.gstatic.com" rel="preconnect">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
   <link
      href="https://fonts.googleapis.com/css2?family=Josefin+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,200;1,300;1,400;1,500;1,600&display=swap"
      rel="stylesheet">
      @livewireStyles()
      <link href="{{ asset('assets/fonts/roboto/Roboto-Regular.ttf') }}" rel="stylesheet">

   <style>
      .is-required:after {
         content: '*';
         margin-left: 3px;
         color: #DC3545;
         font-weight: bold;
         }
   </style>
</head>

<body>
   {{$slot}}
   <div id="preloader-wrapper">
      <div id="preloader"></div>
      <div class="preloader-section section-left"></div>
      <div class="preloader-section section-right"></div>
   </div>
   @livewireScripts()
   @yield('javascript')
   <script src={{ asset('template/js/script.js') }}></script>
</body>

</html>