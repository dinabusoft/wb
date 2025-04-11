<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';

const items = ref([
  { title: 'Users', route: '/user',href:'/users' },
  { title: 'Customers', route: '/customer',href:'/mastercustomers' },
  { title: 'Materials', route: '/material',href:'/mastermaterials' },
  { title: 'Transactions', route: '/transaction',href:'/transactions' }
]);

const showingProfileDropdown = ref(false);

const currentRoute = computed(() => usePage().url);
</script>

<template>
  <v-app-bar color="#303F9F">
    <!-- Bagian kiri (Tabs) -->
    <v-tabs>
      <v-tab :href="route('home')" :active="currentRoute.startsWith('/home')">Home</v-tab>
      <v-tab :href="route('report')" :active="currentRoute.startsWith('/report')">Report</v-tab>
      <v-tab :href="route('setting')" :active="currentRoute.startsWith('/setting')">Setting</v-tab>
      
      <!-- Administration Menu -->
      <div class="text-center">
        <v-menu open-on-hover>
          <template v-slot:activator="{ props }">
            <v-tab v-bind="props">Administration</v-tab>
          </template>
          <v-list style="background-color: #303F9F; color: white;">
            <v-list-item
              v-for="(item, index) in items"
              :key="index"
              :value="index"
              :href="item.href"
            >
              <v-list-item-title>{{ item.title }}</v-list-item-title>
            </v-list-item>
          </v-list>
        </v-menu>
      </div>
    </v-tabs>

    <!-- Spacer untuk mendorong menu ke kanan -->
    <v-spacer></v-spacer>

    <!-- Profile Dropdown (Paling Kanan) -->
    <v-menu v-model="showingProfileDropdown" offset-y>
      <template v-slot:activator="{ props }">
        <v-btn v-bind="props" variant="text" class="text-white">
          <span>{{ $page.props.auth.user.name }}</span>
          <v-icon right>mdi-chevron-down</v-icon>
        </v-btn>
      </template>
      <v-list style="background-color: #303F9F; color: white;">
        <v-list-item>
          <v-list-item-title class="px-4 py-2">
            <div class="font-medium text-base text-white">
              {{ $page.props.auth.user.name }}
            </div>
            <div class="font-medium text-sm text-gray-300">
              {{ $page.props.auth.user.email }}
            </div>
          </v-list-item-title>
        </v-list-item>
        <v-divider></v-divider>
        <v-list-item>
          <Link 
            :href="route('profile.edit')" 
            class="block w-full px-4 py-2 text-left text-sm hover:bg-blue-700"
          >
            Profile
          </Link>
        </v-list-item>
        <v-list-item>
          <Link 
            :href="route('logout')" 
            method="post" 
            as="button"
            class="block w-full px-4 py-2 text-left text-sm hover:bg-blue-700"
          >
            Log Out
          </Link>
        </v-list-item>
      </v-list>
    </v-menu>
  </v-app-bar>
</template>

<style scoped>
/* Style untuk hover effect */
.v-list-item:hover {
  background-color: rgba(255, 255, 255, 0.1);
}
</style>