<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Head } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);

const item1 = [
    { title: 'Users', route: 'profile.edit' },
    { title: 'Customers' },
    { title: 'Materials' },
]

</script>

<template>
    <Head title="Home" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
    <v-toolbar>
        <v-btn>Home</v-btn>
        <v-btn>Report</v-btn>
        <v-btn>Setting</v-btn>
        <div class="text-center">
            <v-menu
            open-on-hover>
                <template v-slot:activator="{ props }">
        <v-btn v-bind="props">Administration</v-btn>
            </template>
            <v-list>
            <v-list-item
            v-for="(item, index) in item1"
            :key="index"
            :value="index"
            >
                <v-list-item-title>{{ item.title }}</v-list-item-title>
                </v-list-item>
            </v-list>
            </v-menu>
        </div>
        <v-btn
            :href="route('logout')"
            method="post"
            as="button"
        >Exit</v-btn>
        <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:outline-none"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                            Log Out
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        
    </v-toolbar>
            </h2>
            <div class="py-4">
                <div class="mx-auto max-w-7xl sm:px-2 lg:px-4">
    <div>       
        <v-sheet
            :elevation="20"
            :height="120"
            :width="1200"
            border
            color="black"
            rounded
        ></v-sheet></div>
        </div>
        </div>
        </template>
        <div class="py-1">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div
                    class="overflow-hidden bg-white shadow-sm sm:rounded-lg"
                >
                    <div class="p-6 text-gray-900">
                <v-sheet
                        :elevation="11"
                        :height="600"
                        :width="400"
                        border
                        color="gray"
                        rounded
                ></v-sheet>
                
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
