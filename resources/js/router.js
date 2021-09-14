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
  ]

const router = createRouter({
  history: createWebHistory(),
  routes,
  linkActiveClass:'active'
})

export default router 