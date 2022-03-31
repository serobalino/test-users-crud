<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create User
            </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                    <JetValidationErrors class="mb-4"/>

                    <form @submit.prevent="submit">
                        <div>
                            <JetLabel for="lastName" value="Last name" />
                            <JetInput
                                id="lastName"
                                v-model="form.lastName"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                                autocomplete="lastName"
                            />
                        </div>
                        <div>
                            <JetLabel for="name" value="Name" />
                            <JetInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autocomplete="name"
                            />
                        </div>
                        <div>
                            <JetLabel for="birthDate" value="Birth Date" />
                            <JetInput
                                id="birthDate"
                                v-model="form.birthDate"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div class="mt-4">
                            <JetLabel for="email" value="Email" />
                            <JetInput
                                id="email"
                                v-model="form.email"
                                type="email"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div class="mt-4">
                            <JetLabel for="phone" value="Phone" />
                            <JetInput
                                id="phone"
                                v-model="form.phone"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div class="mt-4">
                            <JetLabel for="address" value="Address" />
                            <JetInput
                                id="address"
                                v-model="form.address"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                        </div>

                        <div class="mt-4">
                            <JetLabel for="password" value="Password" />
                            <JetInput
                                id="password"
                                v-model="form.password"
                                type="password"
                                class="mt-1 block w-full"
                                required
                                autocomplete="new-password"
                            />
                        </div>

                        <div class="mt-4">
                            <JetLabel for="roles" value="Roles" />
                            <select class="form-multiselect block w-full mt-1 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" multiple v-model="form.roles">
                                <option v-for="rol in props.roles" :key="rol.id" :value="rol.id">{{rol.name}}</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                                Create User
                            </JetButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Layouts/AppLayout';

const form = useForm({
    name: '',
    email: '',
    password: '',
    lastName: '',
    address: '',
    birthDate: '',
    phone: '',
    roles: [],
});

const props = defineProps({
    roles: Array,
});

const submit = () => {
    form.post(route('users.store'));
};

</script>

<style scoped>

</style>
