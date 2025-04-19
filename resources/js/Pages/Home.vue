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
import { ref, computed, onMounted, watch } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head, Link, useForm, router, usePage } from '@inertiajs/vue3'
import moment from 'moment';
import axios from 'axios';


const selectedItem = ref(null);

const form = useForm({
  // status:null,
  id: null,
  date: moment().format('YYYY-MM-DD'),
  time: moment().format('HH:mm:ss'),
  weight: '178',
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

const buttonLabel = computed(() => {
  return form.id ? "Save Check Out" : "Save Check In";
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
  selectedItem.value = item;
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
  { title: 'Action', key: 'action', sortable: false },
  { title: 'Ticket No', key: 'ticket_id', align: 'start' },
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
  //{ title: 'Material Id', key: 'materials_id' }, // Diperbaiki key-nya
  //{ title: 'Customer Id', key: 'customers_id' }, // Diperbaiki key-nya
  { title: 'Material', key: 'materials_name' },
  { title: 'Customer', key: 'customers_name' },
  { title: 'Remark', key: 'remark' },
  { title: 'Date Created', key: 'created_at' },
  { title: 'Created by', key: 'created_by_name' },
  //{ title: 'Last Updated', key: 'updated_at' },
  //{ title: 'Last Updated by', key: 'updated_by_name' },
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
/*const materials = ref([]);
const customers = ref([]);*/
const items_material = ref([]);
const search_material = ref(null);
const last_search_material = ref(null);
const loading_material = ref(false);
const items_customer = ref([]);
const search_customer = ref(null);
const last_search_customer = ref(null);
const loading_customer = ref(false);

const loadItems = async () => {
  isLoadingTable.value = true;
  const { page, itemsPerPage, sortBy } = options.value;

  const params = {
    page,
    limit: itemsPerPage,
    sort: sortBy[0]?.key || null,
    order: sortBy[0]?.order || null,
    filter: { isMenuHome: true },
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

    // Jika perlu mengisi form:
    // form.id = response.data.id;
    // form.ref_no = response.data.ref_no;
    // ...dst
  } catch (err) {
    console.error(err);
  }
};

const formatDate = (value) => {
  return moment(value, 'YYYY-MM-DD').isValid() ? moment(value, 'YYYY-MM-DD').format('DD/MM/YYYY') : "-";
};

const formatTime = (value) => {
  return moment(value, 'hh:mm:ss').isValid() ? moment(value, 'hh:mm:ss').format('hh:mm:ss') : "-";
};

onMounted(async () => {
  /*
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
  }*/

  queryMaterialSelections()//new
  queryCustomerSelections()//new
});

watch(search_material, (val) => {//new
  val && val !== last_search_material && queryMaterialSelections(val)
});

watch(search_customer, (val) => {//new
  val && val !== last_search_customer && queryCustomerSelections(val)
});

const queryMaterialSelections = (search) => {
  loading_material.value = true
  var params = {
    page: 1,
    limit: 10,
    sort: { key: 'code', order: 'asc' },
  }
  if (search) {
    params.search = search
  }
  axios.get('/mastermaterials', { params }).then((response) => {
    items_material.value = [];
    response.data.data.forEach((item) => {
      items_material.value.push({ value: item.id, text: item.name });
    })
    last_search_material.value = search;
  })
  loading_material.value = false
};

const queryCustomerSelections = (search) => {
  loading_customer.value = true
  var params = {
    page: 1,
    limit: 10,
    sort: { key: 'id', order: 'asc' },
  }
  if (search) {
    params.search = search
  }
  axios.get('/mastercustomers', { params }).then((response) => {
    items_customer.value = [];
    response.data.data.forEach((item) => {
      items_customer.value.push({ value: item.id, text: item.name });
    })
    last_search_customer.value = search;
  })
  loading_customer.value = false
};


function saveData() {
  if (form.id) handleSaveOut(form);
  else
    form.post('/transactions/in', {
      onSuccess: () => {
        //    alert('Data saved!');
        window.location.reload();
      },
    })

}

const handleSaveOut = async (item) => {
  try {
    const currentTime = moment().format('HH:mm:ss');
    const currentDate = moment().format('YYYY-MM-DD');

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
const filters = ref({
  date_in_begin: '',
  date_in_end: '',
  customers_id: '',
  materials_id: '',
  police_no: '',
  status: ''
});
const exportToExcel = async () => {
  await loadExternalLibs();

  try {
    // Ambil semua data dengan filter saat ini
    const params = {
      filter: {
      isMenuHome: true,
        ...filters.value,
        status: filters.value.status === 'All Status' ? null : filters.value.status
      },
      search: search.value, // Tambahkan parameter pencarian
      sort: options.value.sortBy[0]?.key || null, // Tambahkan sort
      order: options.value.sortBy[0]?.order || null,
      limit: 'all'
    };

    const response = await axios.get('/transactions', { params });
    const allData = response.data.data;

    // Format data untuk Excel
    const wsData = [
      headers.value.map(h => h.title),
      ...allData.map(item =>
        headers.value.map(header => {
          const value = item[header.key];
          // Format tanggal dan waktu
          if (['date_in', 'date_out'].includes(header.key)) {
            return formatDate(value);
          } else if (['time_in', 'time_out'].includes(header.key)) {
            return formatTime(value);
          }
          return typeof value === 'object' ? JSON.stringify(value) : value;
        })
      )
    ];

    // Buat file Excel
    const ws = XLSX.utils.aoa_to_sheet(wsData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Transactions");
    XLSX.writeFile(wb, `transactions-${moment().format('YYYYMMDD-HHmmss')}.xlsx`);

  } catch (error) {
    console.error('Export error:', error);
    // Tambahkan notifikasi error jika perlu
  }
};
const exportToPDF = async () => {
   await loadExternalLibs();

  try {
    const params = {
      filter: {
        isMenuHome: true,
        ...filters.value,
        status: filters.value.status === 'All Status' ? null : filters.value.status
      },
      search: search.value,
      sort: options.value.sortBy[0]?.key || null,
      order: options.value.sortBy[0]?.order || null,
      limit: 'all'
    };

    const response = await axios.get('/transactions', { params });
    const allData = response.data.data;

    // Buka window baru
    const printWindow = window.open('', '_blank');
    
    // Buat konten PDF di window baru
    printWindow.document.write(`
      <html>
        <head>
          <title>Laporan Transaksi</title>
          <style>
            body { font-family: Arial; margin: 20px; }
            h2 { color: #303F9F; text-align: center; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #000; padding: 8px; text-align: left; }
            th { background-color: #f0f0f0; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; }
          </style>
        </head>
        <body>
          <h2>Laporan Transaksi</h2>
          <p style="text-align: right;">Tanggal Export: ${moment().format('DD/MM/YYYY HH:mm')}</p>
          <table>
            <thead>
              <tr>
                ${headers.value.map(header => `<th>${header.title}</th>`).join('')}
              </tr>
            </thead>
            <tbody>
              ${allData.map(item => `
                <tr>
                  ${headers.value.map(header => {
                    const value = item[header.key];
                    let displayValue = value;
                    if (['date_in', 'date_out'].includes(header.key)) {
                      displayValue = formatDate(value);
                    } else if (['time_in', 'time_out'].includes(header.key)) {
                      displayValue = formatTime(value);
                    }
                    return `<td>${displayValue || '-'}</td>`;
                  }).join('')}
                </tr>
              `).join('')}
            </tbody>
          </table>
        </body>
      </html>
    `);

    printWindow.document.close();
    
    // Tunggu konten selesai loading
    setTimeout(async () => {
      // Ambil element body dari window baru
      const pdfContent = printWindow.document.body;
      
      // Generate PDF
      const canvas = await html2canvas(pdfContent);
      const imgData = canvas.toDataURL('image/png');
      
      const pdf = new window.jspdf.jsPDF('landscape');
      const imgProps = pdf.getImageProperties(imgData);
      const pdfWidth = pdf.internal.pageSize.getWidth();
      const pdfHeight = (imgProps.height * pdfWidth) / imgProps.width;

      pdf.addImage(imgData, 'PNG', 10, 10, pdfWidth - 20, pdfHeight - 20);
      pdf.save(`transactions-${moment().format('YYYYMMDD-HHmmss')}.pdf`);
      // Tutup window preview
      printWindow.close();
      
      // Buka PDF di tab baru
      const pdfBlob = pdf.output('blob');
      const pdfUrl = URL.createObjectURL(pdfBlob);
      window.open(pdfUrl, '_blank');
      
    }, 500);

  } catch (error) {
    console.error('PDF Error:', error);
  }
};

const printBuktiTimbangan = () => {
  if (!selectedItem.value) return;
  const item = selectedItem.value;

  const printWindow = window.open('', '_blank');
  const netWeight = item.weight_in - (item.weight_out || 0);

  const styles = `
    <style>
      body { font-family: Arial; margin: 15px; font-size: 14px; }
      .header { text-align: center; margin-bottom: 20px; }
      .info-section { margin: 15px 0; }
      .info-line { margin: 8px 0; }
      table { width: 100%; border-collapse: collapse; margin: 15px 0; }
      td, th { border: 1px solid #000; padding: 8px; }
      .text-right { text-align: right; }
      .signature-container { 
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
      }
    </style>
  `;

  const content = `
    <h3 class="header">BUKTI TIMBANGAN</h3>

    <div class="info-section">
      <div class="info-line">
        <strong>PENERIMA:</strong> ${item.customers_name || '-'}
      </div>
      <div class="info-line">
        <strong>No. REF:</strong> ${item.ref_no || '-'} | 
        <strong>TANGGAL:</strong> ${formatDate(item.date_in)} | 
        <strong>JAM:</strong> ${formatTime(item.time_in)}
      </div>
      <div class="info-line">
        <strong>NOPOL:</strong> ${item.police_no || '-'}
      </div>
    </div>

    <table>
      <thead>
        <tr>
          <th>MATERIAL</th>
          <th class="text-right">BERAT MASUK</th>
          <th class="text-right">BERAT KELUAR </th>
          <th class="text-right">NET</th>
          <th>REMARK</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>${item.materials_name || '-'}</td>
          <td class="text-right">${Number(item.weight_in).toLocaleString()}</td>
          <td class="text-right">${Number(item.weight_out).toLocaleString()}</td>
          <td class="text-right">${netWeight.toLocaleString()}</td>
          <td>${item.remark || '-'}</td>
        </tr>
      </tbody>
    </table>

    <div class="signature-container">
      <div>
        Driver<br><br><br><br>
        ( ${item.driver_name || '-'} )
      </div>
      <div>
        Kepala Security<br><br><br><br>
        ( Komandan Security )
      </div>
    </div>
  `;

  printWindow.document.write(`
    <html>
      <head>
        <title>Bukti Timbangan - ${item.ref_no}</title>
        ${styles}
      </head>
      <body>
        ${content}
      </body>
    </html>
  `);

  printWindow.document.close();
  printWindow.print();
};

// Membuat tombol connect serial
const messages = ref([])

async function connectSerial() {
  if ('serial' in navigator) {
    try {
      const port = await navigator.serial.requestPort()
      await port.open({ baudRate: 9600 })

      const decoder = new TextDecoderStream()
      const readableStreamClosed = port.readable.pipeTo(decoder.writable)
      const reader = decoder.readable.getReader()

      while (true) {
        const { value, done } = await reader.read()
        if (done) break
        if (value) messages.value.push(value.trim())
      }
    } catch (e) {
      console.error('Error:', e)
    }
  } else {
    alert('Web Serial API tidak didukung di browser ini.')
  }
}

</script>

<template>

  <Head title="Home" />
  <v-app>
    <Navbar />
    <v-main>
      <v-container class="pa-2" fluid>
        <v-row justify="center">
          <v-col>
            <v-sheet class="mt-4 py-4 mx-auto sm:px-5" color="black" rounded>
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
        </v-row>


        <v-btn class="pa-2 ma-2 mb-0" color="#303F9F" @click="connectSerial">
          <v-icon left>mdi-connection</v-icon>
          Connect Serial</v-btn>
        <v-card-text>
          <div v-for="(line, index) in messages" :key="index">{{ line }}</div>
        </v-card-text>

        <v-row justify="center">
          <v-col cols="3">
            <v-sheet class="pa-2 ma-2" :elevation="4" border color="#303F9F2E" rounded>

              <v-form class="pa-2">
                <v-row dense>
                  <v-col cols="8">
                  </v-col>
                  <v-col cols="4">
                    <v-btn color="indigo" block variant="flat" @click="form.reset()">
                      <v-icon left>mdi-eraser-variant</v-icon>
                      <p class="text-wrap ma-auto">Clear</p>
                    </v-btn>
                  </v-col>
                </v-row>
                <v-row dense>
                  <!--<input type="hidden" name="_token" :value="$page.props.csrf_token">-->
                  <!-- Enabled Fields -->
                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Status</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="status" density="compact" hide-details disabled></v-text-field>
                  </v-col>

                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Ref No</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="form.ref_no" density="compact" hide-details></v-text-field>
                  </v-col>

                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Date</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="formattedDate" type="date" density="compact" hide-details
                      @update:modelValue="val => formattedDate = val"></v-text-field>
                  </v-col>

                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Time</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="formattedTime" type="time" step="1" density="compact" hide-details
                      @update:modelValue="val => formattedTime = val"></v-text-field>
                  </v-col>

                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Weight</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="form.weight" density="compact" hide-details disabled></v-text-field>
                  </v-col>

                  <!-- Disabled Fields -->
                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Driver Name</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="form.driver_name" density="compact" hide-details></v-text-field>
                  </v-col>

                  <!-- Disabled Fields -->
                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Driver Phone</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="form.driver_phone" density="compact" hide-details></v-text-field>
                  </v-col>


                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Police No</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="form.police_no" density="compact" hide-details></v-text-field>
                  </v-col>

                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Material</span>
                  </v-col>
                  <v-col cols="8">
                    <!--<v-select
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
                                        ></v-select>-->

                    <v-autocomplete v-model="form.materials_id" label="Material" :items="items_material"
                      v-model:search="search_material" :loading="loading_material" item-title="text" item-value="value"
                      density="compact" variant="outlined" hide-details single-line clearable
                      :error-messages="form.errors.materials_id" />
                  </v-col>

                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Customer</span>
                  </v-col>
                  <v-col cols="8">
                    <!--<v-select
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
                                        ></v-select>-->
                    <v-autocomplete v-model="form.customers_id" label="Customer" :items="items_customer"
                      v-model:search="search_customer" :loading="loading_customer" item-title="text" item-value="value"
                      density="compact" variant="outlined" hide-details single-line clearable
                      :error-messages="form.errors.customers_id" />
                  </v-col>

                  <v-col cols="4" class="d-flex align-center">
                    <span class="font-bold text-gray-900">Remark</span>
                  </v-col>
                  <v-col cols="8">
                    <v-text-field v-model="form.remark" density="compact" hide-details></v-text-field>
                  </v-col>
                </v-row>

                <v-row class="mt-4">
                  <v-col cols="6">
                    <v-btn color="indigo" block variant="flat" @click="printBuktiTimbangan"
                      :disabled="!selectedItem?.date_out">
                      <v-icon left>mdi-file-export</v-icon>
                      <p class="text-wrap ma-auto">Print Bukti Timbang</p>
                    </v-btn>
                  </v-col>
                  <v-col cols="6">
                    <v-btn color="#303F9F" block prepend-icon="mdi-content-save" @click="saveData" variant="flat">
                      <p class="text-wrap ma-auto">{{ buttonLabel }}</p>
                    </v-btn>
                  </v-col>
                </v-row>
              </v-form>

            </v-sheet>
          </v-col>

          <v-col cols="9">
            <v-card-actions>
              <v-spacer />
              <!-- Tambahkan tombol export -->
              <v-btn color="success" variant="flat" class="mr-2" @click="exportToExcel">
                <v-icon left>mdi-microsoft-excel</v-icon>
                Export Excel
              </v-btn>

              <v-btn color="#800000" variant="flat" class="mr-2" @click="exportToPDF">
                <v-icon left>mdi-file-pdf-box</v-icon>
                Export PDF
              </v-btn>
              <v-btn color="#303F9F" prepend-icon="mdi-printer" @click="printData" variant="flat">
                Print
              </v-btn>
              <!-- Tombol batal dan simpan tetap sama -->
            </v-card-actions>
            <!-- <DataTable @load-data="handleLoadData"/> -->
            <v-data-table-server v-model:options="options" :active="form.id ? [form.id] : []" :items="items"
              :items-length="totalItems" :headers="headers" :search="search" class="elevation-0"
              :loading="isLoadingTable" @update:options="loadItems" @click:row="handleRowClick">
              <template v-slot:item.date_in="{ item }">
                {{ formatDate(item.date_in) }}
              </template>
              <template v-slot:item.date_out="{ item }">
                {{ formatDate(item.date_out) }}
              </template>
              <template v-slot:item.time_in="{ item }">
                {{ formatTime(item.time_in) }}
              </template>
              <template v-slot:item.time_out="{ item }">
                {{ formatTime(item.time_out) }}
              </template>
              <template v-slot:item.weight_in="{ item }">
                <span class="font-weight-medium">{{ item.weight_in }}</span>
              </template>
              <template v-slot:item.weight_out="{ item }">
                <span class="font-weight-medium">{{ item.weight_out || '-' }}</span>
              </template>
              <template #[`item.action`]="{ item }">
                <v-row dense>
                  <v-col>

                    <!-- Icon pensil atas (untuk edit) - hanya tampil jika date_out ADA -->
                    <!-- 
                    <v-btn 
                v-if="item.date_out"
                :href="`/transactions/${item.id}/edit`"
                variant="text" 
                color="warning"
              >
                <v-icon icon="mdi-pencil" size="small"/>
              </v-btn>-->

                    <!-- Icon pensil bawah (untuk check out) - hanya tampil jika date_out KOSONG -->
                    <template v-if="!item.date_out">
                      <v-btn v-if="!showEditIcons || editingItemId !== item.id"
                        @click="loadData(item); showEditIcons = true; editingItemId = item.id" variant="text"
                        color="warning">
                        <v-icon icon="mdi-pencil" size="small" />
                      </v-btn>

                      <v-btn v-if="showEditIcons && editingItemId === item.id"
                        @click="handleSaveOut(item); showEditIcons = false; editingItemId = null" variant="text"
                        color="error">
                        <v-icon icon="mdi-content-save" size="small" />
                      </v-btn>
                    </template>
                  </v-col>
                </v-row>
              </template>
            </v-data-table-server>
          </v-col>
        </v-row>
      </v-container>
    </v-main>
    <Footer />
  </v-app>
</template>
