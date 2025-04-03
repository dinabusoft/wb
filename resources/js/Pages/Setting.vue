<script setup>
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
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
                  density="compact"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="dbSettings.user"
                  label="User"
                  variant="outlined"
                  density="compact"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="dbSettings.password"
                  label="Password"
                  type="password"
                  variant="outlined"
                  density="compact"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="6">
                <v-text-field
                  v-model="dbSettings.port"
                  label="Port"
                  variant="outlined"
                  density="compact"
                ></v-text-field>
              </v-col>
              <v-col cols="12">
                <v-text-field
                  v-model="dbSettings.database"
                  label="Database"
                  variant="outlined"
                  density="compact"
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
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                  v-model="generalSettings.dateFormat"
                  label="Date format"
                  :items="['dd-mm-yyyy', 'mm-dd-yyyy', 'yyyy-mm-dd']"
                  variant="outlined"
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                  v-model="generalSettings.timeFormat"
                  label="Time format"
                  :items="['hh:mm:ss', 'hh:mm', 'h:mm:ss a']"
                  variant="outlined"
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12" md="6">
                <v-select
                  v-model="generalSettings.reportTemplate"
                  label="Report Template"
                  :items="['EDT TEMPLATE', 'STANDARD TEMPLATE', 'CUSTOM TEMPLATE']"
                  variant="outlined"
                  density="compact"
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
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.baudrate"
                  label="Baudrate"
                  :items="['9600', '19200', '38400', '57600', '115200']"
                  variant="outlined"
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.dataBits"
                  label="Data bits"
                  :items="['5', '6', '7', '8']"
                  variant="outlined"
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.stopBits"
                  label="Stop bits"
                  :items="['1', '1.5', '2']"
                  variant="outlined"
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-select
                  v-model="serialSettings.parity"
                  label="Parity"
                  :items="['none', 'odd', 'even', 'mark', 'space']"
                  variant="outlined"
                  density="compact"
                ></v-select>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="serialSettings.inputLen"
                  label="InputLen"
                  variant="outlined"
                  density="compact"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="serialSettings.threshold"
                  label="Threshold"
                  variant="outlined"
                  density="compact"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="serialSettings.delimiter"
                  label="Delimiter"
                  variant="outlined"
                  density="compact"
                ></v-text-field>
              </v-col>
              <v-col cols="12" md="4">
                <v-text-field
                  v-model="serialSettings.index"
                  label="Index"
                  variant="outlined"
                  density="compact"
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
            <v-textarea class="bg-black"
              label="Terminal Output"
              variant="outlined"
              rows="3"
              readonly
              value="Serial port initialized..."
            ></v-textarea>
            <v-btn
              color="#303F9F"
              variant="flat"
              class="mt-2 text-none"
            >
            <v-icon left>mdi-share-variant</v-icon>
              OPEN PORT
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
</style>