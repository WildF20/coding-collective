<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Input } from '@/components/ui/input';
import { Head, useForm } from '@inertiajs/vue3';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-dt';
import { ref, onMounted } from 'vue';
import axios from 'axios';
 
DataTable.use(DataTablesCore);

const tableData = ref([]);

async function fetchData(url: string) {
    try {
        const response = await axios.get(url);
        tableData.value = response.data;
    } catch (error) {
        console.error('Error fetching data:', error);
    }
}

const columns = ref([
    { data: 'id', title: 'Id' },
    { data: 'name', title: 'Name' },
    { data: 'amount', title: 'Amount' },
    { data: 'status', title: 'Status' }
]);

onMounted(async () => {
    try {
        await fetchData('/transaction')
    } catch (error) {
        console.error('Error fetching data:', error);
    }
});

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];

const form = useForm({
    amount: 0,
    status: 'pending',
});

const submit = () => {
    form.post(route('transaction'), {
        onFinish: () => form.reset('amount', 'status'),
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <DataTable :data="tableData" :column="columns" class="table-auto display" ajax="/transaction">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Amount</th>
                    <th>Status</th>
                </tr>
            </thead>
        </DataTable>
    </AppLayout>
</template>
