<script setup>
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head } from '@inertiajs/vue3';
import moment from 'moment';

const formatDate = (value) => {
  return moment(value, 'YYYY-MM-DD').isValid() 
    ? moment(value, 'YYYY-MM-DD').format('DD/MM/YYYY') 
    : "-";
};
 
const formatTime = (value) => {
  return moment(value, 'HH:mm:ss').isValid() 
    ? moment(value, 'HH:mm:ss').format('HH:mm:ss') 
    : "-";
};

const selectedItem = ref(null);

const handleRowClick = (event, { item }) => {
  selectedItem.value = item;
}
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
            <v-snackbar v-model="notif.show" :color="notif.color" location="center">
              {{ notif.message }}
              <v-btn text @click="notif.show = false">Close</v-btn>
            </v-snackbar>
            <v-icon icon="mdi-filter" color="#303F9F" class="mr-2"></v-icon>
            <span class="text-h6 font-weight-medium" style="color: #303F9F;">Filter Data</span>
          </v-card-title>

          <v-card-text class="pa-4">
            <!-- Date Range Row -->
            <v-row no-gutters>
              <v-col>
                <v-sheet class="pa-2 ma-2">
                  <v-text-field v-model="filters.date_in_begin" label="Date Begin" type="date" density="comfortable"
                    variant="outlined" clearable :max="filters.date_in_end"></v-text-field>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="pa-2 ma-2">
                  <v-autocomplete v-model="filters.customers_id" label="Customer" :items="items_customer"
                    v-model:search="search_customer" :loading="loading_customer" item-title="text" item-value="value"
                    density="comfortable" variant="outlined" clearable />
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="pa-2 ma-2">
                  <v-select v-model="filters.status" label="Status" :items="['All Status', 'Check In', 'Check Out']"
                    density="comfortable" variant="outlined" clearable></v-select>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="pa-2 ma-2">
                  <v-btn color="#303F9F" variant="flat" class="text-none px-6" @click="applyFilters">
                    <v-icon left>mdi-filter-check</v-icon>
                    Filter
                  </v-btn>
                </v-sheet>
              </v-col>

              <v-responsive width="100%"></v-responsive>

              <v-col>
                <v-sheet class="pa-2 ma-2">
                  <v-text-field v-model="filters.date_in_end" label="Date End" type="date" density="comfortable"
                    variant="outlined" clearable :min="filters.date_in_begin"></v-text-field>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="pa-2 ma-2">
                  <v-autocomplete v-model="filters.materials_id" label="Material" :items="items_material"
                    v-model:search="search_material" :loading="loading_material" item-title="text" item-value="value"
                    density="comfortable" variant="outlined" clearable />
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="pa-2 ma-2">
                  <v-text-field v-model="filters.police_no" label="Police No" density="comfortable" variant="outlined"
                    clearable></v-text-field>
                </v-sheet>
              </v-col>
              <v-col>
                <v-sheet class="pa-2 ma-2">
                  <v-btn color="#303F9F" variant="flat" class="text-none px-6" @click="resetFilters">
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
              <v-btn color="success" variant="flat" class="mr-2" @click="exportToExcel">
                <v-icon left>mdi-microsoft-excel</v-icon>
                Export Excel
              </v-btn>
              <v-btn color="#800000" variant="flat" class="mr-2" @click="exportToPDF">
                <v-icon left>mdi-file-pdf-box</v-icon>
                Export PDF
              </v-btn>
              <v-btn 
                color="indigo" 
                variant="flat" 
                class="mr-2" 
                @click="printBuktiTimbangan"
                :disabled="!selectedItem?.date_out"
              >
                <v-icon left>mdi-file-export-outline</v-icon>
                Print Bukti Timbang
              </v-btn>

              <v-text-field 
                class="mt-4" 
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
          <v-data-table-server v-model:options="options" :items="items" :items-length="totalItems" :headers="headers"
            :search="search" class="elevation-0" :loading="isLoadingTable" @update:options="loadItems" @click:row="handleRowClick">
            <template v-slot:item.status="{ item }">
              <v-chip :color="item.status === 'Check out' ? 'green' : 'blue'" variant="flat">
                {{ item.status }}
              </v-chip>
            </template>
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
          </v-data-table-server>
        </v-card>
      </v-container>
    </v-main>
  
    <Footer />
  </v-app>
</template>

