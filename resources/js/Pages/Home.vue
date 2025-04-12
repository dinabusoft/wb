<style scoped>
.v-data-table__tr--active {
  background-color: rgba(25, 118, 210, 0.12) !important;
}
@media print {
  body * {
    visibility: hidden;
  }
  .v-data-table,
  .v-data-table * {
    visibility: visible;
  }
  .v-data-table {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
  }
  .v-btn {
    display: none !important;
  }

}
</style>
<script setup>
import { ref, computed, onMounted } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3'
import moment from 'moment';
import axios from 'axios';




const form = useForm({
   // status:null,
    date:moment().format('YYYY-MM-DD'),
    time:moment().format('HH:mm:ss') ,
    weight:'178',
    ref_no: null,
    police_no: null,
    driver_name: null,
    driver_phone: null,
    materials_id: null,
    customers_id: null,
    remark: null, 
})


const formattedDate = computed({
  get() {
    return form.date;
  },
  set(newValue) {
    form.date = newValue;
  }
});

const formattedTime = computed({
  get() {
    return form.time;
  },
  set(newValue) {
    // Ensure time format includes seconds
    form.time_in = newValue && newValue.split(':').length === 2 
      ? newValue + ':00'
      : newValue;
  }
});

const status = computed(() => {
  return form.id ? "Check Out" : "Check In";
});

const ticket = computed(() => {
  return form.id ? "WB" + form.id : "";
});


const handleRowClick = (event, { item }) => {
  // Isi form dengan data dari baris yang diklik
  form.ref_no = item.ref_no;
  form.driver_name = item.driver_name;
  form.driver_phone = item.driver_phone;
  form.police_no = item.police_no;
  form.remark = item.remark;
  form.materials_id = item.materials_id;
  form.customers_id = item.customers_id;
  
  // Jika ingin mengisi data check out juga
  if (item.weight_out) {
    form.weight = item.weight_out;
    form.date = item.date_out;
    form.time = item.time_out;
  } else {
    form.weight = item.weight_in;
    form.date = item.date_in;
    form.time = item.time_in;
  }
  
  // Untuk update status form
  form.id = item.id;
}

defineOptions({
  name: 'TransactionComponent'
});

const props = defineProps({
  message: {
    type: Object,
    required: false,
  },
   materials: Array,
    customers: Array
});

// Reactive state
const headers = ref([
  { title: 'Date In', key: 'date_in' },
  { title: 'Date Out', key: 'date_out' },
  { title: 'Time In', key: 'time_in' },
  { title: 'Time Out', key: 'time_out' },
  { title: 'Weight In', key: 'weight_in' },
  { title: 'Weight Out', key: 'weight_out' },
  { title: 'Ref No', key: 'ref_no' },
  { title: 'Police No', key: 'police_no' },
  { title: 'Driver Name', key: 'driver_name' }, // Diperbaiki key-nya
  { title: 'Driver Phone', key: 'driver_phone' },
  { title: 'Material Id', key: 'materials_id' }, // Diperbaiki key-nya
  { title: 'Customer Id', key: 'customers_id' }, // Diperbaiki key-nya
  { title: 'Remark', key: 'remark' },
  { title: 'Date Created', key: 'created_at' },
  { title: 'Created by', key: 'created_by_name' },
  { title: 'Last Updated', key: 'updated_at' },
  { title: 'Last Updated by', key: 'updated_by_name' },
  { title: 'Action', key: 'action', sortable: false },
]);

const notif = ref({ 
  show: props.message?.show || false, 
  message: props.message?.message || '', 
  color: props.message?.color || 'info' 
});

const items = ref([]);
const totalItems = ref(0);
const isLoadingTable = ref(false);
const options = ref({});
const search = ref(null);
const deleteDialog = ref(false);
const isLoading = ref(false);
const deleteId = ref(null);
const showEditIcons = ref(false);
const editingItemId = ref(null);
const materials = ref([]);
const customers = ref([]);

const loadItems = async () => {
  isLoadingTable.value = true;
  const { page, itemsPerPage, sortBy } = options.value;
  
  const params = {
    page,
    limit: itemsPerPage,
    sort: sortBy[0]?.key || null,
    order: sortBy[0]?.order || null,
    ...(search.value && { search: search.value })
  };

  try {
    const response = await axios.get('/transactions', { params });
    items.value = response.data.data;
    totalItems.value = response.data.meta.total;
  } catch (error) {
    notif.value = {
      message: 'Failed to load data',
      show: true,
      color: 'error'
    };
  } finally {
    isLoadingTable.value = false;
  }
};


