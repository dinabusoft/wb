<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
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
    <div class="mb-5">
      <!-- <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs> -->
      <v-snackbar v-model="notif.show " :color="notif.color" location="center">
        {{ notif.message }}
        <v-btn text @click="notif.show = false">Close</v-btn>
      </v-snackbar>
      {{ $page.props?.flash?.success }}
      {{ $page.props?.flash?.error }}
    </div>
    <v-card class="pa-4">
      <div class="d-flex flex-wrap align-center">
        <v-text-field v-model="search" label="Search" variant="underlined" prepend-inner-icon="mdi-magnify" hide-details
          clearable single-line />
        <v-spacer />
        <v-btn color="#303F9F" variant="flat" href="/mastermaterials/create" class="text-none">
                  <v-icon left>mdi-plus</v-icon>
                  Add Material
                </v-btn> 
      </div>
      <v-data-table-server v-model:options="options" :items="items" :items-length="totalItems" :headers="headers"
        :search="search" class="elevation-0" :loading="isLoadingTable" @update:options="loadItems">
        <template #[`item.status`]="{ item }">{{ item.status == '1' ? 'Active' : 'Inactive' }}</template>
        <template #[`item.action`]="{ item }">
          <v-btn :href="`/mastermaterials/${item.id}`" variant="text">
            <span style="color: #303F9F;">clone</span>
              <v-icon color="#303F9F" icon="mdi-content-duplicate" size="small" />

          </v-btn>
          <v-btn :href="`/mastermaterials/${item.id}/edit`" variant="text">
            <span style="color: #303F9F;">edit</span>
              <v-icon color="#303F9F" icon="mdi-pencil" size="small" />

          </v-btn>
          <v-btn @click="deleteItem(item)" variant="text">
            <span style="color: #303F9F;">delete</span>
              <v-icon class="ml-2" color="#303F9F" icon="mdi-delete" size="small" />
          </v-btn>
        </template>
      </v-data-table-server>
    </v-card>
    <v-row justify="center">
      <v-dialog v-model="deleteDialog" persistent width="auto">
        <v-card>
          <v-card-text>Are you sure you want to delete this item?</v-card-text>
          <v-card-actions>
            <v-spacer />
            <v-btn color="error" text @click="deleteDialog = false">Cancel</v-btn>
            <v-btn color="primary" :loading="isLoading" text @click="submitDelete">Delete</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>
  </v-card>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'MasterMaterialIndex',
  props: {
    message: {
        type: Object,
        required: false,
    },
  },
  data() {
    return {
      headers: [
        { title: 'Code', key: 'code' },
        { title: 'Name', key: 'name' },
        { title: 'Package', key: 'pack' },
        { title: 'Content', key: 'content' },
        { title: 'Remark', key: 'remark' },
        { title: 'Status', key: 'status' },
        { title: 'Date Created', key: 'created_at' },
        { title: 'Created by', key: 'created_by_name' },
        { title: 'Last Updated', key: 'updated_at' },
        { title: 'Last Updated by', key: 'updated_by_name' },
        { title: 'Action', key: 'action', sortable: false },
      ],
      notif: { 
        show: this.message?.show || false, 
        message: this.message?.message || '', 
        color: this.message?.color || 'info' },
      items: [],
      totalItems: 0,
      breadcrumbs: [
        {
          title: 'home',
          disabled: false,
          href: '/home',
        },
        {
          title: 'MasterMaterial',
          disabled: true,
        },
      ],
      isLoadingTable: false,
      options: {},
      search: null,
      deleteDialog: false,
      isLoading: false,
      deleteId: null,
    }
  },
  
  methods: {
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
      this.$axios
        .get('/mastermaterials', { params })
        .then((response) => {
          this.items = response.data.data
          this.totalItems = response.data.meta.total
          this.isLoadingTable = false
        })
        .catch(() => {
          this.notif.message = 'Failed to load data'
          this.notif.show = true
          this.notif.color = 'error'
          this.isLoadingTable = false
        })
        
    },
    deleteItem(item) {
      this.deleteId = item.id
      this.deleteDialog = true
    },
    submitDelete() {
      this.isLoading = true
      /*this.$inertia.delete(`/mastermaterials/${this.deleteId}`, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
          this.isLoading = false
          this.deleteDialog = false
          this.loadItems()
        },
      })*/
      this.$axios
        .delete(`/mastermaterials/${this.deleteId}`)
        .then((response) => {
          console.log(response);
          this.isLoading = false
          this.deleteDialog = false
          this.loadItems()
          this.notif = response.data?.message 
        })
        .catch(() => {
          this.notif.message = 'Failed to load data'
          this.notif.show = true
          this.notif.color = 'error'
          this.isLoading = false
          this.deleteDialog = false
        })
    },
  },
}
</script>