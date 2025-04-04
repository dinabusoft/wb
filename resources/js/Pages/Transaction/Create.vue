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
    date_in: props.data?.date_in||null,
    date_out: props.data?.date_out||null,
    time_in: props.data?.time_in||null,
    time_out: props.data?.time_out||null,
    weight_in: props.data?.weight_in||null,
    weight_out: props.data?.weight_out||null,
    ref_no: props.data?.ref_no||null,
    police_no: props.data?.police_no||null,
    driver_name: props.data?.driver_name||null,
    driver_phone: props.data?.driver_phone||null,
    materials_id: props.data?.materials_id||null,
    customers_id: props.data?.customers_id||null,
    remark: props.data?.remark||null,

    
})

const submit = () => {
    form.post('/transactions', {
        onSuccess: () => {
            //router.visit('/transactions')
        },
    })
}
</script>

<template>

    <Head title="Create Transaction" />
    <AuthenticatedLayout>
        <div class="mb-5">
            <h5 class="text-h5 font-weight-bold">Create Transaction</h5>
            <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
        </div>
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
                            <v-text-field v-model="form.materials_id" label="Material Id" variant="underlined"
                                :error-messages="form.errors.materials_id" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.customers_id" label="Customer Id" variant="underlined"
                                :error-messages="form.errors.customers_id" />
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
    </AuthenticatedLayout>
</template>

<script>
export default {
    name: 'TransactionCreate',
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
}
</script>