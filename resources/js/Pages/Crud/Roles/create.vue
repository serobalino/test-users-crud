<template>
    <AppLayout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Role
            </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-10">
                    <JetValidationErrors class="mb-4"/>

                    <form @submit.prevent="submit">
                        <div>
                            <JetLabel for="name" value="Name"/>
                            <JetInput
                                id="name"
                                v-model="form.name"
                                type="text"
                                class="mt-1 block w-full"
                                required
                                autofocus
                            />
                        </div>
                        <div>
                            <JetLabel for="is_admin" value="Is admin"/>
                            <JetCheckbox
                                id="is_admin"
                                v-model="form.is_admin"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <JetLabel for="is_default" value="Is default"/>
                            <JetCheckbox
                                id="is_default"
                                v-model="form.is_default"
                                class="mt-1"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                                Create Role
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
    is_admin: false,
    is_default: false,
});

const submit = () => {
    form.post(route('roles.store'));
};

const complete = (response) =>{
    this.$swal.fire({
        icon: 'success',
        text: response.message,
    })
}
</script>

<style scoped>

</style>
