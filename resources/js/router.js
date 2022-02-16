import { createRouter, createWebHistory } from 'vue-router'

import GuestHomepage from "./guest/homepage.vue";
import GuestDonations from "./guest/donations";
import GuestPartnerships from "./guest/partnerships";
import GuestProjects from "./guest/projects";
import GuestProject from "./guest/project";
import GuestArticles from "./guest/articles";
import GuestArticle from "./guest/article";
import GuestMembers from "./guest/members";
import GuestMerchandises from "./guest/merchandises";
import GuestTestimonies from "./guest/testimonies";
import GuestFinance from "./guest/finance";
import GuestOpenRecruitment from "./guest/openrecruitments";
import GuestVolunteer from "./guest/volunteers";
import AdminFinance from "./admin/adminFinance";
import adminVolunteer from "./admin/adminVolunteer";
import adminPartnership from "./admin/adminPartnership";
import adminDivision from "./admin/adminDivision";
import Login from "./guest/login";
import Logout from "./guest/logout";
import Register from "./guest/register";
import SendResetPassword from "./guest/sendResetPassword";
import ResetPassword from "./guest/resetPassword";
import adminMember from "./admin/adminMember";
import adminMemberDetail from "./admin/adminPosition";
import adminMerchandise from "./admin/adminMerchandise";
import adminDonation from "./admin/adminDonation";
import donationDetails from "./components/donationDetails";
import adminArticle from "./admin/adminArticle";
import articleDetails from "./components/articleDetails";
import adminProject from "./admin/adminProject";
import projectDetails from "./components/projectDetails";
import AdminSesipb from "./admin/adminSesipb";
import PekanBeasiswa from "./guest/pekanbeasiswa";
import AbsensiPekanBeasiswa from "./guest/absensipekanbeasiswa";
import adminPesertapb from "./admin/adminPesertapb";
import pesertapbDetails from "./components/pesertapbDetails";




// 0: Have no access admin
// 1: all access
// 2: Web Admin / Web Dev
// 3: HR / Human Relation
// 4: MFD / Marketing and Fundraising
// 5: CPD / Comm and Partner
// 6: PMD / Project Management

// menurut dokumen
// 1 => guest
// 2 => HR admin, division, dkk
// 3 => MFD admin
// 4 => CPD admin, volunteer
// 5 => PMD admin
// 6 => AFD admin, finance
// 7 => WEB admin

// finance sementara diarahin ke Marketing and Fundraising

