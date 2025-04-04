<script setup>
import { ref, shallowRef, computed, defineEmits } from 'vue'
import { useDate } from 'vuetify'

const adapter = useDate()
const emit = defineEmits(['load-data'])

const DEFAULT_RECORD = { 
  ticket: '', 
  date: adapter.getDate(adapter.date()), 
  time: adapter.getMinutes(adapter.date()),
  weight: '', 
  policeno: 1, 
  material: '', 
  customer: ''
}

// Reactive state
const bridge = ref([])
const record = ref(DEFAULT_RECORD)
const dialog = shallowRef(false)
const isEditing = shallowRef(false)
const search = ref('')
const page = ref(1)
const itemsPerPage = ref(10)

// Table headers
const headers = ref([
  { title: 'Ticket No', key: 'ticket', align: 'start' },
  { title: 'Date', key: 'date', align: 'end' },
  { title: 'Time', key: 'time', align: 'end' },
  { title: 'Weight(Kg)', key: 'weight', align: 'end' },
  { title: 'Police No', key: 'policeno', align: 'end' },
  { title: 'Material', key: 'material', align: 'end' },
  { title: 'Customer', key: 'customer', align: 'end' },
  { title: 'Actions', key: 'actions', align: 'end', sortable: false },
])

// Computed properties
const filteredItems = computed(() => {
  if (!search.value) return bridge.value
  
  const searchTerm = search.value.toLowerCase()
  return bridge.value.filter(item => {
    return Object.values(item).some(value => 
      String(value).toLowerCase().includes(searchTerm)
    )
  })
})

const paginatedItems = computed(() => {
  const start = (page.value - 1) * itemsPerPage.value
  const end = start + itemsPerPage.value
  return filteredItems.value.slice(start, end)
})

const totalItems = computed(() => filteredItems.value.length)

// Function to load data to parent form
function loadToForm(item) {
  emit('load-data', {
    status: 'Check In',
    ticket: item.ticket,
    date: item.date,
    time: item.time,
    weight: item.weight,
    policeno: item.policeno,
    material: item.material,
    customer: item.customer
  })
}

// Initialize with sample data
function reset() {
  bridge.value = [
    { id: 1, ticket: 'WB0000001', date: '25-03-2025', time: '16:40:00', weight: '24000,00', policeno: 'D 1234 CV', material: 'Limestone', customer: 'PT AAA' },
    { id: 2, ticket: 'WB0000002', date: '26-03-2025', time: '15:40:00', weight: '25000,00', policeno: 'B 1234 CV', material: 'Limestone', customer: 'PT BBB' },
    { id: 3, ticket: 'WB0000003', date: '27-03-2025', time: '14:40:00', weight: '23000,00', policeno: 'Z 1234 CV', material: 'Limestone', customer: 'PT CCC' },
    { id: 4, ticket: 'WB0000004', date: '28-03-2025', time: '13:40:00', weight: '22000,00', policeno: 'C 1234 CV', material: 'Limestone', customer: 'PT DDD' },
    { id: 5, ticket: 'WB0000005', date: '29-03-2025', time: '12:40:00', weight: '21000,00', policeno: 'A 1234 CV', material: 'Limestone', customer: 'PT EEE' },
  ]
}

// CRUD operations
function add() { 
  isEditing.value = false
  record.value = DEFAULT_RECORD
  dialog.value = true
}

function edit(id) {
  isEditing.value = true
  const found = bridge.value.find(item => item.id === id)
  record.value = { ...found }
  dialog.value = true
}

function remove(id) {
  const index = bridge.value.findIndex(item => item.id === id)
  bridge.value.splice(index, 1)
}

function save() {
  if (isEditing.value) {
    const index = bridge.value.findIndex(item => item.id === record.value.id)
    bridge.value[index] = record.value
  } else {
    record.value.id = bridge.value.length + 1
    bridge.value.push(record.value)
  }
  dialog.value = false
}

// Initialize
reset()
</script>

<template>
  <v-sheet border rounded>
    <v-data-table
      :headers="headers"
      :items="paginatedItems"
      :search="search"
      :page.sync="page"
      :items-per-page="itemsPerPage"
      hide-default-footer
    >
      <template v-slot:top>
        <v-toolbar flat>
          <!-- <v-toolbar-title>
            <v-icon color="medium-emphasis" icon="mdi-book-multiple" size="x-small" start></v-icon>
            Records
          </v-toolbar-title>
          <v-spacer></v-spacer> -->
          <v-text-field
            v-model="search"
            append-inner-icon="mdi-magnify"
            label="Search"
            single-line
            hide-details
            class="mr-4"
            style="max-width: 1000px;"
          ></v-text-field>
          <!-- <v-btn
            class="me-2"
            prepend-icon="mdi-plus"
            rounded="lg"
            text="Add"
            border
            @click="add"
          ></v-btn> -->
        </v-toolbar>
      </template>

      <template v-slot:item.actions="{ item }">
        <div class="d-flex ga-2 justify-end">
          <v-tooltip bottom>
            <template v-slot:activator="{ props }">
              <v-icon 
                v-bind="props"
                color="#303F9F" 
                icon="mdi-truck" 
                size="small" 
                @click="loadToForm(item)"
                class="mr-2"
              ></v-icon>
            </template>
            <span>Load to form</span>
          </v-tooltip>
          <v-icon color="#303F9F" icon="mdi-pencil" size="small" @click="edit(item.id)"></v-icon>
          <v-icon color="#303F9F" icon="mdi-delete" size="small" @click="remove(item.id)"></v-icon>
        </div>
      </template>

      <template v-slot:no-data>
        <v-btn
          prepend-icon="mdi-backup-restore"
          rounded="lg"
          text="Reset data"
          variant="text"
          border
          @click="reset"
        ></v-btn>
      </template>
    </v-data-table>

    <div class="text-center pt-2">
      <v-pagination
        v-model="page"
        :length="Math.ceil(totalItems / itemsPerPage)"
        :total-visible="7"
        circle
      ></v-pagination>
    </div>
  </v-sheet>

  <v-dialog v-model="dialog" max-width="500">
    <v-card
      :subtitle="`${isEditing ? 'Update' : 'Create'} record`"
      :title="`${isEditing ? 'Edit' : 'Add'} Record`"
    >
      <template v-slot:text>
        <v-row>
          <v-col cols="12">
            <v-text-field v-model="record.ticket" label="Ticket"></v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field v-model="record.policeno" label="PoliceNo"></v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-select v-model="record.material" :items="['Limestone', 'Coal', 'Sand', 'Gravel']" label="Material"></v-select>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field v-model="record.date" label="Date"></v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field v-model="record.weight" label="Weight"></v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field v-model="record.time" label="Time"></v-text-field>
          </v-col>

          <v-col cols="12" md="6">
            <v-text-field v-model="record.customer" label="Customer"></v-text-field>
          </v-col>
        </v-row>
      </template>

      <v-divider></v-divider>

      <v-card-actions class="bg-surface-light">
        <v-btn text="Cancel" variant="plain" @click="dialog = false"></v-btn>
        <v-spacer></v-spacer>
        <v-btn text="Save" @click="save"></v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>