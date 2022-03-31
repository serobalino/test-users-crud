<template>
    <AppLayout title="Users">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
                <Link :href="route('users.create')" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                    New
                </Link>
            </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <vue-good-table
                        :columns="columns"
                        :rows="users"
                        :pagination-options="{
                            enabled: true
                        }"
                    >
                        <template #table-row="props">
                            <span v-if="props.column.label ==='Actions'">
                                <Link :href="route('users.edit',props.row.id)" class="text-blue-400 hover:text-blue-600 text-sm">
                                    Edit
                                </Link>
                                <a href="#" v-on:click="confirmDel(props.row)" class="text-red-400 hover:text-red-600 text-sm">
                                    Delete
                                </a>
                            </span>
                            <span v-else>
                               {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>
                    </vue-good-table>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout';
import JetButton from '@/Jetstream/Button';
import {VueGoodTable} from 'vue-good-table-next';
import { Link } from '@inertiajs/inertia-vue3';
import {Inertia} from "@inertiajs/inertia";

export default {
    name: "index-users",
    components: {
        AppLayout,VueGoodTable,JetButton,Link
    },
    props: {
        users:{
            type: Array,
            required: true
        }
    },
    data:()=>({
        columns:[
            {
                label: 'ID',
                field: 'id',
                filterOptions: {
                    enabled: true,
                }
            },
            {
                label: 'Name',
                field: 'name',
                filterOptions: {
                    enabled: true,
                }
            },
            {
                label: 'Lastname',
                field: 'lastName',
                filterOptions: {
                    enabled: true,
                }
            },
            {
                label: 'Phone',
                field: 'phone',
                filterOptions: {
                    enabled: true,
                }
            },
            {
                label: 'Address',
                field: 'address',
                filterOptions: {
                    enabled: true,
                }
            },
            {
                label: 'Birth date',
                field: 'birthdate',
            },
            {
                label: 'Last login',
                field: 'lastLogin',
            },
            {
                label: 'Actions',
                field: 'actions',
            },
        ]
    }),
    methods: {
        confirmDel(row){
            this.$swal({
                title: 'Delete',
                text: "Are you sure you want to delete "+row.name+"?",
                icon: 'warning',
                showCancelButton: true,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return Inertia.delete(route('users.destroy',row.id));
                },
            })
        },

    }
}
</script>

<style scoped>

</style>