const routes = [
  	{
	  path:"/",
	  name: "homepage",
	  component: GuestHomepage,
	  meta: { authorize : [] }
	},
	{
	  path: "/login",
	  name: "login",
	  component: Login,
	  meta: { authorize : [] }
	},
	{
		path: "/register",
		name: "register",
		component : Register,
		meta: { authorize: [] }
	},
	{
		path: "/logout",
		name: "logout",
		component : Logout,
		meta: { authorize: [1, 2, 3, 4, 5, 6] }
	},
	{
	  path:"/donations",
	  name: "donations",
	  component: GuestDonations,
	  meta: { authorize : [] }
	},
	{
	  path:"/donationGuest",
	  name: "donationGuest",
	  component: GuestDonations,
	  meta: { authorize : [] }
	},
	{
	  path:"/partnerships",
	  name: "partnerships",
	  component: GuestPartnerships,
	  meta: { authorize : [] }
	},
	{
	  path:"/projects",
	  name: "projects",
	  component: GuestProjects,
	  meta: { authorize : [] }
	},
	{
	  path: '/projects/:id', 
	  component: GuestProject,
	  name: 'projects.show',
	  props: true,
	  meta: { authorize : [] }
	},
	{
	  path:"/articles",
	  name: "articles",
	  component: GuestArticles,
	  meta: { authorize : [] }
	},
	{
	  path: '/articles/:id', 
	  component: GuestArticle,
	  name: 'articles.show',
	  props: true,
	  meta: { authorize : [] }
	},

	{
	  path:"/members",
	  name: "members",
	  component: GuestMembers,
	  meta: { authorize : [] }
	},

	{
	  path: '/members/:period', 
	  component: GuestMembers,
	  name: 'indexMembers',
	  props: true,
	  meta: { authorize : [] }
	},

	{
	  path:"/merchandises",
	  name: "merchandises",
	  component: GuestMerchandises,
	  meta: { authorize : [] }
	},

	{
	  path:"/testimonies",
	  name: "testimonies",
	  component: GuestTestimonies,
	  meta: { authorize : [] }
	},

	{
	  path:"/finance",
	  name: "finance",
	  component: GuestFinance,
	  meta: { authorize : [] }
	},

	{
	  path:"/openrecruitments",
	  name: "openrecruitments",
	  component: GuestOpenRecruitment,
	  meta: { authorize : [] }
	},

	{
		path:"/volunteers",
		name: "volunteers",
		component: GuestVolunteer,
		meta: { authorize : [] }
	},

	{
		// AFD Admin
		path:"/adminfinance",
		name: "AdminFinance",
		component: AdminFinance,
		meta: { authorize : [4] }
	},

	{
		// CPD Admin
		path:"/adminvolunteer",
		name: "AdminVolunteer",
		component: adminVolunteer,
		meta: { authorize : [4] }
	},

	{
		// HR Admin
		path:"/admindivision",
		name: "AdminDivision",
		component: adminDivision,
		meta: { authorize : [3] }
	},

	{
		// Forgot Password
		path:"/sendPassword",
		name: "Forgot Password",
		component: SendResetPassword,
		meta: { authorize : [] }
	},

	{
		// Reset Password
		path:"/reset-password/:token",
		name: "Reset Password",
		component: ResetPassword,
		meta: { authorize : [] }
	},

    {
      path:"/adminmember",
      name: "AdminMember",
      component: adminMember,
	  meta: { authorize : [] }
    },

    {
      path:"/adminmember/:id", 
      component: adminMemberDetail,
      name: 'adminmember.show',
      props: true,
	  meta: { authorize : [] }
    },

    {
      path:"/adminpartnership",
      name: "AdminPartnership",
      component: adminPartnership,
	  meta: { authorize : [] }
    },
    {
      path:"/adminmerchandise",
      name: "AdminMerchandise",
      component: adminMerchandise,
	  meta: { authorize : [] }
    },

    {
      path:"/admindonation",
      name: "AdminDonation",
      component: adminDonation,
	  meta: { authorize : [] }
    },

    {
      path:"/admindonation/:id", 
      component: donationDetails,
      name: 'admindonation.show',
      props: true,
	  meta: { authorize : [] }
    },


    {
      path:"/adminarticle",
      name: "AdminArticle",
      component: adminArticle,
	  meta: { authorize : [] }
    },

    {
      path:"/adminarticle/:id", 
      component: articleDetails,
      name: 'adminarticle.show',
      props: true,
	  meta: { authorize : [] }
    },


    {
      path:"/adminproject",
      name: "AdminProject",
      component: adminProject,
	  meta: { authorize : [] }
    },

    {
      path:"/adminproject/:id", 
      component: projectDetails,
      name: 'adminproject.show',
      props: true,
	  meta: { authorize : [] }
    },

    {
      path:"/adminsesipb",
      name: "AdminSesipb",
      component: AdminSesipb,
	  meta: { authorize : [] }
    },

    {
      path:"/pekanbeasiswa",
      name: "pekanbeasiswa",
      component: PekanBeasiswa,
	  meta: { authorize : [] }
    },

    {
      path:"/absensipekanbeasiswa",
      name: "absensipekanbeasiswa",
      component: AbsensiPekanBeasiswa,
	  meta: { authorize : [] }
    },

    {
      path:"/adminpesertapb",
      name: "AdminPesertapb",
      component: adminPesertapb,
	  meta: { authorize : [] }
    },

    {
      path:"/adminpesertapb/:id", 
      component: pesertapbDetails,
      name: 'adminpesertapb.show',
      props: true,
	  meta: { authorize : [] }
    },
  ]

const router = createRouter({
  history: createWebHistory(),
  routes,
  linkActiveClass:'active'
})

router.beforeEach((to, from, next) => {
	console.log(localStorage.getItem("token"))
	const { authorize } = to.meta;
	console.log("======================================")
	console.log(authorize);
	console.log(authorize.includes(localStorage.getItem("user_permission")));
	console.log(localStorage.getItem("user_permission"))
	console.log(typeof(localStorage.getItem("user_permission")))
	console.log("======================================")

	// kalau akses halaman login tapi udah login duluan
	if((to.path == "/login" || to.path == "/register") && localStorage.getItem("token") != null) 
	{
		swal.fire({
			title: "Failed !",
			text: "Already logged in",
			icon: 'info',
		})
		return next({path: '/'})
	}


	// kalo array meta kosong, berarti semua permission boleh akses halaman
	if(authorize.length > 0) 
	{
		// cek kalau ke suatu halaman tapi user belum login
		if(localStorage.getItem("token") == null) 
		{
			swal.fire({
				title: "Failed !",
				text: "Not logged in yet, redirecting you to login page",
				icon: 'warning',
			})
			// redirect ke login, nanti kondisi akan dicek pada if diatas
			return next({path: '/login'})
		}
		else if(!authorize.includes(parseInt(localStorage.getItem("user_permission"))))
		{
			swal.fire({
				title: "Failed !",
				text: "Not permitted, redirecting to homepages",
				icon: 'warning',
			})
			return next({path: '/'})
		}
		else
		{
			// selain itu, dibolehkan
			return next();
		}
	}
	else
	{
		// selain itu, dibolehkan
		return next();
	}
})	

export default router 