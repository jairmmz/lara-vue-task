<template>
    <div :class="{ error: props.errors.length }">
        <label for="" class="block text-sm font-medium leading-6 text-gray-900">{{ props.label }}:</label>
        <slot></slot>
        <div class="input-errors" v-for="error of props.errors" :key="error.$uid">
            <div class="error-msg text-red-700 text-xs">{{ error.$message }}</div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ErrorObject } from '@vuelidate/core';

const props = defineProps<{
    label: string;
    errors: ErrorObject[];
}>();
</script>