<template>
    <div>
        <PieChart :data="categoryTotals" v-if="categoryTotals.length > 0" />
    </div>
</template>

<script>
import { Pie } from 'vue-chartjs';
import { defineComponent, ref, watch } from 'vue';

export default defineComponent({
    components: {
        PieChart: Pie,
    },
    props: ['data'],
    setup(props) {
    const chartData = ref({
        labels: [],
        datasets: [],
    });

    watch(
        () => props.data,
        (newData) => {
            if (newData && newData.length > 0) {  // Ensure newData is defined and has items
                chartData.value.labels = newData.map(item => item.name);
                chartData.value.datasets = [
                    {
                        label: 'Total Expenses',
                        backgroundColor: generateColors(newData.length),
                        data: newData.map(item => item.total),
                    },
                ];
            }
        },
        { immediate: true }
    );

    return {
        chartData,
        chartOptions: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
            },
        },
    };
}

});
</script>

<style scoped>
canvas {
    max-width: 100%;
}
</style>
