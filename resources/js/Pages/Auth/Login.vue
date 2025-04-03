<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
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
    <GuestLayout>
        <Head title="Log in" />
       <!-- <div><p>Don't have an account? <b><a href="register" class="link-info rounded-md text-purple-700"  color="purple" >Register here</a></b></p></div>
            <div class="col-lg-6 d-flex align-items-center gradient-custom-2"></div> 
            <br>
            <br> -->
        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 block">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <b>
                    <span class="ms-2 text-sm text-gray-600"
                        >Remember me</span
                    >
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="ms-32 text-sm text-purple-600 underline hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    Forgot your password?
                </Link
                >
                    </b>
                </label>
            </div>

            <div class="mt-4 flex items-center justify-center">
                <PrimaryButton
                    class="mt-4 mb-6 flex items-center justify-center"
                    style="width: 500px;"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Sign In
                </PrimaryButton>
            </div>
            <!-- <div class="mt-5 block"> -->
                <!-- <label class="flex items-center text-sm text-gray-400 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"> -->
            <!-- <p>Don't have an account?   <a href="register" class="link-info">Register here</a></p> -->   
        <!-- </label> -->
    <!-- </div> -->
        </form>
    </GuestLayout>
</template>
