<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';

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
    <div class="hidden md:block w-1/3 md:w-1/4 lg:w-1/6 bg-indigo-900">
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
</template>
