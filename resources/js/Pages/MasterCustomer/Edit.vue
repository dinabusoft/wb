<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
})

const form = useForm({
     name: props.data.name,
    street: props.data.street,
    district: props.data.district,
    regency: props.data.regency,
    province: props.data.province,
    postalcode: props.data.postalcode,
    telephone: props.data.telephone,
    phone: props.data.phone,
    status: props.data.status,
    remark: props.data.remark,
})

const submit = () => {
    form.patch('/mastercustomers/' + props.data.id, {
        onSuccess: () => {
            //router.visit('/mastercustomers')
        },
    })
}
</script>

<template>

    <Head title="Edit Master Customer" />
    <AuthenticatedLayout>
        <div class="mb-5">
            <h5 class="text-h5 font-weight-bold">Edit Master Customer</h5>
            <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
        </div>
        <v-card>
            <v-form @submit.prevent="submit">
                <v-card-text>
                    <v-row>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.name" label="Name" variant="underlined"
                                :error-messages="form.errors.name" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.street" label="Street" variant="underlined"
                                :error-messages="form.errors.street" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.district" label="District" variant="underlined"
                                :error-messages="form.errors.district" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.regency" label="Regency" variant="underlined"
                                :error-messages="form.errors.regency" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.province" label="Province" variant="underlined"
                                :error-messages="form.errors.province" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.postalcode" label="Postal Code" variant="underlined"
                                :error-messages="form.errors.postalcode" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.telephone" label="Telephone" variant="underlined"
                                :error-messages="form.errors.telephone" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.phone" label="Phone" variant="underlined"
                                :error-messages="form.errors.phone" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-select v-model="form.status" :items="statuses" item-title="text" item-value="value"
                                label="Status" variant="underlined" :error-messages="form.errors.status" />
                        </v-col>
                        <v-col cols="12" sm="12">
                            <v-textarea v-model="form.remark" label="Remark" variant="underlined"
                                :error-messages="form.errors.remark" />
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <Link href="/mastercustomers" as="div">
                    <v-btn text>Cancel</v-btn>
                    </Link>
                    <v-btn type="submit" color="primary">Save</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: 'mastercustomersEdit',
    data() {
        return {
            statuses: [
                { text: 'Active', value: '1' },
                { text: 'Inactive', value: '0' },
            ],
            breadcrumbs: [
                {
                    title: 'Dashboard',
                    disabled: false,
                    href: '/dashboard',
                },
                {
                    title: 'Master Customers',
                    disabled: false,
                    href: '/mastercustomers',
                },
                {
                    title: 'Edit',
                    disabled: true,
                },
            ],
        }
    },
}
</script>