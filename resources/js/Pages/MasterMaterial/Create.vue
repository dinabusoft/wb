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
    code: props.data?.code||null,
    name: props.data?.name||null,
    pack: props.data?.pack||null,
    content: props.data?.content||null,
    remark: props.data?.remark||null,
    status: props.data?.status||null,
})

const submit = () => {
    form.post('/mastermaterials', {
        onSuccess: () => {
            //router.visit('/mastermaterials')
        },
    })
}
</script>

<template>

    <Head title="Create Master Material" />
    <AuthenticatedLayout>
        <div class="mb-5">
            <h5 class="text-h5 font-weight-bold">Create Master Material</h5>
            <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
        </div>
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
    name: 'MasterMaterialCreate',
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
                    title: 'MasterMaterial',
                    disabled: false,
                    href: '/mastermaterials',
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