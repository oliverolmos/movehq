<!-- =========================================================================================
	File Name: TheNavbar.vue
	Description: Navbar component
	Component Name: TheNavbar
	----------------------------------------------------------------------------------------
	Item Name: Vuesax Admin - VueJS Dashboard Admin Template
	Version: 1.1
	Author: Pixinvent
	Author URL: hhttp://www.themeforest.net/user/pixinvent
========================================================================================== -->


<template>
<div class="relative">
	<div class="vx-navbar-wrapper">
		<vs-navbar class="vx-navbar navbar-custom" :color="navbarColor" :class="classObj">

			<!-- SM - OPEN SIDEBAR BUTTON -->
			<feather-icon class="sm:inline-flex xl:hidden cursor-pointer mr-1" icon="MenuIcon" @click.stop="showSidebar"></feather-icon>

			<template v-if="breakpoint != 'md'">
				<!-- STARRED PAGES - FIRST 10 -->
				<ul class="vx-navbar__starred-pages flex">
					<li class="starred-page" v-for="page in starredPagesLimited" :key="page.url">
						<vx-tooltip :text="page.label" position="bottom" delay=".3s">
							<feather-icon svgClasses="h-6 w-6" class="p-2 cursor-pointer" :icon="page.labelIcon" @click="$router.push(page.url)"></feather-icon>
						</vx-tooltip>
					</li>
				</ul>

				<!-- STARRED PAGES MORE -->
				<div class="vx-navbar__starred-pages--more-dropdown" v-if="starredPagesMore.length">
					<vs-dropdown vs-custom-content vs-trigger-click>
						<feather-icon icon="ChevronDownIcon" svgClasses="h-4 w-4" class="cursor-pointer p-2"></feather-icon>
						<vs-dropdown-menu>
							<ul class="vx-navbar__starred-pages-more--list">
								<li class="starred-page--more flex items-center cursor-pointer" v-for="page in starredPagesMore" :key="page.url" @click="$router.push(page.url)">
									<feather-icon svgClasses="h-5 w-5" class="ml-2 mr-1" :icon="page.labelIcon"></feather-icon>
									<span class="px-2 pt-2 pb-1">{{ page.label }}</span>
								</li>
							</ul>
						</vs-dropdown-menu>
					</vs-dropdown>
				</div>

				<div class="bookmark-container">
					<feather-icon icon="StarIcon" :svgClasses="['stoke-current text-warning', {'text-white': navbarColor != '#fff'}]" class="cursor-pointer p-2" @click="showBookmarkPagesDropdown = !showBookmarkPagesDropdown" />	<div v-click-outside="outside" class="absolute bookmark-list w-1/3 xl:w-1/4 mt-4" v-if="showBookmarkPagesDropdown">
						<vx-auto-suggest :autoFocus="true" :data="navbarSearchAndPinList" @selected="selected" @actionClicked="actionClicked" inputClassses="w-full" show-action show-pinned background-overlay></vx-auto-suggest>
					</div>
				</div>
			</template>


			<vs-spacer></vs-spacer>

			<!-- NOTIFICATIONS -->
			<!-- <vs-dropdown vs-custom-content vs-trigger-click>
				<feather-icon icon="BellIcon" class="cursor-pointer mx-6 mt-1" :badge="unreadNotifications.length"></feather-icon>
				<vs-dropdown-menu class="notification-dropdown">
					<div class="notification-top text-center p-5 bg-primary text-white">
						<h3 class="text-white">{{ unreadNotifications.length }} New</h3>
						<p class="opacity-75">App Notifications</p>
					</div>
					<VuePerfectScrollbar ref="mainSidebarPs" class="scroll-area--nofications p-0" :settings="settings">
					<ul class="bordered-items">
						<li v-for="ntf in unreadNotifications" :key="ntf.index" class="flex justify-between px-4 py-4 notification cursor-pointer">
							<div class="flex items-start">
								<feather-icon :icon="ntf.icon" :svgClasses="[`text-${ntf.category}`, 'stroke-current mr-1 h-6 w-6']"></feather-icon>
								<div class="mx-2">
									<span class="font-medium block notification-title" :class="[`text-${ntf.category}`]">{{ ntf.title }}</span>
									<small>{{ ntf.msg }}</small>
								</div>
							</div>
							<small class="mt-1 whitespace-no-wrap">{{ elapsedTime(ntf.time) }}</small>
						</li>
						<li class="flex justify-around p-3 notification cursor-pointer">
							<small>View All Notifications</small>
						</li>
					</ul>
					</VuePerfectScrollbar>
				</vs-dropdown-menu>
			</vs-dropdown> -->

			<!-- SEARCHBAR -->
			<div class="search-full-container w-full h-full absolute pin-l rounded-lg" :class="{'flex': showFullSearch}" v-show="showFullSearch">
				<vx-auto-suggest :autoFocus="showFullSearch" :data="navbarSearchAndPinList" @selected="selected" ref="navbarSearch" @closeSearchbar="showFullSearch = false" placeholder="Search..." class="w-full" inputClassses="w-full input-no-border no-icon-border" icon="SearchIcon" background-overlay></vx-auto-suggest>
				<div class="absolute pin-r h-full z-50">
					<feather-icon icon="XIcon" class="px-4 cursor-pointer h-full close-search-icon" @click="showFullSearch = false"></feather-icon>
				</div>
			</div>
			<feather-icon icon="SearchIcon" @click="showFullSearch = true" class="cursor-pointer"></feather-icon>

			<!-- USER META -->
			<div class="the-navbar__user-meta flex items-center sm:ml-5 ml-2">
				<div class="text-right leading-tight hidden sm:block">
					<p class="font-semibold">{{activeUserInfo.name}}</p>
				</div>
				<vs-dropdown vs-custom-content vs-trigger-click>
					<div class="con-img ml-3"><img :src="require(`@/assets/images/portrait/small/${activeUserInfo.img}`)" alt="" width="40" height="40" class="rounded-full shadow-md cursor-pointer block"></div>
					<vs-dropdown-menu>
						<ul style="min-width: 9rem">
							<li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="$router.push('/pages/profile')"><feather-icon icon="UserIcon" svgClasses="w-4 h-4"></feather-icon> <span class="ml-2">Profile</span></li>
							<li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="$router.push('/apps/email')"><feather-icon icon="MailIcon" svgClasses="w-4 h-4"></feather-icon> <span class="ml-2">Inbox</span></li>
							<li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="$router.push('/apps/todo')"><feather-icon icon="CheckSquareIcon" svgClasses="w-4 h-4"></feather-icon> <span class="ml-2">Tasks</span></li>
							<li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="$router.push('/apps/chat')"><feather-icon icon="MessageSquareIcon" svgClasses="w-4 h-4"></feather-icon> <span class="ml-2">Chat</span></li>
							<vs-divider class="m-1"></vs-divider>
							<li class="flex py-2 px-4 cursor-pointer hover:bg-primary hover:text-white" @click="$router.push('/pages/logout')"><feather-icon icon="LogOutIcon" svgClasses="w-4 h-4"></feather-icon> <span class="ml-2">Logout</span></li>
						</ul>
					</vs-dropdown-menu>
				</vs-dropdown>
			</div>

		</vs-navbar>
	</div>
