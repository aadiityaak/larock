<template>
  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">{{ label }}</label>
    <select v-if="options" :value="modelValue" @change="updateValue($event.target.value)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight">
      <option v-for="(option, index) in options" :key="index" :value="option">{{ option }}</option>
    </select>
    <input v-else type="text" :value="modelValue" @input="updateValue($event.target.value)" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight" />
  </div>
</template>

<script>
export default {
  props: {
    label: String,
    modelValue: String,
    options: Array,
  },
  emits: ['update:modelValue'],
  methods: {
    updateValue(value) {
      this.$emit('update:modelValue', value);
    },
  },
};
</script>