/*=========================================================================================
  File Name: state.js
  Description: Vuex Store - state
  ----------------------------------------------------------------------------------------
  Item Name: Vuesax Admin - VueJS Dashboard Admin Template
  Version: 1.1
  Author: Pixinvent
  Author URL: hhttp://www.themeforest.net/user/pixinvent
==========================================================================================*/

import navbarSearchAndPinList from '@/layouts/components/navbarSearchAndPinList'
import themeConfig from '@/../themeConfig.js'
import colors from '@/../themeConfig.js'
import User from '@/models/User.js'
import Cookies from 'js-cookie'

const state = {
	isSidebarActive: true,
	breakpoint: null,
	sidebarWidth: "default",
	reduceButton: themeConfig.sidebarCollapsed,
	bodyOverlay: false,
	sidebarItemsMin: false,
	theme: themeConfig.theme || 'light',
	navbarSearchAndPinList: navbarSearchAndPinList,
    AppActiveUser: User.from(Cookies.get('auth_token')),
	themePrimaryColor: colors.primary,
}

export default state