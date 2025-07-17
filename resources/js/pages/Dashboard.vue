<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-dt';
 
DataTable.use(DataTablesCore);

const columns = [
    { data: 'id', title: 'Id' },
    { data: 'Name', title: 'Name' },
    { data: 'Amount', title: 'Amount' },
    { data: 'Status', title: 'Status' }
];

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <DataTable class="display">
            <thead>
                <tr>
                    <th>First</th>
                    <th>Second</th>
                </tr>
            </thead>
        </DataTable>
    </AppLayout>
</template>
