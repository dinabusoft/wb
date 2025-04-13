<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    date_in: props.data.date_in,
    date_out: props.data.date_out,
    time_in: props.data.time_in,
    time_out: props.data.time_out,
    weight_in: props.data.weight_in,
    weight_out: props.data.weight_out,
    ref_no: props.data.ref_no,
    police_no: props.data.police_no,
    driver_name: props.data.driver_name,
    driver_phone: props.data.driver_phone,
    materials_id: props.data.materials_id,
    customers_id: props.data.customers_id,
    remark: props.data.remark,
})

const submit = () => {
    form.patch('/transactions/' + props.data.id, {
        onSuccess: () => {
            //router.visit('/transactions')
        },
    })
}
</script>

<template>

    <Head title="Transaction" />
    <v-app>
        <Navbar />
        <v-main>
            <v-container class="py-6">
                <v-card-title class="bg-grey-lighten-3 px-4 py-3">
                    <v-icon icon="mdi-account-group" class="mr-2" color="#303F9F"></v-icon>
                    <span style="color: #303F9F;">Edit Transaction</span>
                    <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
                </v-card-title>
                <v-card>
                    <v-form @submit.prevent="submit">
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.date_in" label="Date In" variant="outlined"
                                        :error-messages="form.errors.date_in" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.date_out" label="Date Out" variant="outlined"
                                        :error-messages="form.errors.date_out" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.time_in" label="Time In" variant="outlined"
                                        :error-messages="form.errors.time_in" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.time_out" label="Time Out" variant="outlined"
                                        :error-messages="form.errors.time_out" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.weight_in" label="Weight In" variant="outlined"
                                        :error-messages="form.errors.weight_in" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.weight_out" label="Weight Out" variant="outlined"
                                        :error-messages="form.errors.weight_out" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.ref_no" label="Ref No" variant="outlined"
                                        :error-messages="form.errors.ref_no" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.police_no" label="Police No" variant="outlined"
                                        :error-messages="form.errors.police_no" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.driver_name" label="Driver Name" variant="outlined"
                                        :error-messages="form.errors.driver_name" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.driver_phone" label="Driver Phone" variant="outlined"
                                        :error-messages="form.errors.driver_phone" />
                                </v-col>
                                
                                <v-col cols="12" sm="12" md="6">
                                    <!--//new-->
                                    <v-autocomplete v-model="form.materials_id" label="Material" :items="items_material"
                                        v-model:search="search_material" :loading="loading_material" item-title="text"
                                        item-value="value" density="comfortable" variant="outlined" clearable 
                                        :error-messages="form.errors.materials_id" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <!--//new-->
                                    <v-autocomplete v-model="form.customers_id" label="Customer" :items="items_customer"
                                        v-model:search="search_customer" :loading="loading_customer" item-title="text"
                                        item-value="value" density="comfortable" variant="outlined" clearable 
                                        :error-messages="form.errors.customers_id" />
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-textarea v-model="form.remark" label="Remark" variant="outlined"
                                        :error-messages="form.errors.remark" />
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer />
                            <Link href="/transactions" as="div">
                            <v-btn text>Cancel</v-btn>
                            </Link>
                            <v-btn type="submit" color="primary">Save</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: 'transactionsEdit',
    data() {
        return {
            statuses: [
                { text: 'Active', value: 1 },
                { text: 'Inactive', value: 0 },
            ],
            breadcrumbs: [
                {
                    title: 'home',
                    disabled: false,
                    href: '/home',
                },
                {
                    title: 'transactions',
                    disabled: false,
                    href: '/transactions',
                },
                {
                    title: 'Edit',
                    disabled: true,
                },
            ],
            items_material: [],//new
            search_material: null,//new
            last_search_material: null,//new
            loading_material: false,//new
            items_customer: [],//new
            search_customer: null,//new
            last_search_customer: null,//new
            loading_customer: false,//new

        }
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
    },

}
</script>