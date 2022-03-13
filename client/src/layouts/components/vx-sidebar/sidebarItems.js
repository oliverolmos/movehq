/*=========================================================================================
  File Name: sidebarItems.js
  Description: Sidebar Items list. Add / Remove menu items from here.
  Strucutre:
  				url 		=> router path
  				name 		=> name to display in sidebar
  				slug 		=> router path name
  				icon 		=> Feather Icon component/icon name
  				tag 		=> text to display on badge
  				tagColor 	=> class to apply on badge element
  				i18n 		=> Internationalization
  				submenu 	=> submenu of current item (current item will become dropdown )
  							NOTE: Submenu don't have any icon(you can add icon if u want to display)
  				isDisabled 	=> disable sidebar item/group
  ----------------------------------------------------------------------------------------
  Item Name: Vuesax Admin - VueJS Dashboard Admin Template
  Version: 1.1
  Author: Pixinvent
  Author URL: http://www.themeforest.net/user/pixinvent
==========================================================================================*/
import store from '@/store/store'

export default {
  init(){
    let sidebarItems = [
      {
        header: 'Main'
      },
      {
        url: "/contacts",
        name: "Contacts",
        slug: "contacts",
        icon: "AtSignIcon",
      },
      
    ]
    
    // Entries for admin
    if (store.state.AppActiveUser && store.state.AppActiveUser.admin){
      
      sidebarItems.push({
        url: "/users",
        name: "Users",
        slug: "users",
        icon: "UsersIcon",
      })
    
    }
    return sidebarItems
  }
}