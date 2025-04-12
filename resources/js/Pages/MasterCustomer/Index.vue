<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, router } from '@inertiajs/vue3'
</script>

<template>

  <Head title="MasterCustomer" />
  <!-- <AuthenticatedLayout> -->
    <div class="mb-5">
      <h5 class="text-h5 font-weight-bold">Master Customer</h5>
      <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
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
        <Link href="/mastercustomers/create" as="div">
        <v-btn color="primary">Create</v-btn>
        </Link>
      </div>
      <v-data-table-server v-model:options="options" :items="items" :items-length="totalItems" :headers="headers"
        :search="search" class="elevation-0" :loading="isLoadingTable" @update:options="loadItems">
        <template #[`item.status`]="{ item }">{{ item.status == '1' ? 'Active' : 'Inactive' }}</template>
        <template #[`item.action`]="{ item }">
          <v-btn :href="`/mastercustomers/${item.id}`" variant="text">
            <template v-slot:prepend>
              <v-icon color="info" icon="mdi-content-duplicate" size="small" />
            </template>
            Clone
          </v-btn>
          <v-btn :href="`/mastercustomers/${item.id}/edit`" variant="text">
            <template v-slot:prepend>
              <v-icon color="warning" icon="mdi-pencil" size="small" />
            </template>
            Edit
          </v-btn>
          <v-btn @click="deleteItem(item)" variant="text">
            <template v-slot:prepend>
              <v-icon class="ml-2" color="error" icon="mdi-delete" size="small" />
            </template>
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
  <!-- </AuthenticatedLayout> -->
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
        color: this.message?.color || 'info' },
      items: [],
      totalItems: 0,
      breadcrumbs: [
        {
          title: 'Dashboard',
          disabled: false,
          href: '/dashboard',
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