<template>
    <input
        :value="value"
        :type="type"
        @input="handleInput"
        class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
    />
</template>

<script setup lang="ts">
defineProps<{
    value: string;
    type?: string;
}>();

const emit = defineEmits<{
    (event: 'update:value', value: string): void;
}>();

const handleInput = (event: Event) => {
    const target = event.target as HTMLInputElement;
    emit('update:value', target.value);
};
</script>