<script>
export default {
  name: 'Report',
  data() {
    return {
      headers: [
        { title: 'Status', key: 'status', sortable: false },
        { title: 'Ticket No', key: 'ticket_id', align: 'start' },
        { title: 'Date In', key: 'date_in' },
        { title: 'Date Out', key: 'date_out' },
        { title: 'Time In', key: 'time_in' },
        { title: 'Time Out', key: 'time_out' },
        { title: 'Weight In', key: 'weight_in', align: 'end' },
        { title: 'Weight Out', key: 'weight_out', align: 'end' },
        { title: 'Ref No', key: 'ref_no' },
        { title: 'Police No', key: 'police_no' },
        { title: 'Driver Name', key: 'driver_name' },
        { title: 'Driver Phone', key: 'driver_phone' },
        { title: 'Material', key: 'materials_name' },
        { title: 'Customer', key: 'customers_name' },
        { title: 'Remark', key: 'remark' },
      ],
      items: [],
      totalItems: 0,
      isLoadingTable: false,
      options: {},
      search: null,
      filters: ref({
        date_in_begin: '',
        date_in_end: '',
        customers_id: '',
        materials_id: '',
        police_no: '',
        status: ''
      }),
      items_material: [],//new
      search_material: null,//new
      last_search_material: null,//new
      loading_material: false,//new
      items_customer: [],//new
      search_customer: null,//new
      last_search_customer: null,//new
      loading_customer: false,//new
      notif: {
        show: this.message?.show || false,
        message: this.message?.message || '',
        color: this.message?.color || 'info'
      },
    };
  },
  watch: {
    search_material(val) {//new
      val && val !== this.last_search_material && this.queryMaterialSelections(val)
    },

    search_customer(val) {//new
      val && val !== this.last_search_customer && this.queryCustomerSelections(val)
    },
  },
  mounted() {
    this.queryMaterialSelections()//new
    this.queryCustomerSelections()//new
  },
  methods: {
  formatDate(value) {
      return moment(value, 'YYYY-MM-DD').isValid() 
        ? moment(value, 'YYYY-MM-DD').format('DD/MM/YYYY') 
        : "-";
    },
    
    formatTime(value) {
      return moment(value, 'HH:mm:ss').isValid() 
        ? moment(value, 'HH:mm:ss').format('HH:mm:ss') 
        : "-";
    },
  async loadExternalLibs() {
      return new Promise((resolve) => {
    if (window.XLSX && window.jspdf && window.jspdf.AutoTable) {
      resolve();
      return;
    }

    const scriptsToLoad = [
      'https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js',
      'https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js',
      'https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.28/jspdf.plugin.autotable.min.js'
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
  },
  async exportToPDF() {
      try {
        await this.loadExternalLibs();
        
        // Ambil data
        const params = {
          filter: {
            ...this.filters,
            status: this.filters.status === 'All Status' ? null : this.filters.status
          },
          limit: 'all'
        };

        const response = await this.$axios.get('/transactions', { params });
        const data = response.data.data;

        // Format data untuk PDF
        const headers = this.headers.map(h => h.title);
        const body = data.map(item => 
          this.headers.map(header => {
            const value = item[header.key];
            if (['date_in', 'date_out'].includes(header.key)) {
              return this.formatDate(value);
            }
            if (['time_in', 'time_out'].includes(header.key)) {
              return this.formatTime(value);
            }
            return value || '-';
          })
        );

        // Buat PDF
        const doc = new jspdf.jsPDF({
          orientation: 'landscape',
          unit: 'mm',
          format: 'a4'
        });
        
        doc.autoTable({
          head: [headers],
          body: body,
          styles: { fontSize: 9 },
          headStyles: { 
            fillColor: [48, 63, 159],
            textColor: 255,
            fontStyle: 'bold'
          },
          margin: { top: 20 }
        });

        doc.save(`report-${moment().format('YYYYMMDD-HHmmss')}.pdf`);

      } catch (error) {
        console.error('PDF Error:', error);
        this.notif = {
          show: true,
          color: 'error',
          message: 'Gagal export PDF: ' + error.message
        };
      } finally {
        this.isLoadingTable = false;
      }
},

  async exportToExcel() {
    try {
    this.isLoadingTable = true;
    
    // 1. Load library XLSX
    await this.loadExternalLibs();
    
    // 2. Ambil semua data dengan filter yang sama
    const params = {
      filter: {
        ...this.filters,
        status: this.filters.status === 'All Status' ? null : this.filters.status
      },
      limit: 'all'
    };

    const response = await this.$axios.get('/transactions', { params });
    
    // 3. Format data untuk Excel
    const wsData = [
      this.headers.map(h => h.title),
      ...response.data.data.map(item => 
        this.headers.map(header => {
          const value = item[header.key];
          if (['date_in', 'date_out'].includes(header.key)) {
            return this.formatDate(value);
          }
          if (['time_in', 'time_out'].includes(header.key)) {
            return this.formatTime(value);
          }
          return value;
        })
      )
    ];

    // 4. Generate Excel
    const ws = XLSX.utils.aoa_to_sheet(wsData);
    const wb = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(wb, ws, "Laporan");
    XLSX.writeFile(wb, `full-export-${moment().format('YYYYMMDD-HHmmss')}.xlsx`);

  } catch (error) {
    console.error('Export error:', error);
    this.notif = {
      show: true,
      color: 'error',
      message: 'Gagal export data: ' + error.message
    };
  } finally {
    this.isLoadingTable = false;
  }
  },

  printData() {
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
            ${this.headers.map(header => `<th>${header.title}</th>`).join('')}
          </tr>
        </thead>
        <tbody>
          ${this.items.map(item => `
            <tr>
              ${this.headers.map(header => {
                const value = item[header.key];
                let formattedValue = value;
                
                // Format khusus untuk kolom tertentu
                if (header.key === 'date_in' || header.key === 'date_out') {
                  formattedValue = this.formatDate(value);
                } else if (header.key === 'time_in' || header.key === 'time_out') {
                  formattedValue = this.formatTime(value);
                } else if (header.key === 'status') {
                  formattedValue = value === 'Check Out' ? '✅ Check Out' : '⏳ Check In';
                }
                
                return `<td>${formattedValue || ''}</td>`;
              }).join('')}
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
            Printed on: ${moment().format('YYYY-MM-DD HH:mm:ss')}<br>
            Filter: ${this.getCurrentFilters()}
          </div>
        </body>
      </html>
    `);

    printWindow.document.close();
    printWindow.print();
  },

  getCurrentFilters() {
    return Object.entries(this.filters)
      .filter(([_, value]) => value)
      .map(([key, value]) => `${key}: ${value}`)
      .join(', ');
  },

    loadItems() {
      this.isLoadingTable = true
      const { page, itemsPerPage, sortBy, search } = this.options
      var params = {
        page: page,
        limit: itemsPerPage,
        sort: sortBy[0],
      }
      if (search) {
        params.search = search
      }

      if (this.filters) {
        params.filter = this.filters
      }
      this.$axios
        .get('/transactions', { params })
        .then((response) => {
          this.items = response.data.data
          this.totalItems = response.data.meta.total
          this.notif.color = 'info'
          this.isLoadingTable = false
        })
        .catch(() => {
          this.notif.message = 'Failed to load data'
          this.notif.show = true
          this.notif.color = 'error'
          this.isLoadingTable = false
        })
    },
    resetFilters() {
      this.filters = {
        date_in_begin: '',
        date_in_end: '',
        customers_id: '',
        materials_id: '',
        police_no: '',
        status: ''
      }
       this.queryMaterialSelections();
        this.queryCustomerSelections();
    },
    applyFilters() {
      // Filter implementation
      console.log('Filters applied:', this.filters);
      this.loadItems();
    },
    queryMaterialSelections(search) {//new
      this.loading_material = true
      var params = {
        page: 1,
        limit: 10,
        sort: { key: 'code', order: 'asc' },
      }
      if (search) {
        params.search = search
      }
      this.$axios.get('/mastermaterials', { params }).then((response) => {
        this.items_material = [];
        response.data.data.forEach((item) => {
          this.items_material.push({ value: item.id, text: item.name });
        })
        this.last_search_material = search;
      })
      this.loading_material = false
    },

    queryCustomerSelections(search) {//new
      this.loading_customer = true
      var params = {
        page: 1,
        limit: 10,
        sort: { key: 'id', order: 'asc' },
      }
      if (search) {
        params.search = search
      }
      this.$axios.get('/mastercustomers', { params }).then((response) => {
        this.items_customer = [];
        response.data.data.forEach((item) => {
          this.items_customer.push({ value: item.id, text: item.name });
        })
        this.last_search_customer = search;
      })
      this.loading_customer = false
    },
    /*
    exportItems: async function () {
      this.isLoadingTable = true
      var params = {
        responseType: 'blob', // This is necessary if you are downloading a file
        headers: {
          'Content-Type': 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', // If the server expects JSON content
          // 'Authorization': 'Bearer YOUR_ACCESS_TOKEN', // If authorization is required
        }
      }
      if (this.filters) {
        params.filter = this.filters
      }

      try {
        const response = await this.$axios.get('/transactions-export', { params });

        // Check if the response is actually a file and not some error message
        const contentType = response.headers['content-type'];
        if (contentType !== 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
          throw new Error('Unexpected response type');
        }

        const blob = new Blob([response.data], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });


        /// Create a URL for the blob
        const url = window.URL.createObjectURL(blob);

        // Create a temporary <a> element
        const link = document.createElement('a');
        link.href = url;
        link.setAttribute('download', `weight_bridge.xlsx`);

        // Simulate a click on the link to trigger download
        document.body.appendChild(link);
        link.click();

        // Cleanup
        link.remove();
        window.URL.revokeObjectURL(url);

        this.isLoading = false;
      } catch (error) {
        this.notif.message = 'Failed to export data:' + error
        this.notif.show = true
        this.notif.color = 'error'
        this.isLoadingTable = false
      }
    },*/
  }
}
</script>

<style scoped>
.v-card-title {
  border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}

.v-btn {
  letter-spacing: 0.5px;
  font-weight: 500;
}

.v-text-field,
.v-select,
.v-autocomplete {
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