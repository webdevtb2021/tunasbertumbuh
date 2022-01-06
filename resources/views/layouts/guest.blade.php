<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tunas Bertumbuh | Homepage</title>
  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
  <body
    class="hold-transition layout-top-nav"
    style="background-color: #f3f3f3"
  >
    <div class="wrapper" id="app">
      <!-- Navbar -->
      <section id="navbar" style="background-color: #1e6f5c">
        <div class="container py-2">
          <div class="row">
            <div class="col">
              <nav
                class="
                  main-header
                  navbar navbar-expand-lg navbar-dark
                  bg-transparent
                "
              >
                <router-link :to="{ name: 'homepage' }" class="navbar-brand">
                  <img
                    src="../storage/img/TbLogo.png"
                    alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3"
                    style="opacity: 0.8"
                  />
                  <span class="brand-text font-weight-light"
                    >Tunas Bertumbuh</span>
                </router-link>
                <button
                  class="navbar-toggler"
                  type="button"
                  data-toggle="collapse"
                  data-target="#navbarSupportedContent"
                  aria-controls="navbarSupportedContent"
                  aria-expanded="false"
                  aria-label="Toggle navigation"
                >
                  <span class="navbar-toggler-icon"></span>
                </button>

                <div
                  class="collapse navbar-collapse"
                  id="navbarSupportedContent"
                >
                  <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                      <router-link :to="{ name: 'projects' }" class="nav-link">Project</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{ name: 'articles' }" class="nav-link">Article</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{ name: 'donations' }" class="nav-link">Donation</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{ name: 'partnerships' }" class="nav-link">Partner</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{ name: 'members' }" class="nav-link">Team</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{ name: 'merchandises' }" class="nav-link">Merchandise</router-link>
                    </li>
                    <li class="nav-item">
                      <router-link :to="{ name: 'finance' }" class="nav-link">Finance</router-link>
                    </li>
                    <li class="nav-item dropdown">
                      <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        id="navbarDropdown"
                        role="button"
                        data-toggle="dropdown"
                        aria-haspopup="true"
                        aria-expanded="false"
                      >
                        Login
                      </a>
                      <div
                        class="dropdown-menu"
                        aria-labelledby="navbarDropdown"
                      >
                        {{-- <a class="dropdown-item" href="../autentifikasi/login.html" >Sign In</a> --}}

                        <router-link :to="{ name: 'login' }" class="dropdown-item">Sign In</router-link>
                        
                        <div class="dropdown-divider"></div>
                        {{-- <a
                          class="dropdown-item"
                          href="../autentifikasi/register.html"
                          >Register</a
                        > --}}
                        <router-link :to="{ name: 'register' }" class="dropdown-item">Register</router-link>
                        <router-link :to="{ name: 'logout' }" class="dropdown-item">Logout</router-link>
                      </div>
                    </li>
                  </ul>
                </div>
              </nav>
            </div>
          </div>
        </div>
      </section>
      <!-- /.navbar -->
      
      <router-view></router-view>

      <!-- Footer -->
      <section style="background-color: #1e6f5c">
        <div class="container mt-5">
          <div class="row">
            <div class="col-lg-6 pl-5">
              <img
                src="../storage/img/Logo TB 169.png"
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
