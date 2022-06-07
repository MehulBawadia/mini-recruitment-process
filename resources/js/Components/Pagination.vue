<template>
    <div v-if="links.length > 3">
        <div class="flex justify-center items-center bg-gray-50 rounded-bl-md rounded-br-md py-4 border-t">
            <div v-for="(link, key) in links">
                <div v-if="link.url === null" :key="key" class="px-4 text-gray-400 text-sm leading-4 rounded" v-html="link.label" />

                <Link v-else :key="`link-${key}`" class="mr-1 px-4 py-2 rounded text-sm focus:text-white hover:bg-indigo-700 hover:text-white" :class="{ 'bg-indigo-700 text-white border-0': link.active }" :href="link.url" v-html="link.label" />
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
        Link,
    },

    props: {
        links: Array,
    },
}
</script>
