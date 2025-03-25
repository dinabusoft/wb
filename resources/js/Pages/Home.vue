<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
const item1 = [
    { title: 'Users' },
    { title: 'Customers' },
    { title: 'Materials' },
]
const item2 = [
    { title: 'Item #1',value: 1,},
    { title: 'Item #2',value: 2,},
    { title: 'Item #3',value: 3,},
    { title: 'Item #4',value: 4,},
    { title: 'Item #5',value: 5,},
    { title: 'Item #6',value: 6,},
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
