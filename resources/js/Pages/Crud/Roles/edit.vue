<template>
    <AppLayout title="Roles">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit Role
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
                                :checked="form.is_admin"
                                class="mt-1"
                            />
                        </div>

                        <div>
                            <JetLabel for="is_default" value="Is default"/>
                            <JetCheckbox
                                id="is_default"
                                v-model="form.is_default"
                                :checked="form.is_default"
                                class="mt-1"
                            />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <JetButton class="ml-4" :class="{ 'opacity-25': form.processing }"
                                       :disabled="form.processing">
                                Update Role
                            </JetButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { useForm } from '@inertiajs/inertia-vue3';
import JetAuthenticationCard from '@/Jetstream/AuthenticationCard.vue';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from '@/Layouts/AppLayout';

const props = defineProps({
    rol: Object,
});

const form = useForm({
    id: props.rol.id,
    name: props.rol.name,
    is_admin: props.rol.is_admin,
    is_default: props.rol.is_default,
});

const submit = () => {
    form.patch(route('roles.update',props.rol.id));
};

</script>

<style scoped>

</style>
