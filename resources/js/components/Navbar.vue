<template>
	
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
                    src="storage/img/whiteLogo.png"
                    alt="Logo"
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
                    <li class="nav-item">
                      <router-link :to="{ name: 'pekanbeasiswa' }" class="nav-link">Pekan Beasiswa 3.0</router-link>
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
                        Admin
                      </a>
                      <div
                        class="dropdown-menu"
                        aria-labelledby="navbarDropdown"
                      >
                        <div v-if="!auth_id">
                          <router-link :to="{ name: 'login' }" class="dropdown-item">Sign In</router-link>
                          <router-link :to="{ name: 'register' }" class="dropdown-item">Register</router-link>
                          <router-link :to="{ name: 'Forgot Password' }" class="dropdown-item">Reset Password</router-link>
                        </div>
                        <div v-else>
                          <router-link :to="{ name: 'logout' }" class="dropdown-item">Logout</router-link>
                          <router-link :to="{ name: 'profile' }" class="dropdown-item">Profil</router-link>
                          <router-link :to="{ name: 'Forgot Password' }" class="dropdown-item">Reset Password</router-link>
                          <div class="dropdown-divider"></div>
                          <router-link :to="{ name: 'AdminFinance' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==2">Data Keuangan</router-link>
                          <router-link :to="{ name: 'AdminVolunteer' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==5">Data Volunteer</router-link>
                          <router-link :to="{ name: 'AdminDivision' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==3">Data Divisi dan Departemen</router-link>
                          <router-link :to="{ name: 'AdminMember' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==3 || auth_permission==2">Data Tunas Ranger</router-link>
                          <router-link :to="{ name: 'AdminPartnership' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==5">Data Partnership</router-link>
                          <router-link :to="{ name: 'AdminMerchandise' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==4">Data Merchandise</router-link>
                          <router-link :to="{ name: 'AdminDonation' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==4">Data Donasi</router-link>
                          <router-link :to="{ name: 'AdminArticle' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==5">Data Artikel</router-link>
                          <router-link :to="{ name: 'AdminProject' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==6">Data Proyek</router-link>
                          <router-link :to="{ name: 'AdminSesipb' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==6">Data Sesi Pekan Beasiswa</router-link>
                          <router-link :to="{ name: 'AdminPesertapb' }" class="dropdown-item" v-if="auth_permission==1 || auth_permission==8 || auth_permission==6 || auth_permission==2">Data Peserta Pekan Beasiswa</router-link>
                        </div>
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
</template>
<script>
export default {
	computed:{
        auth_id(){
            return localStorage.getItem('user_id');
        },
        auth_permission(){
            return localStorage.getItem("user_permission");
        },
    },

	
}
</script>