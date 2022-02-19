<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tunas Bertumbuh</title>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
  <body
    class="hold-transition layout-top-nav"
    style="background-color: #f3f3f3"
  >
    <div class="wrapper" id="app">      
      
      <router-view></router-view>

      <!-- Footer -->
      <section style="background-color: #1e6f5c">
        <div class="container mt-5">
          <div class="row">
            <div class="col-lg-6 pl-5">
              <img
                src="../storage/img/tbLogo.png"
                class="w-75"
                alt="logo-TB"
              />
              <p class="mr-5">
                A community engaged in post-school self-development based on
                education and youth development. We support @unitednations SDGs
                No.4 Quality Education.
              </p>
            </div>
            <div class="col-lg">
              <div class="row mt-5">
                <h5><b>Address</b></h5>
              </div>
              <div class="row">
                <p>Malang, East Java, Indonesia</p>
              </div>
              <div class="row pt-2">
                <h5><b>Contact Us</b></h5>
              </div>
              <div class="row">
                <p class="card-title">Phone : + 62 851 5533 2282</p>
                <p>Email : contact@tunasbertumbuh.org</p>
              </div>
            </div>
            <div class="col-lg mt-5">
              <h5 class="pb-3"><b>Follow Us</b></h5>
              <a href="#"><h1 class="fab fa-facebook text-dark pr-2"></h1></a>
              <a href="#"><h1 class="fab fa-instagram text-dark px-2"></h1></a>
              <a href="#"><h1 class="fab fa-tiktok text-dark px-2"></h1></a>
            </div>
          </div>
        </div>
      </section>
      <!-- /.Footer -->
    </div>

    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
      function logout() {
        localStorage.removeItem("user_id");
        localStorage.removeItem("token");
        localStorage.removeItem("user_name");
        localStorage.removeItem("user_email");
        localStorage.removeItem("user_status");
        localStorage.removeItem("user_permission");

        alert("data cleared please refresh")
      }
    </script>
  </body>
</html>
