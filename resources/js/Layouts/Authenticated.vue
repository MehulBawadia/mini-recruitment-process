<script setup>
import { ref } from 'vue';
import BreezeApplicationLogo from '@/Components/ApplicationLogo.vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import BreezeNavLink from '@/Components/NavLink.vue';
import BreezeResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

const showingNavigationDropdown = ref(false);

const isDashboardLinkActive = () => {
    let componentName = Inertia.page.component;

    if (componentName === 'Dashboard') {
        return true;
    }

    return false;
};

const isAgenciesLinkActive = () => {
    let componentName = Inertia.page.component;

    if (componentName === 'Agencies/List' || componentName === 'Agencies/Create' || componentName === 'Agencies/Show' || componentName === 'Agencies/Edit') {
        return true;
    }

    return false;
};

</script>

<template>
    <div>
        <div class="min-h-screen bg-indigo-50">
            <div class="flex relative">
                <div class="hidden sm:block w-64 bg-indigo-900">
                    <div class="h-16 px-4 sm:px-6 lg:px-8 text-white flex items-center font-bold text-2xl">{{ $page.props.appName }}</div>

                    <div class="bg-indigo-800 min-h-screen pt-12 px-8 space-y-6">
                        <Link :href="route('dashboard')" class="text-gray-300 hover:text-white transition ease-in-out duration-150" :class="{'text-white' : isDashboardLinkActive() }">
                            Dashboard
                        </Link>

                        <div v-if="$page.props.auth.userIsHR">
                            <Link :href="route('agencies.index')" class="text-gray-300 hover:text-white transition ease-in-out duration-150" :class="{'text-white' : isAgenciesLinkActive() }">
                                Agencies
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden absolute right-2 top-14 rounded bg-indigo-900">
                    <div class="py-1">
                        <Link class="text-indigo-100 px-4" :href="route('dashboard')" :active="route().current('dashboard')">
                            Dashboard
                        </Link>
                    </div>

                    <div class="px-4 py-1" v-if="$page.props.auth.userIsHR">
                        <Link :href="route('agencies.index')" class="text-gray-300 hover:text-white transition ease-in-out duration-150" :class="{'text-white' : isAgenciesLinkActive() }">
                            Agencies
                        </Link>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div class="pt-4 pb-1 border-t border-gray-200">
                        <div class="px-4">
                            <div class="font-medium text-base text-gray-800">{{ $page.props.auth.user.name }}</div>
                            <div class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <BreezeResponsiveNavLink :href="route('logout')" method="post" as="button">
                                Log Out
                            </BreezeResponsiveNavLink>
                        </div>
                    </div>
                </div>

                <div class="w-full">
                    <div class="h-16 bg-white flex items-center justify-between">
                        <div class="py-6 px-4 sm:px-6 lg:px-8 flex items-center justify-between w-full">
                            <slot name="header" />

                            <div class="flex items-center sm:hidden">
                                <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="hidden sm:flex sm:items-center sm:ml-6 pr-8">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="w-32 inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                                {{ $page.props.auth.user.first_name }} {{ $page.props.auth.user.last_name }}

                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <BreezeDropdownLink :href="route('logout')" method="post" as="button">
                                            Log Out
                                        </BreezeDropdownLink>
                                    </template>
                                </BreezeDropdown>
                            </div>
                        </div>
                    </div>

                    <!-- Page Content -->
                    <main class="mt-12 px-4 sm:px-6 lg:px-8">
                        <slot />
                    </main>
                </div>
            </div>
        </div>
    </div>
</template>
