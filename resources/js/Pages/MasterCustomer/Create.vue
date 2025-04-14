<script setup>
import Navbar from '@/Components/Navbar.vue';
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
})



const form = useForm({
    name: props.data?.name || null,
    street: props.data?.street || null,
    district: props.data?.district || null,
    regency: props.data?.regency || null,
    province: props.data?.province || null,
    postalcode: props.data?.postalcode || null,
    telephone: props.data?.telephone || null,
    phone: props.data?.phone || null,
    status: props.data?.status || null,
    remark: props.data?.remark || null,
})

const submit = () => {
    form.post('/mastercustomers', {
        onSuccess: () => {
            //router.visit('/mastercustomers')
        },
    })
}
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
                </v-card-title>
                <v-card>
                    <v-form @submit.prevent="submit">
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.name" label="Name" variant="outlined"
                                        :error-messages="form.errors.name" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.street" label="Street" variant="outlined"
                                        :error-messages="form.errors.street" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.district" label="District" variant="outlined"
                                        :error-messages="form.errors.district" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.regency" label="Regency" variant="outlined"
                                        :error-messages="form.errors.regency" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.province" label="Province" variant="outlined"
                                        :error-messages="form.errors.province" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.postalcode" label="Postal Code" variant="outlined"
                                        :error-messages="form.errors.postalcode" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.telephone" label="Telephone" variant="outlined"
                                        :error-messages="form.errors.telephone" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.phone" label="Phone" variant="outlined"
                                        :error-messages="form.errors.phone" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-select v-model="form.status" :items="statuses" item-title="text"
                                        item-value="value" label="Status" variant="outlined"
                                        :error-messages="form.errors.status" />
                                </v-col>
                                <v-col cols="12" sm="12">
                                    <v-textarea v-model="form.remark" label="Remark" variant="outlined"
                                        :error-messages="form.errors.remark" />
                                </v-col>
                            </v-row>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer />
                            <Link href="/mastercustomers" as="div">
                            <v-btn text>Cancel</v-btn>
                            </Link>
                            <v-btn type="submit" color="primary">Create</v-btn>
                        </v-card-actions>
                    </v-form>
                </v-card>
            </v-container>
        </v-main>
    
    <Footer />
  </v-app>
</template>

<script>
export default {
    name: 'Master Customer Create',
    data() {
        return {
            statuses: [
                { text: 'Active', value: 1 },
                { text: 'Inactive', value: 0 },
            ],
            breadcrumbs: [
                {
                    title: 'Home',
                    disabled: false,
                    href: '/home',
                },
                {
                    title: 'Master Customer',
                    disabled: false,
                    href: '/mastercustomers',
                },
                {
                    title: 'Create',
                    disabled: true,
                },
            ],
        }
    },
}
</script>