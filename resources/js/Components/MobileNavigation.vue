<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

defineProps(['showingNavigationDropdown']);

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
    <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="md:hidden w-48 border absolute right-6 top-14 rounded bg-indigo-900">
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
        <div class="border-t border-gray-200">
            <Link class="px-4 py-2 text-sm text-white transition ease-in-out duration-150 focus:outline-none focus:bg-transparent" :href="route('logout')" method="post" as="button">
                Log Out
            </Link>
        </div>
    </div>
</template>