const loadData = async (item) => {
  try {
    const response = await axios.get(`/transactions/${item.id}/out`);
    console.log(response.data);
    // Jika perlu mengisi form:
    // form.id = response.data.id;
    // form.ref_no = response.data.ref_no;
    // ...dst
  } catch (err) {
    console.error(err);
  }
};

onMounted(async() => {

    try {
        const response = await axios.get('/master_materials/options');
        materials.value = response.data.materials;
    } catch (error) {
        console.error('Error:', error.response?.data);
    }

    try {
        const response = await axios.get('/master_customers/options');
        customers.value = response.data.customers;
    } catch (error) {
        console.error('Error:', error.response?.data);
    }
});


function saveData() {
form.post('/transactions', {
        onSuccess: () => {
         //    alert('Data saved!');
             window.location.reload();
             console.log('Submitting:', form.data());
        },
    })
 
}

const handleSaveOut = async (item) => {
   try {
    const currentTime = moment().format('HH:mm:ss');
    const currentDate = moment().format('YYYY-MM-DD');
    
    console.log('Sending saveOut data:', {
      weight_out: form.weight,
      date_out: currentDate,
      time_out: currentTime,
      id: item.id
    });

    const response = await axios.put(`/transactions/${item.id}/out`, {
      weight_out: form.weight,
      date_out: currentDate,
      time_out: currentTime
    });

    if (response.data.success) {
      // Tampilkan notifikasi
      notif.value = {
        message: 'Data check out berhasil disimpan',
        show: true,
        color: 'success'
      };
      
      // Refresh halaman
      window.location.reload();
      
      // Opsional: Jika ingin reset form sebelum refresh
      form.reset();
    } else {
      throw new Error(response.data.message || 'Gagal menyimpan data');
    }

  } catch (error) {
    console.error('Error during saveOut:', error);
    notif.value = {
      message: error.response?.data?.message || 'Gagal menyimpan data',
      show: true,
      color: 'error'
    };
    alert('Error: ' + (error.response?.data?.message || error.message));
  }
};


function printData() {
   const printWindow = window.open('', '_blank');
  
  // Style untuk print
  const styles = `
    <style>
      body { font-family: Arial; margin: 20px; }
      h1 { text-align: center; margin-bottom: 20px; }
      table { width: 100%; border-collapse: collapse; }
      th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
      th { background-color: #f2f2f2; }
      .footer { text-align: center; margin-top: 20px; font-size: 12px; }
    </style>
  `;
  
  // Konten tabel
  let tableContent = `
    <table>
      <thead>
        <tr>
          ${headers.value.map(header => `<th>${header.title}</th>`).join('')}
        </tr>
      </thead>
      <tbody>
        ${items.value.map(item => `
          <tr>
            ${headers.value.map(header => `<td>${item[header.key] || ''}</td>`).join('')}
          </tr>
        `).join('')}
      </tbody>
    </table>
  `;
  
  // Gabungkan semua konten
  printWindow.document.write(`
    <html>
      <head>
        <title>Transaction Report</title>
        ${styles}
      </head>
      <body>
        <h1>Transaction Report</h1>
        ${tableContent}
        <div class="footer">
          Printed on: ${moment().format('YYYY-MM-DD HH:mm:ss')}
        </div>
      </body>
    </html>
  `);
  
  printWindow.document.close();
  printWindow.print();
}

const displayDate = computed(() => {
  return form.value.date 
    ? moment(form.value.date).format('YYYY-MM-DD')
    : '';
});

// Format tampilan waktu
const displayTime = computed(() => {
  return form.value.time
    ? moment(`2020-01-01 ${form.value.time_in}`).format('HH:mm:ss')
    : '';
});


  const style = document.createElement('style');

const loadExternalLibs = () => {
  return new Promise((resolve) => {
    if (window.XLSX && window.jspdf && window.html2canvas) {
      resolve();
      return;
    }

    const scriptsToLoad = [
      'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js',
      'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js',
      'https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js'
    ];

    let loaded = 0;
    scriptsToLoad.forEach(url => {
      const script = document.createElement('script');
      script.src = url;
      script.onload = () => {
        loaded++;
        if (loaded === scriptsToLoad.length) resolve();
      };
      document.head.appendChild(script);
    });
  });
};