</div>
</template>

<script>
import VxAutoSuggest from '@/components/vx-auto-suggest/VxAutoSuggest.vue';
import VuePerfectScrollbar from 'vue-perfect-scrollbar'

export default {
    name: "the-navbar",
    props: {
        navbarColor: {
            type: String,
            default: "#fff",
        },
    },
    data() {
        return {
            navbarSearchAndPinList: this.$store.state.navbarSearchAndPinList,
            searchQuery: '',
            showFullSearch: false,
            unreadNotifications: [
                { index: 0, title: 'New Message', msg: 'Are your going to meet me tonight?', icon: 'MessageSquareIcon', time: 'Wed Jan 30 2019 07:45:23 GMT+0000 (GMT)', category: 'primary' },
                { index: 1, title: 'New Order Recieved', msg: 'You got new order of goods.', icon: 'PackageIcon', time: 'Wed Jan 30 2019 07:45:23 GMT+0000 (GMT)', category: 'success' },
                { index: 2, title: 'Server Limit Reached!', msg: 'Server have 99% CPU usage.', icon: 'AlertOctagonIcon', time: 'Thu Jan 31 2019 07:45:23 GMT+0000 (GMT)', category: 'danger' },
                { index: 3, title: 'New Mail From Peter', msg: 'Cake sesame snaps cupcake', icon: 'MailIcon', time: 'Fri Feb 01 2019 07:45:23 GMT+0000 (GMT)', category: 'primary' },
                { index: 4, title: 'Bruce\'s Party', msg: 'Chocolate cake oat cake tiramisu marzipan', icon: 'CalendarIcon', time: 'Fri Feb 02 2019 07:45:23 GMT+0000 (GMT)', category: 'warning' },
            ],
            settings: { // perfectscrollbar settings
                maxScrollbarLength: 60,
                wheelSpeed: .60,
            },
            autoFocusSearch: false,
            showBookmarkPagesDropdown: false,
        }
    },
    watch: {
        '$route'() {
            if (this.showBookmarkPagesDropdown) this.showBookmarkPagesDropdown = false
        }
    },
    computed: {
        data() {
            return this.$store.state.navbarSearchAndPinList;
        },
        activeUserInfo() {
            return this.$store.state.AppActiveUser;
        },
        sidebarWidth() {
            return this.$store.state.sidebarWidth;
        },
        breakpoint() {
            return this.$store.state.breakpoint;
        },
        classObj() {
            if (this.sidebarWidth == "default") return "navbar-default"
            else if (this.sidebarWidth == "reduced") return "navbar-reduced"
            else if (this.sidebarWidth) return "navbar-full"
        },
        starredPages() {
            return this.$store.getters.starredPages;
        },
        starredPagesLimited() { return this.starredPages.slice(0, 10); },
        starredPagesMore() { return this.starredPages.slice(10); }
    },
    methods: {
        showSidebar() {
            this.$store.commit('TOGGLE_IS_SIDEBAR_ACTIVE', true);
        },
        selected(item) {
            this.$router.push(item.url)
            this.showFullSearch = false;
        },
        actionClicked(item) {
            // e.stopPropogation();
            this.$store.dispatch('updateStarredPage', { index: item.index, val: !item.highlightAction });
        },
        showNavbarSearch() {
            this.showFullSearch = true;
        },
        showSearchbar() {
            this.showFullSearch = true;
        },
        elapsedTime(startTime) {
            let x = new Date(startTime);
            let now = new Date();
            var timeDiff = now - x;
            timeDiff /= 1000;

            var seconds = Math.round(timeDiff);
            timeDiff = Math.floor(timeDiff / 60);

            var minutes = Math.round(timeDiff % 60);
            timeDiff = Math.floor(timeDiff / 60);

            var hours = Math.round(timeDiff % 24);
            timeDiff = Math.floor(timeDiff / 24);

            var days = Math.round(timeDiff % 365);
            timeDiff = Math.floor(timeDiff / 365);

            var years = timeDiff;

            if (years > 0) {
                return years + (years > 1 ? ' Years ' : ' Year ') + 'ago';
            } else if (days > 0) {
                return days + (days > 1 ? ' Days ' : ' Day ') + 'ago';
            } else if (hours > 0) {
                return hours + (hours > 1 ? ' Hrs ' : ' Hour ') + 'ago';
            } else if (minutes > 0) {
                return minutes + (minutes > 1 ? ' Mins ' : ' Min ') + 'ago';
            } else if (seconds > 0) {
                return seconds + (seconds > 1 ? `${seconds} sec ago` : 'just now');
            }

            return 'Just Now'
        },
        test() {
            alert();
        },
        outside: function() {
            this.showBookmarkPagesDropdown = false
        },
    },
    directives: {
        'click-outside': {
            bind: function(el, binding) {
                const bubble = binding.modifiers.bubble
                const handler = (e) => {
                    if (bubble || (!el.contains(e.target) && el !== e.target)) {
                        binding.value(e)
                    }
                }
                el.__vueClickOutside__ = handler
                document.addEventListener('click', handler)
            },

            unbind: function(el) {
                document.removeEventListener('click', el.__vueClickOutside__)
                el.__vueClickOutside__ = null

            }
        }
    },
    components: {
        VxAutoSuggest,
        VuePerfectScrollbar
    },
}
</script>