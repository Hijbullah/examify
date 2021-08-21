<template>
    <div class="min-h-screen bg-gray-100">
        <nav class="bg-white border-b border-gray-100">
            <!-- Primary Navigation Menu -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <inertia-link :href="route('students.dashboard')">
                                <application-logo class="block h-9 w-auto" />
                            </inertia-link>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                            <student-nav-link :href="route('students.dashboard')" :active="route().current('students.dashboard')">
                                Dashboard
                            </student-nav-link>

                            <student-nav-link :href="route('students.lectureSheets.index')" :active="route().current('students.lectureSheets.index')">
                                Lecture Sheets
                            </student-nav-link>

                            <student-nav-link :href="route('students.classes.index')" :active="route().current('students.classes.*')">
                                Live Class
                            </student-nav-link>

                            <student-nav-link :href="route('students.exams.index')" :active="route().current('students.exams.*')">
                                My Exam
                            </student-nav-link>

                            <student-nav-link :href="route('students.results.index')" :active="route().current('students.results.*')">
                                My Results
                            </student-nav-link>

                            <student-nav-link :href="route('students.profile.show')" :active="route().current('students.profile.*')">
                                My Profile
                            </student-nav-link>

                            <!-- <student-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                                My Profile
                            </student-nav-link> -->
                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <!-- Settings Dropdown -->
                        <div class="ml-3 relative">
                            <app-dropdown align="right" width="48">
                                <template #trigger>
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            {{ $page.props.auth.user.full_name }}

                                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </span>
                                </template>

                                <template #content>
                                    <!-- Account Management -->
                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Manage Account
                                    </div>

                                    <!-- <jet-dropdown-link :href="route('profile.show')">
                                        Profile
                                    </jet-dropdown-link> -->

                                    <div class="border-t border-gray-100"></div>

                                     <!-- Authentication -->
                                    <form method="POST" @submit.prevent="logout">
                                        <app-dropdown-link as="button">
                                            Log out
                                        </app-dropdown-link>
                                    </form>
                                </template>
                            </app-dropdown>
                        </div>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <student-responsive-nav-link :href="route('students.dashboard')" :active="route().current('students.dashboard')">
                        Dashboard
                    </student-responsive-nav-link>
                    
                    <student-responsive-nav-link :href="route('students.lectureSheets.index')" :active="route().current('students.lectureSheets.index')">
                        Lecture Sheets
                    </student-responsive-nav-link>

                    <student-responsive-nav-link :href="route('students.classes.index')" :active="route().current('students.classes.index')">
                        Live Class
                    </student-responsive-nav-link>

                    <student-responsive-nav-link :href="route('students.exams.index')" :active="route().current('students.exams.*')">
                        My Exam
                    </student-responsive-nav-link>

                    <student-responsive-nav-link :href="route('students.results.index')" :active="route().current('students.results.*')">
                        My Results
                    </student-responsive-nav-link>

                    <student-responsive-nav-link :href="route('students.profile.show')" :active="route().current('students.profile.*')">
                        My Profile
                    </student-responsive-nav-link>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200">
                    <div class="flex items-center px-4">
                        <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.full_name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <!-- <student-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">
                            Profile
                        </student-responsive-nav-link> -->
                        
                        <!-- Authentication -->
                        <form method="POST" @submit.prevent="logout">
                            <student-responsive-nav-link as="button">
                                Logout
                            </student-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        <header class="bg-white shadow" v-if="$slots.header">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <slot name="header" />
            </div>
        </header>

        <!-- Page Content -->
        <main>
            <slot />
        </main>

        <!-- Modal Portal -->
        <portal-target name="modal" multiple>
        </portal-target>
    </div>
</template>

<script>
    import ApplicationLogo from '@/Components/Shared/ApplicationLogo'
    import AppDropdown from '@/Components/Shared/Dropdown/Dropdown'
    import AppDropdownLink from '@/Components/Shared/Dropdown/DropdownLink'
    import StudentNavLink from '@/Components/Student/NavLink'
    import StudentResponsiveNavLink from '@/Components/Student/ResponsiveNavLink'

    export default {
        components: {
            ApplicationLogo,
            AppDropdown,
            AppDropdownLink,
            StudentNavLink,
            StudentResponsiveNavLink,
        },

        data() {
            return {
                showingNavigationDropdown: false,
            }
        },

        methods: {
            logout() {
                this.$inertia.post(route('logout'));
            },
        }
    }
</script>
