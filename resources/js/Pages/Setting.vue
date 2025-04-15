<script setup>
import { ref, onUnmounted, nextTick } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head } from '@inertiajs/vue3';

const dbSettings = ref({
  hostname: '127.0.0.1',
  user: 'root',
  password: '***************',
  port: '3306',
  database: 'weight_db'
});

const generalSettings = ref({
  unit: 'Kg',
  dateFormat: 'dd-mm-yyyy',
  timeFormat: 'hh:mm:ss',
  reportTemplate: 'EDT TEMPLATE'
});

const serialSettings = ref({
  port: '3',
  baudrate: '9600',
  dataBits: '8',
  stopBits: '1',
  parity: 'none',
  inputLen: '0',
  threshold: '0',
  delimiter: '0',
  index: '0'
});

function saveSettings() {
  // Implement save functionality
  alert('Settings saved successfully!');
}

const terminalOutput = ref('Terminal ready...\n');
const isPortOpen = ref(false);
const intervalId = ref(null);
const terminalElement = ref(null);

function togglePort() {
  isPortOpen.value = !isPortOpen.value;
  if (isPortOpen.value) {
    // Simulasi buka port dan mulai baca data
    terminalOutput.value += 'Open port... OK\nMenerima data berat:\n';
    
   intervalId.value = setInterval(async () => {
  const berat = (Math.random() * 1000).toFixed(2);
  const waktu = new Date().toLocaleTimeString();
  terminalOutput.value += `[${waktu}] Berat: ${berat} ${generalSettings.value.unit}\n`;
  
  await nextTick();
  const textarea = terminalElement.value.$el.querySelector('textarea');
  if (textarea) {
    textarea.scrollTop = textarea.scrollHeight;
  }
}, 1000);
  } else {
    // Tutup port dan hentikan pembacaan
    terminalOutput.value += 'Close port...\n';
    clearInterval(intervalId.value);
    intervalId.value = null;
  }
}

onUnmounted(() => {
  if (intervalId.value) {
    clearInterval(intervalId.value);
  }
});

</script>

<template>
  <Head title="Settings" />
  <v-app>
    <Navbar />
    <v-main>
      <v-container class="py-6">
        <v-card flat>
          <!-- DATABASE Section -->
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-database" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">DATABASE</span>
          </v-card-title>
          <v-card-text class="pa-4">
            <v-row>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="dbSettings.hostname"
                  label="Hostname/IP"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="dbSettings.user"
                  label="User"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="dbSettings.password"
                  label="Password"
                  type="password"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="dbSettings.port"
                  label="Port"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="dbSettings.database"
                  label="Database"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>

          <!-- GENERAL Section -->
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-cog" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">GENERAL</span>
          </v-card-title>
          <v-card-text class="pa-4">
            <v-row>
              <v-col cols="12" md="6">
                <v-select
                  v-model="generalSettings.unit"
                  label="Unit weight"
                  :items="['Kg', 'Lb', 'Ton']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                  v-model="generalSettings.dateFormat"
                  label="Date format"
                  :items="['dd-mm-yyyy', 'mm-dd-yyyy', 'yyyy-mm-dd']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                  v-model="generalSettings.timeFormat"
                  label="Time format"
                  :items="['hh:mm:ss', 'hh:mm', 'h:mm:ss a']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                  v-model="generalSettings.reportTemplate"
                  label="Report Template"
                  :items="['EDT TEMPLATE', 'STANDARD TEMPLATE', 'CUSTOM TEMPLATE']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
            </v-row>
          </v-card-text>

          <!-- DEVICE SERIAL COMMUNICATION Section -->
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-connection" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">DEVICE SERIAL COMMUNICATION</span>
          </v-card-title>
          <v-card-text class="pa-4">
            <v-row>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.port"
                  label="Port"
                  :items="['1', '2', '3', '4']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.baudrate"
                  label="Baudrate"
                  :items="['9600', '19200', '38400', '57600', '115200']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.dataBits"
                  label="Data bits"
                  :items="['5', '6', '7', '8']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.stopBits"
                  label="Stop bits"
                  :items="['1', '1.5', '2']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.parity"
                  label="Parity"
                  :items="['none', 'odd', 'even', 'mark', 'space']"
                  variant="outlined"
                  density="comfortable"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="serialSettings.inputLen"
                  label="InputLen"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="serialSettings.threshold"
                  label="Threshold"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="serialSettings.delimiter"
                  label="Delimiter"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="serialSettings.index"
                  label="Index"
                  variant="outlined"
                  density="comfortable"
                ></v-text-field>
              </v-col>
            </v-row>
          </v-card-text>

          <!-- Terminal Section -->
           <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-console" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">TERMINAL</span>
          </v-card-title>
          <v-card-text class="pa-4">
              <v-textarea
                id="terminal-output"
                ref="terminalElement"
                class="terminal-style"
                variant="outlined"
                rows="3"
                readonly
                v-model="terminalOutput"
                no-resize
                hide-details
                style="height: 150px;"
              ></v-textarea>
              <v-btn
                color="#303F9F"
                variant="flat"
                class="mt-2 text-none"
                @click="togglePort"
              >
                <v-icon left>{{ isPortOpen ? 'mdi-close' : 'mdi-share-variant' }}</v-icon>
                {{ isPortOpen ? 'CLOSE PORT' : 'OPEN PORT' }}
              </v-btn>
            </v-card-text>

          <!-- Save Button -->
          <v-card-actions class="justify-end pa-4">
            <v-btn
              color="#303F9F"
              variant="flat"
              size="large"
              class="text-none px-6"
              @click="saveSettings"
            >
              <v-icon left>mdi-content-save</v-icon>
              SAVE SETTINGS
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-container>
    </v-main>
  
    <Footer />
  </v-app>
</template>

<style scoped>
.v-card-title {
  font-weight: 600;
  border-bottom: 1px solid rgba(0, 0, 0, 0.12);
}

.v-btn {
  letter-spacing: normal;
  text-transform: none;
  font-weight: 500;
}

.v-text-field, .v-select, .v-textarea {
  background-color: #fff;
}
.bg-black {
  background-color: #000 !important;
}

.bg-black :deep(.v-field__input) {
  color: #00ff00 !important; /* Text color*/
  font-family: monospace !important; /* Font monospace */
  font-size: 0.9em;
  caret-color: transparent; /* Sembunyikan kursor */
}

.bg-black :deep(.v-field__field) {
  background-color: #000; /* Latar hitam */
}

.terminal-style :deep(.v-field__input) {
  color: #00ff00 !important;
  font-family: 'Courier New', monospace !important;
  font-size: 0.9em;
  line-height: 1.5;
  white-space: pre-wrap;
  overflow-anchor: none; /* Tambahkan ini */
}

.terminal-style :deep(.v-field__field) {
  background-color: #000 !important;
  padding: 12px !important;
  max-height: 150px; /* Tambahkan ini */
  overflow-y: auto !important;
}

.terminal-style :deep(textarea) {
  scroll-behavior: smooth !important; /* Animasi scroll halus */
}

</style>