<template>
    <div class="flex items-center">
        <div>
            <slot />
        </div>
        <div class="flex w-full bg-white shadow rounded">
            <input class="relative w-full px-6 py-2 rounded-r border-0 ring-0 focus:outline-none focus:ring-0" autocomplete="off" type="text" name="search" placeholder="Search…" :value="modelValue" @input="$emit('update:modelValue', $event.target.value)">
        </div>
        <button class="ml-3 text-sm text-gray-500 hover:text-gray-700 focus:text-indigo-500" type="button" @click.prevent="$emit('reset')">Reset</button>
    </div>
</template>

<script>
    export default {
        props: ['modelValue'],

        emits: ['update:modelValue', 'reset'],
    }
</script>