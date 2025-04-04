<script setup>
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import { Head } from '@inertiajs/vue3';

// Sample data - Expanded with more entries
const items = ref([
  {
    ticket: 'WB000000051',
    dateIn: '25-11-2024',
    timeIn: '16:00:24',
    dateOut: '25-11-2024',
    timeOut: '16:00:24',
    weightIn: '24000.00',
    weightOut: '24000.00',
    policeNo: 'B 1111 CD',
    material: 'Limestone',
    customer: 'PT AAA',
    driver: 'Iyus',
    status: 'Check out'
  },
  {
    ticket: 'WB000000052',
    dateIn: '25-11-2024',
    timeIn: '16:05:18',
    dateOut: '25-11-2024',
    timeOut: '16:30:45',
    weightIn: '18500.50',
    weightOut: '18200.00',
    policeNo: 'D 2345 EF',
    material: 'Coal',
    customer: 'PT BBB',
    driver: 'Budi',
    status: 'Check out'
  },
  {
    ticket: 'WB000000053',
    dateIn: '25-11-2024',
    timeIn: '16:15:32',
    dateOut: '25-11-2024',
    timeOut: '16:45:12',
    weightIn: '32000.00',
    weightOut: '31500.50',
    policeNo: 'F 3456 GH',
    material: 'Sand',
    customer: 'PT CCC',
    driver: 'Dodi',
    status: 'Check out'
  },
  {
    ticket: 'WB000000054',
    dateIn: '25-11-2024',
    timeIn: '16:30:00',
    dateOut: '',
    timeOut: '',
    weightIn: '27500.75',
    weightOut: '',
    policeNo: 'G 4567 HI',
    material: 'Limestone',
    customer: 'PT AAA',
    driver: 'Eka',
    status: 'Check in'
  },
  {
    ticket: 'WB000000055',
    dateIn: '25-11-2024',
    timeIn: '16:45:22',
    dateOut: '25-11-2024',
    timeOut: '17:15:33',
    weightIn: '19800.25',
    weightOut: '19500.00',
    policeNo: 'H 5678 IJ',
    material: 'Coal',
    customer: 'PT DDD',
    driver: 'Fajar',
    status: 'Check out'
  },
  {
    ticket: 'WB000000056',
    dateIn: '25-11-2024',
    timeIn: '17:00:45',
    dateOut: '',
    timeOut: '',
    weightIn: '28500.50',
    weightOut: '',
    policeNo: 'J 6789 JK',
    material: 'Sand',
    customer: 'PT EEE',
    driver: 'Gunawan',
    status: 'Check in'
  },
  {
    ticket: 'WB000000057',
    dateIn: '25-11-2024',
    timeIn: '17:15:10',
    dateOut: '25-11-2024',
    timeOut: '17:45:25',
    weightIn: '22500.00',
    weightOut: '22000.50',
    policeNo: 'K 7890 KL',
    material: 'Limestone',
    customer: 'PT AAA',
    driver: 'Hendra',
    status: 'Check out'
  },
  {
    ticket: 'WB000000058',
    dateIn: '25-11-2024',
    timeIn: '17:30:33',
    dateOut: '',
    timeOut: '',
    weightIn: '31000.75',
    weightOut: '',
    policeNo: 'L 8901 LM',
    material: 'Coal',
    customer: 'PT FFF',
    driver: 'Irfan',
    status: 'Check in'
  },
  {
    ticket: 'WB000000059',
    dateIn: '25-11-2024',
    timeIn: '17:45:55',
    dateOut: '25-11-2024',
    timeOut: '18:15:10',
    weightIn: '26500.25',
    weightOut: '26000.00',
    policeNo: 'M 9012 MN',
    material: 'Sand',
    customer: 'PT GGG',
    driver: 'Joko',
    status: 'Check out'
  },
  {
    ticket: 'WB000000060',
    dateIn: '25-11-2024',
    timeIn: '18:00:20',
    dateOut: '25-11-2024',
    timeOut: '18:30:35',
    weightIn: '29500.50',
    weightOut: '29000.25',
    policeNo: 'N 0123 NO',
    material: 'Limestone',
    customer: 'PT AAA',
    driver: 'Kurnia',
    status: 'Check out'
  }
]);

const headers = ref([
  { title: 'Ticket No', key: 'ticket', align: 'start' },
  { title: 'Date In', key: 'dateIn' },
  { title: 'Time In', key: 'timeIn' },
  { title: 'Date Out', key: 'dateOut' },
  { title: 'Time Out', key: 'timeOut' },
  { title: 'Weight(kg) In', key: 'weightIn', align: 'end' },
  { title: 'Weight(kg) Out', key: 'weightOut', align: 'end' },
  { title: 'Police No', key: 'policeNo' },
  { title: 'Material', key: 'material' },
  { title: 'Customer', key: 'customer' },
  { title: 'Driver', key: 'driver' },
  { title: 'Status', key: 'status' }
]);

// Filter variables
const filters = ref({
  dateBegin: '',
  dateEnd: '',
  customer: '',
  material: '',
  policeNo: '',
  status: ''
});
const search = ref('');

// Pagination
const itemsPerPage = ref(10);
const page = ref(1);

function resetFilters() {
  filters.value = {
    dateBegin: '',
    dateEnd: '',
    customer: '',
    material: '',
    policeNo: '',
    status: ''
  };
}

function applyFilters() {
  // Filter implementation
  console.log('Filters applied:', filters.value);
}
</script>

