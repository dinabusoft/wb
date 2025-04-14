<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import { ref } from 'vue';
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';

const props = defineProps({
    data: {
        type: Object,
        required: true,
    },
})

const form = useForm({
    code: props.data.code,
    name: props.data.name,
    pack: props.data.pack,
    content: props.data.content,
    remark: props.data.remark,
    status: props.data.status,
})

const submit = () => {
    form.patch('/mastermaterials/' + props.data.id, {
        onSuccess: () => {
            //router.visit('/mastermaterials')
        },
    })
}
</script>

<template>

    <Head title="Edit Master Material" />
    <v-app>
    <Navbar />
    <v-main>
      <v-container class="py-6">
        <v-card>
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-package-variant" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">EDIT METERIAL</span>
          </v-card-title>
        <v-card>
            <v-form @submit.prevent="submit">
                <v-card-text>
                    <v-row>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.code" label="Code" variant="underlined"
                                :error-messages="form.errors.code" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.name" label="Name" variant="underlined"
                                :error-messages="form.errors.name" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.pack" label="Package" variant="underlined"
                                :error-messages="form.errors.pack" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.content" label="Content" variant="underlined"
                                :error-messages="form.errors.content" />
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
                    <Link href="/mastermaterials" as="div">
                    <v-btn type="submit" color="#303F9F" variant="flat" > <v-icon left>mdi-file-cancel</v-icon>Cancel</v-btn>
                    </Link>
                    <v-btn type="submit" color="#303F9F" variant="flat" > <v-icon left>mdi-content-save</v-icon>Save</v-btn>
                </v-card-actions>
            </v-form>
        </v-card>
    </v-card>
      </v-container>
    </v-main>
  
    <Footer />
  </v-app>
</template>

<script>
export default {
    name: 'mastermaterialsEdit',
    data() {
        return {
            statuses: [
                { text: 'Active', value: '1' },
                { text: 'Inactive', value: '0' },
            ],
            breadcrumbs: [
                {
                    title: 'home',
                    disabled: false,
                    href: '/home',
                },
                {
                    title: 'mastermaterials',
                    disabled: false,
                    href: '/mastermaterials',
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