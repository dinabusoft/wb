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
    name: props.data?.name||null,
    port: props.data?.port||null,
    baudrate: props.data?.baudrate||null,
    databits: props.data?.databits||null,
    stopbits: props.data?.stopbits||null,
    parity: props.data?.parity||null,
    inputlen: props.data?.inputlen||null,
    threshold: props.data?.threshold||null,
    delimiter: props.data?.delimiter||null,
    index: props.data?.index||null,
    status: props.data?.status||null,
    remark: props.data?.remark||null,
    log: props.data?.log||null,
})

const submit = () => {
    form.post('/devices', {
        onSuccess: () => {
            //router.visit('/devices')
        },
    })
}
</script>

<template>

    <Head title="Create Device" />
    <AuthenticatedLayout>
        <div class="mb-5">
            <h5 class="text-h5 font-weight-bold">Create Device</h5>
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
                            <v-text-field v-model="form.port" label="Port" variant="underlined"
                                :error-messages="form.errors.port" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.baudrate" label="Baudrate" variant="underlined"
                                :error-messages="form.errors.baudrate" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.databits" label="Databits" variant="underlined"
                                :error-messages="form.errors.databits" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.stopbits" label="Stopbits" variant="underlined"
                                :error-messages="form.errors.stopbits" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.parity" label="Parity" variant="underlined"
                                :error-messages="form.errors.parity" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.inputlen" label="Inputlen" variant="underlined"
                                :error-messages="form.errors.inputlen" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.threshold" label="Threshold" variant="underlined"
                                :error-messages="form.errors.threshold" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.delimiter" label="Delimiter" variant="underlined"
                                :error-messages="form.errors.delimiter" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.index" label="Index" variant="underlined"
                                :error-messages="form.errors.index" />
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
                    <Link href="/devices" as="div">
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
    name: 'Device Create',
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
                    title: 'Device',
                    disabled: false,
                    href: '/devices',
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