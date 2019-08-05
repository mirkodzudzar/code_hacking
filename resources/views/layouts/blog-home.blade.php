<!DOCTYPE html>
<html lang="en">

<head>
    <!-- HEADER -->
    @include('includes.front_header')

</head>

<body>

    <!-- Navigation -->
    @include('includes.front_nav')

    <!-- Page Content -->
    <div class="container">

        <div class="row">

          @include('includes.front_flash_messages')

          @include('includes.errors')

          <!-- CONTENT OF HOME PAGE -->
          @yield('content')

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>

          @include('includes.front_footer')

        </footer>

    </div>
    <!-- /.container -->

    <!-- jQuery -->
    <script src="{{asset('js/libs.js')}}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
