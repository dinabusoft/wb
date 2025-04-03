<script setup>
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import { Head } from '@inertiajs/vue3';

const users = ref([
  { id: 1, username: 'admin', name: 'Super Admin', email: 'admin@example.com', role: 'Administrator', status: 'Active' },
  { id: 2, username: 'manager', name: 'John Doe', email: 'manager@example.com', role: 'Manager', status: 'Active' },
  { id: 3, username: 'operator', name: 'Jane Smith', email: 'operator@example.com', role: 'Operator', status: 'Inactive' },
]);

const headers = ref([
  { title: 'Username', key: 'username' },
  { title: 'Name', key: 'name' },
  { title: 'Email', key: 'email' },
  { title: 'Role', key: 'role' },
  { title: 'Status', key: 'status' },
  { title: 'Actions', key: 'actions', align: 'end' }
]);

const newUser = ref({
  username: '',
  name: '',
  email: '',
  password: '',
  role: 'Operator',
  status: 'Active'
});

function addUser() {
  users.value.push({
    id: users.value.length + 1,
    ...newUser.value
  });
  newUser.value = {
    username: '',
    name: '',
    email: '',
    password: '',
    role: 'Operator',
    status: 'Active'
  };
}
</script>

<template>
  <Head title="User Administration" />
  <v-app>
    <Navbar />
    <v-main>
      <v-container class="py-6">
        <v-card>
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-account-cog" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">USER MANAGEMENT</span>
          </v-card-title>
          
          <v-card-text class="pa-4">
            <!-- Add User Form -->
            <v-row class="mb-4">
              <v-col cols="12" md="3">
                <v-text-field v-model="newUser.username" label="Username" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field v-model="newUser.name" label="Full Name" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field v-model="newUser.email" label="Email" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field v-model="newUser.password" label="Password" type="password" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-select v-model="newUser.role" label="Role" :items="['Administrator', 'Manager', 'Operator']" variant="outlined" density="compact"></v-select>
              </v-col>
              <v-col cols="12" md="3">
                <v-select v-model="newUser.status" label="Status" :items="['Active', 'Inactive']" variant="outlined" density="compact"></v-select>
              </v-col>
              <v-col cols="12" md="3" class="d-flex align-end">
                
              </v-col>
            </v-row>
            <v-btn color="#303F9F" variant="flat" @click="addUser" class="text-none">
                  <v-icon left>mdi-account-plus</v-icon> <v-spacer class="ms-2"></v-spacer>
                  Add User
                </v-btn>
            <!-- Users Table -->
            <v-data-table
              :headers="headers"
              :items="users"
              :items-per-page="10"
            >
              <template v-slot:item.status="{ item }">
                <v-chip :color="item.status === 'Active' ? 'green' : 'red'" size="small" class="text-white">
                  {{ item.status }}
                </v-chip>
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn icon variant="text" color="#303F9F">
                  <v-icon>mdi-account-edit</v-icon>
                </v-btn>
                <v-btn icon variant="text" color="#303F9F">
                  <v-icon>mdi-account-remove</v-icon>
                </v-btn>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-container>
    </v-main>
  </v-app>
</template>