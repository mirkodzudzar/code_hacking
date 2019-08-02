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

          @include('includes.flash_messages')

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
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
