<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue';
//new dihapus
const submit = () => {
    form.post('/transactions', {
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
                    <span style="color: #303F9F;">Create Transaction</span>
                    <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
                </v-card-title>

                <v-card>
                    <v-form @submit.prevent="submit">
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.date_in" label="Date In" variant="underlined"
                                        :error-messages="form.errors.date_in" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.date_out" label="Date Out" variant="underlined"
                                        :error-messages="form.errors.date_out" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.time_in" label="Time In" variant="underlined"
                                        :error-messages="form.errors.time_in" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.time_out" label="Time Out" variant="underlined"
                                        :error-messages="form.errors.time_out" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.weight_in" label="Weight In" variant="underlined"
                                        :error-messages="form.errors.weight_in" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.weight_out" label="Weight Out" variant="underlined"
                                        :error-messages="form.errors.weight_out" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.ref_no" label="Ref No" variant="underlined"
                                        :error-messages="form.errors.ref_no" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.police_no" label="Police No" variant="underlined"
                                        :error-messages="form.errors.police_no" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.driver_name" label="Driver Name" variant="underlined"
                                        :error-messages="form.errors.driver_name" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.driver_phone" label="Driver Phone" variant="underlined"
                                        :error-messages="form.errors.driver_phone" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <!--//new-->
                                    <v-autocomplete v-model="form.materials_id" label="Material" :items="items_material"
                                        v-model:search="search_material" :loading="loading_material" item-title="text"
                                        item-value="value" variant="underlined"
                                        :error-messages="form.errors.materials_id" chips />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <!--//new-->
                                    <v-autocomplete v-model="form.customers_id" label="Customer" :items="items_customer"
                                        v-model:search="search_customer" :loading="loading_customer" item-title="text"
                                        item-value="value" variant="underlined"
                                        :error-messages="form.errors.customers_id" chips />
                                </v-col>

                                <v-col cols="12" sm="12">
                                    <v-textarea v-model="form.remark" label="Remark" variant="underlined"
                                        :error-messages="form.errors.remark" />
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer />
                            <Link href="/transactions" as="div">
                            <v-btn text>Cancel</v-btn>
                            </Link>
                            <v-btn type="submit" color="primary">Create</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: 'TransactionCreate',
    props: {
        data: {
            type: Object,
            required: false,
        },
    },
    data() {
        return {
            form: useForm({
                date_in: this.props?.data?.date_in || null,
                date_out: this.props?.data?.date_out || null,
                time_in: this.props?.data?.time_in || null,
                time_out: this.props?.data?.time_out || null,
                weight_in: this.props?.data?.weight_in || null,
                weight_out: this.props?.data?.weight_out || null,
                ref_no: this.props?.data?.ref_no || null,
                police_no: this.props?.data?.police_no || null,
                driver_name: this.props?.data?.driver_name || null,
                driver_phone: this.props?.data?.driver_phone || null,
                materials_id: this.props?.data?.materials_id || null,
                customers_id: this.props?.data?.customers_id || null,
                remark: this.props?.data?.remark || null,
            }),
            items_material: [],//new
            search_material: null,//new
            last_search_material: null,//new
            loading_material: false,//new
            items_customer: [],//new
            search_customer: null,//new
            last_search_customer: null,//new
            loading_customer: false,//new
            breadcrumbs: [
                {
                    title: 'home',
                    disabled: false,
                    href: '/home',
                },
                {
                    title: 'Transaction',
                    disabled: false,
                    href: '/transactions',
                },
                {
                    title: 'Create',
                    disabled: true,
                },
            ],
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
                    this.items_material.push({ value: item.id, text: item.code + " " + item.name });
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