const exportToExcel = async () => {
  await loadExternalLibs();
  
  // Membuat worksheet dari data tabel
  const wsData = [
    headers.value.map(h => h.title), // Header
    ...items.value.map(item => 
      headers.value.map(header => {
        const value = item[header.key];
        // Handle nested objects atau array
        return typeof value === 'object' ? JSON.stringify(value) : value;
      })
    )
  ];

  const ws = XLSX.utils.aoa_to_sheet(wsData);
  
  // Styling untuk header
  ws['!cols'] = headers.value.map(() => ({ width: 20 }));
  
  // Membuat workbook
  const wb = XLSX.utils.book_new();
  XLSX.utils.book_append_sheet(wb, ws, "Transactions");
  
  // Export ke file XLSX
  XLSX.writeFile(wb, `transactions-${moment().format('YYYYMMDD-HHmmss')}.xlsx`);
};
const exportToPDF = async () => {
  await loadExternalLibs(); // Pastikan library sudah terload
  
  const pdfContent = document.createElement('div');
  pdfContent.style.padding = '20px';
  pdfContent.style.fontFamily = 'Arial';
  
  // Membuat tabel HTML untuk PDF
  const table = document.createElement('table');
  table.style.borderCollapse = 'collapse';
  table.style.width = '100%';
  
  // Header
  const thead = document.createElement('thead');
  const headerRow = document.createElement('tr');
  headers.value.forEach(header => {
    const th = document.createElement('th');
    th.textContent = header.title;
    th.style.border = '1px solid #000';
    th.style.padding = '8px';
    th.style.backgroundColor = '#f0f0f0';
    headerRow.appendChild(th);
  });
  thead.appendChild(headerRow);
  table.appendChild(thead);

  // Body
  const tbody = document.createElement('tbody');
  items.value.forEach(item => {
    const row = document.createElement('tr');
    headers.value.forEach(header => {
      const td = document.createElement('td');
      const value = item[header.key];
      td.textContent = typeof value === 'object' ? JSON.stringify(value) : value;
      td.style.border = '1px solid #000';
      td.style.padding = '6px';
      row.appendChild(td);
    });
    tbody.appendChild(row);
  });
  table.appendChild(tbody);

  pdfContent.innerHTML = `
    <h2 style="color: #303F9F; text-align: center;">Laporan Transaksi</h2>
    <p style="text-align: right;">Tanggal Export: ${moment().format('DD/MM/YYYY HH:mm')}</p> `;
  pdfContent.appendChild(table);

  document.body.appendChild(pdfContent);
  
  try {
    const canvas = await html2canvas(pdfContent);
    const imgData = canvas.toDataURL('image/png');
    
    const pdf = new window.jspdf.jsPDF('landscape');
    const imgProps = pdf.getImageProperties(imgData);
    const pdfWidth = pdf.internal.pageSize.getWidth();
    const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;
    
    pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth - 20, pdfHeight - 20);
    pdf.save(`transactions-${moment().format('YYYYMMDD-HHmmss')}.pdf`);
  } catch (error) {
    console.error('Error generating PDF:', error);
  } finally {
    document.body.removeChild(pdfContent);
  }
};

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
                            <div class="text-h4 text-white">{{ form.weight }} kg</div>
                        </div>
                    </v-sheet>
                </v-col>
                
                <v-col cols="4" >
                    <v-sheet class="pa-2 ma-2"
                        :elevation="4"
                        :height="635"
                        :width="435"
                        border
                        color="#303F9F2E"
                        rounded
                    >
                        <v-sheet class="ma-2" width="400" style="background-color: #C0C0C0; color: black;">
                            <v-form class="pa-2"> 
                                <v-row dense>
                                <input type="hidden" name="_token" :value="$page.props.csrf_token">
                                    <!-- Enabled Fields -->
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Status</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="status"
                                            density="compact"
                                            hide-details
                                            disabled
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Ref No</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="form.ref_no"
                                            density="compact"
                                            hide-details
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Date</span>
                                    </v-col>
                                    <v-col cols="8">
                                       <v-text-field
                                            v-model="formattedDate"
                                            type="date"
                                            density="compact"
                                            hide-details
                                            @update:modelValue="val => formattedDate = val"
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Time</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="formattedTime"
                                            type="time"
                                            step="1"
                                            density="compact"
                                            hide-details
                                            @update:modelValue="val => formattedTime = val"
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Weight</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="form.weight"
                                            density="compact"
                                            hide-details
                                            disabled
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <!-- Disabled Fields -->
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Driver Name</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="form.driver_name"
                                            density="compact"
                                            hide-details
                                        ></v-text-field>
                                    </v-col>

                                     <!-- Disabled Fields -->
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Driver Phone</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="form.driver_phone"
                                            density="compact"
                                            hide-details
                                        ></v-text-field>
                                    </v-col>
                                    
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Police No</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="form.police_no"
                                            density="compact"
                                            hide-details
                                        ></v-text-field>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Material</span>
                                    </v-col>
                                    <v-col cols="8">
                                         <v-select
                                            v-model="form.materials_id"
                                            :items="materials"
                                            item-title="name"
                                            item-value="id"
                                            density="compact"
                                            variant="outlined"
                                            hide-details
                                            single-line
                                            bg-color="white"
                                            :menu-props="{ contentClass: 'select-menu' }"
                                            label="Pilih Material"
                                        ></v-select>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Customer</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-select
                                            v-model="form.customers_id"
                                            :items="customers"
                                            item-title="name"
                                            item-value="id"
                                            density="compact"
                                            variant="outlined"
                                            hide-details
                                            single-line
                                            bg-color="white"
                                            :menu-props="{ contentClass: 'select-menu' }"
                                            label="Pilih Customer"
                                        ></v-select>
                                    </v-col>
                                    
                                    <v-col cols="4" class="d-flex align-center">
                                        <span class="font-bold text-gray-900">Remark</span>
                                    </v-col>
                                    <v-col cols="8">
                                        <v-text-field
                                            v-model="form.remark"
                                            density="compact"
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

                <v-col md="5"> 
                <v-card-actions>
                    <v-spacer />
                    <!-- Tambahkan tombol export -->
                    <v-btn color="success" variant="flat" class="mr-2" @click="exportToExcel">
                      <v-icon left>mdi-microsoft-excel</v-icon>
                      Export Excel
                    </v-btn>
                    
                    <v-btn color="error" variant="flat" class="mr-2" @click="exportToPDF">
                      <v-icon left>mdi-file-pdf-box</v-icon>
                      Export PDF
                    </v-btn>

                    <!-- Tombol batal dan simpan tetap sama -->
                  </v-card-actions>
                    <v-app>
                        <!-- <DataTable @load-data="handleLoadData"/> -->
                        <v-data-table-server v-model:options="options" :active="form.id ? [form.id] : []" :items="items" :items-length="totalItems" :headers="headers"
        :search="search" class="elevation-0" :loading="isLoadingTable" @update:options="loadItems"@click:row="handleRowClick" >
       <template #[`item.action`]="{ item }">
          <v-row dense>
            <v-col>
              <!-- Icon pensil atas (untuk edit) - hanya tampil jika date_out ADA -->
              <v-btn 
                v-if="item.date_out"
                :href="`/transactions/${item.id}/edit`"
                variant="text" 
                color="warning"
              >
                <v-icon icon="mdi-pencil" size="small"/>
              </v-btn>

              <!-- Icon pensil bawah (untuk check out) - hanya tampil jika date_out KOSONG -->
              <template v-if="!item.date_out">
                <v-btn 
                  v-if="!showEditIcons || editingItemId !== item.id"
                  @click="loadData(item); showEditIcons = true; editingItemId = item.id"
                  variant="text" 
                  color="warning"
                >
                  <v-icon icon="mdi-pencil" size="small"/>
                </v-btn>
                
                <v-btn 
                  v-if="showEditIcons && editingItemId === item.id"
                  @click="handleSaveOut(item); showEditIcons = false; editingItemId = null"
                  variant="text" 
                  color="error"
                >
                  <v-icon icon="mdi-content-save" size="small"/>
                </v-btn>
              </template>
            </v-col>
          </v-row>
        </template>
      </v-data-table-server>
                    </v-app>
                </v-col>
            </v-row>
        </div>
    </v-app>
</template>