<template>
  <Head title="Report" />
  <v-app>
    <Navbar />
    <v-main>
      <v-container class="py-4">
        <!-- Filter Section - Enhanced Design -->
        <v-card class="mb-6" flat>
          <v-card-title class="d-flex align-center bg-grey-lighten-4 py-3 px-4">
            <v-icon icon="mdi-filter" color="#303F9F" class="mr-2"></v-icon>
            <span class="text-h6 font-weight-medium" style="color: #303F9F;">Filter Data</span>
          </v-card-title>
          
          <v-card-text class="pa-4">
            <!-- Date Range Row -->
          <v-row no-gutters>
          <v-col>
          <v-sheet class="pa-2 ma-2">
            <v-text-field
                  v-model="filters.dateBegin"
                  label="Date Begin"
                  type="date"
                  density="comfortable"
                  variant="outlined"
                  clearable
                  :max="filters.dateEnd"
                ></v-text-field>
          </v-sheet>
          </v-col>
          <v-col>
          <v-sheet class="pa-2 ma-2">
            <v-autocomplete
                  v-model="filters.customer"
                  label="Customer"
                  :items="['PT AAA', 'PT BBB', 'PT CCC', 'PT DDD', 'PT EEE', 'PT FFF', 'PT GGG']"
                  density="comfortable"
                  variant="outlined"
                  clearable
                ></v-autocomplete>
          </v-sheet>
          </v-col>
          <v-col>
          <v-sheet class="pa-2 ma-2">
            <v-select
                  v-model="filters.status"
                  label="Status"
                  :items="['All Status', 'Check In', 'Check Out']"
                  density="comfortable"
                  variant="outlined"
                  clearable
                ></v-select>
          </v-sheet>
          </v-col>
          <v-col>
          <v-sheet class="pa-2 ma-2">
              <v-btn
                  color="#303F9F"
                  variant="flat"
                  class="text-none px-6"
                  @click="applyFilters"
                >
                  <v-icon left>mdi-filter-check</v-icon>
                  Filter
              </v-btn>
          </v-sheet>
        </v-col>
  
        <v-responsive width="100%"></v-responsive>
  
        <v-col>
          <v-sheet class="pa-2 ma-2">
            <v-text-field
                  v-model="filters.dateEnd"
                  label="Date End"
                  type="date"
                  density="comfortable"
                  variant="outlined"
                  clearable
                  :min="filters.dateBegin"
                ></v-text-field>
          </v-sheet>
        </v-col>
        <v-col>
          <v-sheet class="pa-2 ma-2">
            <v-autocomplete
                  v-model="filters.material"
                  label="Material"
                  :items="['Limestone', 'Coal', 'Sand']"
                  density="comfortable"
                  variant="outlined"
                  clearable
                ></v-autocomplete>
          </v-sheet>
        </v-col>
        <v-col>
          <v-sheet class="pa-2 ma-2">
            <v-text-field
                  v-model="filters.policeNo"
                  label="Police No"
                  density="comfortable"
                  variant="outlined"
                  clearable
                ></v-text-field>
          </v-sheet>
        </v-col>
        <v-col>
        <v-sheet class="pa-2 ma-2">
          <v-btn
                  color="#303F9F"
                  variant="flat"
                  class="text-none px-6"
                  @click="resetFilters"
                >
                  <v-icon left>mdi-refresh</v-icon>
                  Reset
                </v-btn>
        </v-sheet>
      </v-col>
      </v-row>

            <!-- Action Buttons -->
            <!-- <v-row class="mt-2">
              <v-col cols="12" class="d-flex justify-end">
                <v-btn
                  variant="text"
                  color="grey-darken-2"
                  class="mr-3 text-none"
                  @click="resetFilters"
                >
                  <v-icon left>mdi-refresh</v-icon>
                  Reset
                </v-btn>
                <v-btn
                  color="#303F9F"
                  variant="flat"
                  class="text-none px-6"
                  @click="applyFilters"
                >
                  <v-icon left>mdi-filter-check</v-icon>
                  Apply
                </v-btn>
              </v-col>
            </v-row> -->
          </v-card-text>
        </v-card>

        <!-- Action Bar -->
        <v-card class="mb-4" flat>
          <v-card-text class="pa-4">
            <v-btn
              style="background-color: #303F9F;"
              color="white"
              variant="outlined"
              prepend-icon="mdi-file-export"
              class="text-none"
              width="200px"
            >
              Export
            </v-btn>

            <v-text-field class="mt-4"
              v-model="search"
              label="Search"
              append-inner-icon="mdi-magnify"
              density="comfortable"
              style="max-width: 1200px;"
              single-line
              hide-details
            ></v-text-field>
          
          </v-card-text>
        </v-card>

        <!-- Data Table -->
        <v-card>
          <v-data-table
            :headers="headers"
            :items="items"
            :search="search"
            :items-per-page="itemsPerPage"
            :page="page"
          >
            <template v-slot:item.status="{ item }">
              <v-chip
                :color="item.status === 'Check out' ? 'green' : 'blue'"
                size="small"
                class="text-white"
              >
                {{ item.status }}
              </v-chip>
            </template>
            <template v-slot:item.weightIn="{ item }">
              <span class="font-weight-medium">{{ item.weightIn }}</span>
            </template>
            <template v-slot:item.weightOut="{ item }">
              <span class="font-weight-medium">{{ item.weightOut || '-' }}</span>
            </template>
          </v-data-table>
        </v-card>
      </v-container>
    </v-main>
  </v-app>
</template>

<style scoped>
.v-card-title {
  border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}

.v-btn {
  letter-spacing: 0.5px;
  font-weight: 500;
}

.v-text-field, .v-select, .v-autocomplete {
  background-color: #fff;
  border-radius: 6px;
}

.v-data-table-header {
  background-color: #303F9F;
}

.v-data-table-header th {
  color: white !important;
  font-weight: 600;
}

.v-chip {
  font-weight: 500;
}
</style>