<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, useForm, Link } from '@inertiajs/vue3'
import { ref } from 'vue'
import Navbar from '@/Components/Navbar.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true
    },
    materials: Array,
    customers: Array
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
    form.patch(`/transactions/${props.data.id}`, {
        onSuccess: () => {
             Redirect(router.visit('/home'))
        }
    })
}
</script>

<template>
    <Head title="Edit Transaction" />
    <v-app>
        <Navbar />
        <v-main>
            <v-container class="py-6">
                <v-card>
                    <v-card-title class="bg-grey-lighten-3 px-4 py-3">
                        <v-icon icon="mdi-file-document-edit" class="mr-2" color="#303F9F"></v-icon>
                        <span style="color: #303F9F;">EDIT TRANSAKSI</span>
                    </v-card-title>
                    
                    <v-card>
                        <v-form @submit.prevent="submit">
                            <v-card-text>
                                <v-row>
                                    <!-- Kolom Pertama -->
                                    <v-col cols="12" md="6">
                                        <v-text-field v-model="form.ref_no" label="Nomor Referensi" variant="underlined"
                                            :error-messages="form.errors.ref_no" />
                                        
                                        <v-text-field v-model="form.police_no" label="Nomor Polisi" variant="underlined"
                                            :error-messages="form.errors.police_no" />
                                        
                                        <v-text-field v-model="form.driver_name" label="Nama Supir" variant="underlined"
                                            :error-messages="form.errors.driver_name" />
                                        
                                        <v-text-field v-model="form.driver_phone" label="Telepon Supir" variant="underlined"
                                            :error-messages="form.errors.driver_phone" />
                                        <v-text-field v-model="form.weight_in" label="Berat Masuk (kg)" variant="underlined"
                                            :error-messages="form.errors.weight_in" /> 
                                        
                                        <v-select v-model="form.materials_id" :items="materials" item-title="name" item-value="id"
                                            label="Material" variant="underlined" :error-messages="form.errors.materials_id" />

                                           
                                    </v-col>

                                    <!-- Kolom Kedua -->
                                    <v-col cols="12" md="6">
                                        <v-text-field v-model="form.date_in" type="date" label="Tanggal Masuk" variant="underlined"
                                            :error-messages="form.errors.date_in" />
                                        
                                        <v-text-field v-model="form.time_in" type="time" label="Waktu Masuk" variant="underlined"
                                            :error-messages="form.errors.time_in" />


                                        <v-text-field v-model="form.date_out" type="date" label="Tanggal Keluar" variant="underlined"
                                            :error-messages="form.errors.date_out" />
                                        
                                        <v-text-field v-model="form.time_out" type="time" label="Waktu Keluar" variant="underlined"
                                            :error-messages="form.errors.time_out" />
                                        
                                        
                                        <v-text-field v-model="form.weight_out" label="Berat Keluar (kg)" variant="underlined"
                                            :error-messages="form.errors.weight_out" />
                                        
                                        <v-select v-model="form.customers_id" :items="customers" item-title="name" item-value="id"
                                            label="Customer" variant="underlined" :error-messages="form.errors.customers_id" />
                                    </v-col>

                                    <v-col cols="12">
                                        <v-textarea v-model="form.remark" label="Keterangan" variant="underlined"
                                            :error-messages="form.errors.remark" />
                                    </v-col>
                                </v-row>
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer />
                                <Link href="/home" as="div">
                                    <v-btn color="error" variant="flat" class="mr-2">
                                        <v-icon left>mdi-close-circle</v-icon>
                                        Batal
                                    </v-btn>
                                </Link>
                                <v-btn type="submit" color="#303F9F" variant="flat" :loading="form.processing">
                                    <v-icon left>mdi-content-save</v-icon>
                                    Simpan Perubahan
                                </v-btn>
                            </v-card-actions>
                        </v-form>
                    </v-card>
                </v-card>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    name: 'TransactionEdit',
    data() {
        return {
            breadcrumbs: [
                { title: 'Home', href: '/home' },
                { title: 'Transactions', href: '/transactions' },
                { title: 'Edit', disabled: true }
            ]
        }
    }
}
</script>