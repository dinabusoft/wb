<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import Navbar from '@/Components/Navbar.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Head } from '@inertiajs/vue3';


const showingNavigationDropdown = ref(false);

</script>

<template>
    <Head title="Dashboard" />
    <!-- <v-app>
        <Navbar/>
    </v-app> -->
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
            You're logged in!
            </h2>
            <div class="py-4">
                <div class="mx-auto max-w-7xl sm:px-2 lg:px-4">
        </div>
        </div>
        </template>
    </AuthenticatedLayout>
</template>
