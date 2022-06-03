<script setup>
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <BreezeGuestLayout>
        <Head title="Log in" />

        <div class="w-full max-w-md">
            <Link href="/" class="text-center">
                <!-- Comes from the HandleInertiaRequest -->
                <h1 class="text-4xl font-bold text-white">{{ $inertia.page.props.appName }}</h1>
            </Link>

            <div class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden">
                <h3 class="text-2xl font-bold text-indigo-800 text-center mt-8">Welcome Back!</h3>
                <div class="mx-auto mt-6 w-24 border-b-2"></div>

                <BreezeValidationErrors class="mt-6 px-10" />

                <form @submit.prevent="submit">
                    <div class="px-10 py-6">
                        <div>
                            <BreezeLabel for="email" value="Email" />
                            <BreezeInput id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
                        </div>

                        <div class="mt-6">
                            <BreezeLabel for="password" value="Password" />
                            <BreezeInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="current-password" />
                        </div>

                        <label class="flex items-center select-none mt-6">
                            <BreezeCheckbox name="remember" v-model:checked="form.remember" />
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                    </div>

                    <div class="px-10 py-4 bg-gray-100 border-t border-gray-100 flex">
                        <BreezeButton class="flex items-center ml-auto" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Login</BreezeButton>
                    </div>
                </form>
            </div>
        </div>
    </BreezeGuestLayout>
</template>
