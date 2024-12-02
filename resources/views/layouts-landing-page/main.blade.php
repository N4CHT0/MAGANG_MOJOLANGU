<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts-landing-page.head')
</head>

<body id="body">

    <!--
  Start Preloader
  ==================================== -->
    <div id="preloader">
        <div class='preloader'>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!--
  End Preloader
  ==================================== -->

    <!--
Fixed Navigation
==================================== -->
    @include('layouts-landing-page.navbar')
    <!--
End Fixed Navigation
==================================== -->

    @yield('content')

    @include('layouts-landing-page.footer')
    <!--
    Essential Scripts
    =====================================-->
    @include('layouts-landing-page.script')

</body>

</html>
