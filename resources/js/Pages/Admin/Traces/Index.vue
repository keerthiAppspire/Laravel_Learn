<script setup>
defineProps({
    traces: {
        type: Array,
        required: true,
    },
})
</script>

<template>
    <div>
        <h1>Request X-Ray</h1>

        <p>100 slowest requests</p>

        <table>
            <thead>
                <tr>
                    <th>Route</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Trace ID</th>
                </tr>
            </thead>

            <tbody>
                <tr v-for="trace in traces" :key="trace.id">
                    <td>{{ trace.route_name ?? 'N/A' }}</td>
                    <td>{{ trace.duration_ms }} ms</td>
                    <td>{{ trace.status }}</td>
                    <td>{{ trace.trace_id }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>