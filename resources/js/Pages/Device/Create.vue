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
    port: props.data?.port || null,
    baudrate: props.data?.baudrate || null,
    databits: props.data?.databits || null,
    stopbits: props.data?.stopbits || null,
    parity: props.data?.parity || null,
    inputlen: props.data?.inputlen || null,
    threshold: props.data?.threshold || null,
    delimiter: props.data?.delimiter || null,
    index: props.data?.index || null,
    status: props.data?.status || null,
    remark: props.data?.remark || null,
    log: props.data?.log || null,
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

    <Head title="Device Connection" />
    <v-app>
        <Navbar />
        <v-main>
            <v-container class="py-6">
                <v-card-title class="bg-grey-lighten-3 px-4 py-3">
                    <v-icon icon="mdi-account-group" class="mr-2" color="#303F9F"></v-icon>
                    <span style="color: #303F9F;">DEVICE CONNECTION</span>
                    <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
                </v-card-title>
                <v-card>
                    <v-form @submit.prevent="submit">
                        <v-card-text>
                            <v-row>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.name" label="Name" variant="outlined" density="comfortable"
                                        :error-messages="form.errors.name" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.port" label="Port" type="number" prefix="COM"
                                        variant="outlined" density="comfortable"
                                        :error-messages="form.errors.port"></v-text-field>
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-select v-model="form.baudrate" label="Baudrate"
                                        :items="['9600', '19200', '38400', '57600', '115200']" variant="outlined"
                                        density="comfortable" :error-messages="form.errors.baudrate"></v-select>
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-select v-model="form.databits" label="Data bits" :items="['5', '6', '7', '8']"
                                        variant="outlined" density="comfortable"
                                        :error-messages="form.errors.databits"></v-select>
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-select v-model="form.stopbits" label="Stop bits" :items="['1', '1.5', '2']"
                                        variant="outlined" density="comfortable"
                                        :error-messages="form.errors.stopbits"></v-select>
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-select v-model="form.parity" label="Parity"
                                        :items="['none', 'odd', 'even', 'mark', 'space']" variant="outlined"
                                        density="comfortable" :error-messages="form.errors.parity"></v-select>
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.inputlen" label="Inputlen" variant="outlined" density="comfortable"
                                        :error-messages="form.errors.inputlen" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.threshold" label="Threshold" variant="outlined" density="comfortable"
                                        :error-messages="form.errors.threshold" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.delimiter" label="Delimiter" variant="outlined"density="comfortable"
                                        :error-messages="form.errors.delimiter" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-text-field v-model="form.index" label="Index" variant="outlined" density="comfortable"
                                        :error-messages="form.errors.index" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <!--//new-->
                                    <v-autocomplete v-model="form.user_id" label="User" :items="items_user"
                                        v-model:search="search_user" :loading="loading_user" item-title="text"
                                        item-value="value" density="comfortable" variant="outlined" clearable
                                        :error-messages="form.errors.user_id" />
                                </v-col>
                                <v-col cols="12" sm="12" md="6">
                                    <v-select v-model="form.status" :items="statuses" item-title="text"
                                        item-value="value" label="Status" variant="outlined" density="comfortable"
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
                            <Link href="/devices" as="div">
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
            items_user: [],//new
            search_user: null,//new
            last_search_user: null,//new
            loading_user: false,//new
        }
    },
    watch: {
        search_user(val) {//new
            val && val !== this.last_search_user && this.queryUserSelections(val)
        },
    },
    mounted() {
        this.queryUserSelections()//new
    },
    methods: {
        queryUserSelections(search) {//new
            this.loading_user = true
            var params = {
                page: 1,
                limit: 10,
                sort: { key: 'id', order: 'asc' },
            }
            if (search) {
                params.search = search
            }
            this.$axios.get('/users', { params }).then((response) => {
                this.items_user = [];
                response.data.data.forEach((item) => {
                    this.items_user.push({ value: item.id, text: item.name });
                })
                this.last_search_user = search;
            })
            this.loading_user = false
        },
    },
}
</script>