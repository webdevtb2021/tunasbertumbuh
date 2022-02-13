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

const routes = [
  {
      path:"/",
      name: "homepage",
      component: GuestHomepage
    },
    {
      path:"/donations",
      name: "donations",
      component: GuestDonations
    },
    {
      path:"/donationGuest",
      name: "donationGuest",
      component: GuestDonations
    },
    {
      path:"/partnerships",
      name: "partnerships",
      component: GuestPartnerships
    },
    {
      path:"/projects",
      name: "projects",
      component: GuestProjects
    },
    {
      path: '/projects/:id', 
      component: GuestProject,
      name: 'projects.show',
      props: true
    },
    {
      path:"/articles",
      name: "articles",
      component: GuestArticles
    },
    {
      path: '/articles/:id', 
      component: GuestArticle,
      name: 'articles.show',
      props: true
    },

    {
      path:"/members",
      name: "members",
      component: GuestMembers
    },

    {
      path: '/members/:period', 
      component: GuestMembers,
      name: 'indexMembers',
      props: true
    },

    {
      path:"/merchandises",
      name: "merchandises",
      component: GuestMerchandises
    },

    {
      path:"/testimonies",
      name: "testimonies",
      component: GuestTestimonies
    },

    {
      path:"/finance",
      name: "finance",
      component: GuestFinance
    },

    {
      path:"/openrecruitments",
      name: "openrecruitments",
      component: GuestOpenRecruitment
    },

    {
      path:"/volunteers",
      name: "volunteers",
      component: GuestVolunteer
    },

    {
      path:"/adminfinance",
      name: "AdminFinance",
      component: AdminFinance
    },

    {
      path:"/adminvolunteer",
      name: "AdminVolunteer",
      component: adminVolunteer
    },

    {
      path:"/admindivision",
      name: "AdminDivision",
      component: adminDivision
    },

    {
      path:"/adminmember",
      name: "AdminMember",
      component: adminMember
    },

    {
      path:"/adminmember/:id", 
      component: adminMemberDetail,
      name: 'adminmember.show',
      props: true
    },

    {
      path:"/adminpartnership",
      name: "AdminPartnership",
      component: adminPartnership,
    },
    {
      path:"/adminmerchandise",
      name: "AdminMerchandise",
      component: adminMerchandise
    },

    {
      path:"/admindonation",
      name: "AdminDonation",
      component: adminDonation
    },

    {
      path:"/admindonation/:id", 
      component: donationDetails,
      name: 'admindonation.show',
      props: true
    },


    {
      path:"/adminarticle",
      name: "AdminArticle",
      component: adminArticle
    },

    {
      path:"/adminarticle/:id", 
      component: articleDetails,
      name: 'adminarticle.show',
      props: true
    },


    {
      path:"/adminproject",
      name: "AdminProject",
      component: adminProject
    },

    {
      path:"/adminproject/:id", 
      component: projectDetails,
      name: 'adminproject.show',
      props: true
    },

    {
      path:"/adminsesipb",
      name: "AdminSesipb",
      component: AdminSesipb
    },

    {
      path:"/pekanbeasiswa",
      name: "pekanbeasiswa",
      component: PekanBeasiswa
    },

    {
      path:"/absensipekanbeasiswa",
      name: "absensipekanbeasiswa",
      component: AbsensiPekanBeasiswa
    },

    {
      path:"/adminpesertapb",
      name: "AdminPesertapb",
      component: adminPesertapb
    },

    {
      path:"/adminpesertapb/:id", 
      component: pesertapbDetails,
      name: 'adminpesertapb.show',
      props: true
    },
  ]

const router = createRouter({
  history: createWebHistory(),
  routes,
  linkActiveClass:'active'
})

export default router 