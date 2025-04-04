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
    email: props.data.email,
    password: props.data.password,
    password_confirmation: null,
    roles: props.data.roles
})

const submit = () => {
    form.patch('/users/' + props.data.id, {
        onSuccess: () => {
            //router.visit('/users')
        },
    })
}
</script>

<template>

    <Head title="Edit Users" />
    <AuthenticatedLayout>
        <div class="mb-5">
            <h5 class="text-h5 font-weight-bold">Edit Users</h5>
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
                            <v-text-field v-model="form.email" label="Email" variant="underlined"
                                :error-messages="form.errors.email" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.password" label="Password" variant="underlined"
                                :error-messages="form.errors.password" />
                         </v-col>
                         <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.password_confirmation" label="Confirm Password"
                                variant="underlined" :error-messages="form.errors.password_confirmation" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-select v-model="form.roles" :items="roles" label="Roles" chips
                                multiple></v-select>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <Link href="/users" as="div">
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
    name: 'usersEdit',
    data() {
        return {
            roles: ['administrator', 'manager', 'operator'],
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
                    title: 'Userss',
                    disabled: false,
                    href: '/users',
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