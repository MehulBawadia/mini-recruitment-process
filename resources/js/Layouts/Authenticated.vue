<script setup>
import { ref } from 'vue';
import BreezeDropdown from '@/Components/Dropdown.vue';
import BreezeDropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import Navigation from '@/Components/Navigation.vue';
import MobileNavigation from '@/Components/MobileNavigation.vue';

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
            <div class="flex flex-wrap relative">
                <Navigation />
                <MobileNavigation :showingNavigationDropdown="showingNavigationDropdown" />

                <div class="w-full md:w-3/4 lg:w-5/6">
                    <div class="h-16 bg-indigo-900 md:bg-white flex items-center justify-between">
                        <div class="py-6 px-4 sm:px-6 lg:px-8 flex items-center justify-between w-full">
                            <h2 class="font-semibold sm:text-xl text-white md:text-gray-800 leading-tight">
                                <span class="hidden md:block">{{ $page.props.companyName }}</span>
                                <span class="block md:hidden">{{ $page.props.appName }}</span>
                            </h2>

                            <div class="flex items-center md:hidden">
                                <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:text-gray-500 transition duration-150 ease-in-out">
                                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                        <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="hidden md:flex md:items-center md:ml-6 pr-8">
                            <!-- Settings Dropdown -->
                            <div class="ml-3 relative">
                                <BreezeDropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button" class="w-32 flex items-center justify-end py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
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
