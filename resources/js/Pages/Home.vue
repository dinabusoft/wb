<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Navbar from '@/Components/Navbar.vue';
import { Head } from '@inertiajs/vue3';
import DataTable from './Profile/Partials/DataTable.vue';

const Status = ref('Check In')
const Ticket = ref('WBXXXXXXXXX')
const Date = ref('Monday, 25 November 2024')
const Time = ref('10:55:43')
const Weight = ref('45678.90')
const Driver = ref('Alex')
const PoliceNo = ref('B 1234 CC')
const Material = ref('Limestone')
const Customer = ref('PT AAA')
const Remark = ref('')

const materialItems = ref(['Limestone', 'Coal', 'Sand', 'Gravel'])
const customerItems = ref(['PT AAA', 'PT BBB', 'PT CCC', 'PT DDD'])

function handleLoadData(data) {
  Status.value = data.status || 'Check In'
  Ticket.value = data.ticket || 'WBXXXXXXXXX'
  Date.value = data.date || 'Monday, 25 November 2024'
  Time.value = data.time || '10:55:43'
  Weight.value = data.weight || '45678.90'
  Driver.value = data.driver || 'Alex'
  PoliceNo.value = data.policeno || 'B 1234 CC'
  Material.value = data.material || 'Limestone'
  Customer.value = data.customer || 'PT AAA'
  Remark.value = data.remark || ''
}

function addNewMaterial() {
  const newMaterial = prompt('Enter new material:')
  if (newMaterial) {
    materialItems.value.push(newMaterial)
    Material.value = newMaterial
  }
}

function addNewCustomer() {
  const newCustomer = prompt('Enter new customer:')
  if (newCustomer) {
    customerItems.value.push(newCustomer)
    Customer.value = newCustomer
  }
}

function saveData() {
  alert('Data saved!')
}

function printData() {
  window.print()
}
</script>

<template>
    <Head title="Home" />
    <v-app>
        <Navbar/>
    
        <div class="mt-4 block py-4 mx-auto sm:px-5">
            <v-row class="mb-6" no-gutters>
                <v-col cols="9">  
                    <v-sheet class="mb-4 mt-8 py-4 mx-auto sm:px-5"
                        :height="180"
                        :width="1320"
                        color="black"
                        rounded
                    >
                        <div class="d-flex justify-space-between align-center pa-4" style="margin-top: -10px;">
                            <div>
                                <div class="text-white">Status Device Connected</div>
                                <div class="text-white">Com 1 Port 3</div>
                                <div class="text-white">Baudrate 9600</div>
                                <div class="text-white">Data Bits 8</div>
                                <div class="text-white">Stop bits 1</div>
                            </div>
                            <div class="text-h4 text-white">{{ Weight }} kg</div>
                        </div>
                    </v-sheet>
                </v-col>
                
                <v-col cols="4">
                    <v-sheet class="pa-2 ma-2"
                        :elevation="4"
                        :height="600"
                        :width="450"
                        border
                        color="#303F9F2E"
                        rounded
                    >
                        <v-sheet class="ma-2" width="400" style="background-color: #C0C0C0; color: black;">
                            <v-form class="pa-2"> 
                                <v-row dense>
                                    <!-- Enabled Fields -->
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Status</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="Status"
                                            density="comfortable"
                                            hide-details
                                            disabled
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Ticket No</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="Ticket"
                                            density="comfortable"
                                            hide-details
                                            disabled
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Date</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="Date"
                                            density="comfortable"
                                            hide-details
                                            disabled
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Time</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="Time"
                                            density="comfortable"
                                            hide-details
                                            disabled
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Weight</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="Weight"
                                            density="comfortable"
                                            hide-details
                                            disabled
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <!-- Disabled Fields -->
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Driver</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="Driver"
                                            density="comfortable"
                                            hide-details
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Police No</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="PoliceNo"
                                            density="comfortable"
                                            hide-details
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Material</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-select
                                            v-model="Material"
                                            :items="materialItems"
                                            density="comfortable"
                                            hide-details
                                        >
                                            <template v-slot:append-item>
                                                <v-list-item 
                                                    @click="addNewMaterial"
                                                    class="bg-blue-lighten-4"
                                                >
                                                    <v-icon icon="mdi-plus" color="blue"></v-icon>
                                                    <span class="text-blue">Add New</span>
                                                </v-list-item>
                                            </template>
                                        </v-select>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Customer</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-select
                                            v-model="Customer"
                                            :items="customerItems"
                                            density="comfortable"
                                            hide-details
                                        >
                                            <template v-slot:append-item>
                                                <v-list-item 
                                                    @click="addNewCustomer"
                                                    class="bg-blue-lighten-4"
                                                >
                                                    <v-icon icon="mdi-plus" color="blue"></v-icon>
                                                    <span class="text-blue">Add New</span>
                                                </v-list-item>
                                            </template>
                                        </v-select>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Remark</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="Remark"
                                            density="comfortable"
                                            hide-details
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                
                                <v-row class="mt-4">
                                    <v-col cols="6">
                                        <v-btn
                                            color="#303F9F"
                                            block
                                            prepend-icon="mdi-printer"
                                            @click="printData"
                                            variant="flat"
                                        >
                                            Print
                                        </v-btn>
                                    </v-col>
                                    <v-col cols="6">
                                        <v-btn
                                            color="#303F9F"
                                            block
                                            prepend-icon="mdi-content-save"
                                            @click="saveData"
                                            variant="flat"
                                        >
                                            Save
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-form>
                        </v-sheet>
                    </v-sheet>
                </v-col>

                <v-col md="8">
                    <v-app>
                        <DataTable @load-data="handleLoadData"/>
                    </v-app>
                </v-col>
            </v-row>
        </div>
    </v-app>
</template>