<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import { Head, Link, useForm, router } from '@inertiajs/vue3'
import Navbar from '@/Components/Navbar.vue';


const form = useForm({
    name: null,
    email: null,
    password: null,
    password_confirmation: null,
    role: null,
})

const submit = () => {
    form.post('/users', {
        onSuccess: () => {
            //router.visit('/users')
        },
    })
}
</script>

<template>

    <Head title="User Administration" />
  <v-app>
    <Navbar />
    <v-main>
      <v-container class="py-6">
          <v-card-title class="bg-grey-lighten-3 px-4 py-3">
            <v-icon icon="mdi-account-cog" class="mr-2" color="#303F9F"></v-icon>
            <span style="color: #303F9F;">USER MANAGEMENT</span>
          </v-card-title>
            <v-breadcrumbs :items="breadcrumbs"></v-breadcrumbs>
        <v-card>
            <v-form @submit.prevent="submit">
                <v-card-text>
                    <v-row>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.name" label="Name" variant="outlined"
                                :error-messages="form.errors.name" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.email" label="Email" variant="outlined"
                                :error-messages="form.errors.email" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.password" label="Password" variant="outlined"
                                :error-messages="form.errors.password" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-text-field v-model="form.password_confirmation" label="Confirm Password"
                                variant="outlined" :error-messages="form.errors.password_confirmation" />
                        </v-col>
                        <v-col cols="12" sm="12" md="6">
                            <v-select v-model="form.role" :items="role" label="Role" :error-messages="form.errors.role" density="comfortable" variant="outlined" clearable></v-select>
                        </v-col>
                    </v-row>
                </v-card-text>
                <v-card-actions>
                    <v-spacer />
                    <Link href="/users" as="div">
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
    name: 'User Create',
    data() {
        return {
            role: ['administrator', 'manager', 'operator'],
            breadcrumbs: [
                {
                    title: 'home',
                    disabled: false,
                    href: '/home',
                },
                {
                    title: 'User',
                    disabled: false,
                    href: '/users',
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