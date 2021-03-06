/*=========================================================================================
  File Name: actions.js
  Description: Vuex Store - actions
  ----------------------------------------------------------------------------------------
  Item Name: Vuesax Admin - VueJS Dashboard Admin Template
  Version: 1.1
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

import * as MutationTypes from '@/store/mutation_types'
import Cookies from 'js-cookie'
const actions = {

	// ////////////////////////////////////////////
	// SIDEBAR & UI UX
	// ////////////////////////////////////////////

	updateSidebarWidth({ commit }, width) {
		commit('UPDATE_SIDEBAR_WIDTH', width);
	},
	updateI18nLocale({ commit }, locale) {
		commit('UPDATE_I18N_LOCALE', locale);
	},
	toggleContentOverlay({ commit }) {
		commit('TOGGLE_CONTENT_OVERLAY');
	},
	updateTheme({ commit }, val) {
		commit('UPDATE_THEME', val);
  },

  // ////////////////////////////////////////////
  // AUTH
  // ////////////////////////////////////////////

  login ({ commit }) {
    commit(MutationTypes.LOGIN)
  },

  logout ({ commit }) {
    commit(MutationTypes.LOGOUT)
    Cookies.remove('auth_token')
  },

	// ////////////////////////////////////////////
	// COMPONENT
	// ////////////////////////////////////////////	
	
	// VxAutoSuggest
	updateStarredPage({commit}, payload) {
		commit('UPDATE_STARRED_PAGE', payload)
	}
}

export default actions