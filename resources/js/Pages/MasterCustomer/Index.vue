<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
</script>

<template>

  <Head title="Customer Management" />
  <v-app>
    <Navbar />
    <v-main>
      <v-container class="py-6">
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-account-group" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">CUSTOMER MANAGEMENT</span>
            <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
            <v-snackbar v-model="notif.show" :color="notif.color" location="center">
              {{ notif.message }}
              <v-btn text @click="notif.show = false">Close</v-btn>
            </v-snackbar>
            {{ $page.props?.flash?.success }}
            {{ $page.props?.flash?.error }}
          </v-card-title>


          <v-card class="pa-4">
            <div class="d-flex flex-wrap align-center">
              <v-text-field v-model="search" label="Search" variant="underlined" prepend-inner-icon="mdi-magnify"
                hide-details clearable single-line />
              <v-spacer />
             
              <v-btn color="#303F9F" variant="flat" href="/mastercustomers/create" class="text-none">
                  <v-icon left>mdi-plus</v-icon> <v-spacer class="ms-2"></v-spacer>
                  Add Customer
                </v-btn>

            </div>
            <v-data-table-server v-model:options="options" :items="items" :items-length="totalItems" :headers="headers"
              :search="search" class="elevation-0" :loading="isLoadingTable" @update:options="loadItems">
              <template #[`item.status`]="{ item }">{{ item.status == '1' ? 'Active' : 'Inactive' }}</template>
              <template #[`item.action`]="{ item }">
                <v-btn :href="`/mastercustomers/${item.id}`" variant="text" color="#303F9F" >
                  <v-icon>mdi-content-copy</v-icon>
                  
                  Clone
                </v-btn>
                <v-btn :href="`/mastercustomers/${item.id}/edit`" variant="text" color="#303F9F">
                  <v-icon>mdi-pencil</v-icon>
                  Edit
                </v-btn>
                <v-btn @click="deleteItem(item)" variant="text" color="#303F9F">
                  <v-icon>mdi-delete</v-icon>
                  Delete
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
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
export default {
  name: 'MasterCustomerIndex',
  props: {
    message: {
      type: Object,
      required: false,
    },
  },
  data() {
    return {
      headers: [
        { title: 'Name', key: 'name' },
        { title: 'Street', key: 'street' },
        { title: 'District', key: 'district' },
        { title: 'Regency', key: 'regency' },
        { title: 'Province', key: 'province' },
        { title: 'Postal Code', key: 'postalcode' },
        { title: 'Telephone', key: 'telephone' },
        { title: 'Phone', key: 'phone' },
        { title: 'Status', key: 'status' },
        { title: 'Remark', key: 'remark' },
        { title: 'Date Created', key: 'created_at' },
        { title: 'Created by', key: 'created_by_name' },
        { title: 'Last Updated', key: 'updated_at' },
        { title: 'Last Updated by', key: 'updated_by_name' },
        { title: 'Action', key: 'action', sortable: false },
      ],
      notif: {
        show: this.message?.show || false,
        message: this.message?.message || '',
        color: this.message?.color || 'info'
      },
      items: [],
      totalItems: 0,
      breadcrumbs: [
        {
          title: 'Home',
          disabled: false,
          href: '/home',
        },
        {
          title: 'Master Customer',
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
        .get('/mastercustomers', { params })
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
      /*this.$inertia.delete(`/mastercustomers/${this.deleteId}`, {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
          this.isLoading = false
          this.deleteDialog = false
          this.loadItems()
        },
      })*/
      this.$axios
        .delete(`/mastercustomers/${this.deleteId}`)
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