<script setup>
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import { Head } from '@inertiajs/vue3';

const materials = ref([
  { id: 1, code: 'LMS', name: 'Limestone', unit: 'Kg', price: '1500', status: 'Active' },
  { id: 2, code: 'COAL', name: 'Coal', unit: 'Kg', price: '2500', status: 'Active' },
  { id: 3, code: 'SAND', name: 'Sand', unit: 'Kg', price: '1200', status: 'Inactive' },
]);

const headers = ref([
  { title: 'Material Code', key: 'code' },
  { title: 'Name', key: 'name' },
  { title: 'Unit', key: 'unit' },
  { title: 'Price', key: 'price' },
  { title: 'Status', key: 'status' },
  { title: 'Actions', key: 'actions', align: 'end' }
]);

const newMaterial = ref({
  code: '',
  name: '',
  unit: 'Kg',
  price: '',
  status: 'Active'
});

function addMaterial() {
  materials.value.push({
    id: materials.value.length + 1,
    ...newMaterial.value
  });
  newMaterial.value = {
    code: '',
    name: '',
    unit: 'Kg',
    price: '',
    status: 'Active'
  };
}
</script>

<template>
  <Head title="Material Management" />
  <v-app>
    <Navbar />
    <v-main>
      <v-container class="py-6">
        <v-card>
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-package-variant" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">METERIAL MANAGEMENT</span>
          </v-card-title>
          
          <v-card-text class="pa-4">
            <!-- Add Material Form -->
            <v-row class="mb-4">
              <v-col cols="12" md="3">
                <v-text-field v-model="newMaterial.code" label="Material Code" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="3">
                <v-text-field v-model="newMaterial.name" label="Material Name" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="2">
                <v-select v-model="newMaterial.unit" label="Unit" :items="['Kg', 'Ton', 'Lb']" variant="outlined" density="compact"></v-select>
              </v-col>
              <v-col cols="12" md="2">
                <v-text-field v-model="newMaterial.price" label="Price" variant="outlined" density="compact"></v-text-field>
              </v-col>
              <v-col cols="12" md="2">
                <v-select v-model="newMaterial.status" label="Status" :items="['Active', 'Inactive']" variant="outlined" density="compact"></v-select>
              </v-col>
              <v-col cols="12" md="2" class="d-flex align-end">
                
              </v-col>
            </v-row>
            <v-btn color="#303F9F" variant="flat" @click="addMaterial" class="text-none">
                  <v-icon left>mdi-plus</v-icon>
                  Add Material
                </v-btn>
            <!-- Materials Table -->
            <v-data-table
              :headers="headers"
              :items="materials"
              :items-per-page="10"
            >
              <template v-slot:item.status="{ item }">
                <v-chip :color="item.status === 'Active' ? 'green' : 'red'" size="small" class="text-white">
                  {{ item.status }}
                </v-chip>
              </template>
              <template v-slot:item.price="{ item }">
                Rp {{ item.price }}
              </template>
              <template v-slot:item.actions="{ item }">
                <v-btn icon variant="text" color="#303F9F">
                  <v-icon>mdi-pencil</v-icon>
                </v-btn>
                <v-btn icon variant="text" color="#303F9F">
                  <v-icon>mdi-delete</v-icon>
                </v-btn>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-container>
    </v-main>
  </v-app>
</template>