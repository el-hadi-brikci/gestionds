
<!DOCTYPE html>
    <html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>@yield('PageTitle')</title>
	<link rel="icon" href="/images/site/{{ get_settings()->site_favicon }}" type="image/png">
  <link rel="stylesheet" href="front/vendors/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="front/vendors/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="front/vendors/themify-icons/themify-icons.css">
  <link rel="stylesheet" href="front/vendors/nice-select/nice-select.css">
  <link rel="stylesheet" href="front/vendors/owl-carousel/owl.theme.default.min.css">
  <link rel="stylesheet" href="front/vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="front/css/style.css">
  @livewireStyles()
  @stack('stylesheets')

</head>
<body>
  <!--================ Start Header Menu Area =================-->
   @include('front.layout.inc.header')
	<!--================ End Header Menu Area =================-->

  <main class="site-main">
@yield('content')
  </main>


  <!--================ Start footer Area  =================-->	
  @include('front.layout.inc.footer')
	
	<!--================ End footer Area  =================-->



  <script src="front/vendors/jquery/jquery-3.2.1.min.js"></script>
  <script src="front/vendors/bootstrap/bootstrap.bundle.min.js"></script>
  <script src="front/vendors/skrollr.min.js"></script>
  <script src="front/vendors/owl-carousel/owl.carousel.min.js"></script>
  <script src="front/vendors/nice-select/jquery.nice-select.min.js"></script>
  <script src="front/vendors/jquery.ajaxchimp.min.js"></script>
  <script src="front/vendors/mail-script.js"></script>
  <script src="front/js/main.js"></script>
  @livewireScripts()
  @stack('scrtipt')
</body>
</html>