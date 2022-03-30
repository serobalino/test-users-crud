<template>
    <div v-if="$page.props.flash.message" class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-10">
        <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ $page.props.flash.message }}</span>
        </div>
    </div>
</template>

<script>
export default {
    name: "Alert"
}
</script>

<style scoped>

</style>
