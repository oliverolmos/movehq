/*=========================================================================================
  File Name: router.js
  Description: Routes for vue-router. Lazy loading is enabled.
  Object Strucutre:
  					path => router path
  					name => router name
  					component(lazy loading) => component to load
  ----------------------------------------------------------------------------------------
  Item Name: Vuesax Admin - VueJS Dashboard Admin Template
  Version: 1.1
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/


import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
	base: process.env.BASE_URL,
	routes: [
		{
			// =============================================================================
			// MAIN LAYOUT ROUTES
			// =============================================================================
			path: '',
			component: () => import('./layouts/main/Main.vue'),
			children: [
				// =============================================================================
				// Theme Routes
				// =============================================================================
				{
					path: '/',
					name: 'home',
					component: () => import('./views/Home.vue'),
				},
				{
					path: '/contacts',
					name: 'contacts',
					component: () => import('./views/contacts/Contacts.vue'),
					meta: {
						pageTitle: 'Contacts',
						breadcrumb: [
							{ title: 'Home', url: '/'},
							{ title: 'Contacts', active: true}
						]
					}
				},
				{
					path: '/contacts/new',
					component: () => import('./views/contacts/NewContact.vue'),
					meta: {
						pageTitle: 'New Contact',
						breadcrumb: [
							{ title: 'Home', url: '/'},
							{ title: 'Contacts', url: '/contacts'},
							{ title: 'New Contact', active: true}
						]
					},
				},
				{
					path: '/users',
					name: 'users',
					component: () => import('./views/users/Users.vue'),
					meta: {
						pageTitle: 'Users',
						breadcrumb: [
							{ title: 'Home', url: '/'},
							{ title: 'Users', active: true}
						]
					}
				},
				{
					path: '/users/new',
					component: () => import('./views/users/NewUser.vue'),
					meta: {
						pageTitle: 'New User',
						breadcrumb: [
							{ title: 'Home', url: '/'},
							{ title: 'Users', url: '/users'},
							{ title: 'New User', active: true}
						]
					},
				},
				{
					path: '/users/:id',
					component: () => import('./views/users/EditUser.vue'),
					meta: {
						pageTitle: 'Update User',
						breadcrumb: [
							{ title: 'Home', url: '/'},
							{ title: 'Users', url: '/users'},
							{ title: 'Edit User', active: true}
						]
					}
				},
			],
		},
		// =============================================================================
		// FULL PAGE LAYOUTS
		// =============================================================================
		{
			path: '',
			component: () => import('@/layouts/full-page/FullPage.vue'),
			children: [
				// =============================================================================
				// PAGES
				// =============================================================================
				{
					path: '/pages/login',
					name: 'pageLogin',
					component: () => import('@/views/pages/Login.vue')
				},
				{
					path: '/pages/logout',
					name: 'pageLogout',
					component: () => import('@/views/pages/Logout.vue')
				},
				{
					path: '/pages/error-404',
					name: 'pageError404',
					component: () => import('@/views/pages/Error404.vue')
				},
				{
					path: '/pages/error-403',
					name: 'pageError403',
					component: () => import('@/views/pages/Error403.vue')
				},
			]
		},
		// Redirect to 404 page, if no match found
		{
			path: '*',
			redirect: '/pages/error-404'
		}
	],
})