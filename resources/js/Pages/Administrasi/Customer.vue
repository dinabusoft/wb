<script setup>
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import { Head } from '@inertiajs/vue3';

const customers = ref([
  { id: 1, code: 'PT AAA', name: 'Company A', address: 'Jl. Merdeka No.1', phone: '021-1234567', status: 'Active' },
  { id: 2, code: 'PT BBB', name: 'Company B', address: 'Jl. Sudirman No.45', phone: '021-7654321', status: 'Active' },
  { id: 3, code: 'PT CCC', name: 'Company C', address: 'Jl. Thamrin No.12', phone: '021-1122334', status: 'Inactive' },
]);

const headers = ref([
  { title: 'Customer Code', key: 'code' },
  { title: 'Name', key: 'name' },
  { title: 'Address', key: 'address' },
  { title: 'Phone', key: 'phone' },
  { title: 'Status', key: 'status' },
  { title: 'Actions', key: 'actions', align: 'end' }
]);

const newCustomer = ref({
  code: '',
  name: '',
  address: '',
  phone: '',
  status: 'Active'
});

function addCustomer() {
  customers.value.push({
    id: customers.value.length + 1,
    ...newCustomer.value
  });
  newCustomer.value = {
    code: '',
    name: '',
    address: '',
    phone: '',
    status: 'Active'
  };
}
</script>

<template>
  <Head title="Customer Management" />
  <v-app>
    <Navbar />
    <v-main>
      <v-container class="py-6">
        <v-card>
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-account-group" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">CUSTOMER MANAGEMENT</span>
          </v-card-title>
          
          <v-card-text class="pa-4">
            <!-- Add Customer Form -->
            <v-row class="mb-4">
              <v-col cols="12" md="3">
                <v-text-field v-model="newCustomer.code" label="Customer Code" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field v-model="newCustomer.name" label="Company Name" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field v-model="newCustomer.address" label="Address" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field v-model="newCustomer.phone" label="Phone" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-select v-model="newCustomer.status" label="Status" :items="['Active', 'Inactive']" variant="outlined" density="compact"></v-select>
              </v-col>
              <v-col cols="12" md="3" class="d-flex align-end">
                
              </v-col>
            </v-row>
            <v-btn color="#303F9F" variant="flat" @click="addCustomer" class="text-none">
                  <v-icon left>mdi-account-multiple-plus</v-icon> <v-spacer class="ms-2"></v-spacer>
                  Add Customer
                </v-btn>
            <!-- Customers Table -->
            <v-data-table
              :headers="headers"
              :items="customers"
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