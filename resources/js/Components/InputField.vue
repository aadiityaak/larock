<template>
  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">{{ label }}</label>
    <!-- <select 
      v-if="isSelectType" 
      :value="modelValue || ''" 
      @change="updateValue($event.target.value)" 
      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight"
    >
      <option disabled value="">Pilih...</option>
      <option 
        v-for="option in filteredOptions" 
        v-if="option.label !== '-'"
        :key="option.value" 
        :value="option.value"
      >
        {{ option.label }}
      </option>
    </select> -->
    <Select 
      v-if="isSelectType" 
      :value="modelValue || ''" 
      @change="updateValue($event.target.value)" 
    >
      <SelectTrigger>
        <SelectValue />
      </SelectTrigger>
      <SelectContent>
        <SelectGroup>
          <SelectItem 
          v-for="option in filteredOptions" 
          :key="option.value" 
          :value="String(option.value)">
            <SelectLabel>{{ option.label }}</SelectLabel>
          </SelectItem>
        </SelectGroup>
      </SelectContent>
    </Select>
    <Input 
      v-else
      type="text"
      :value="modelValue" 
      @input="updateValue($event.target.value)" 
    />
  </div>
</template>

<script>
import {
  Select,
  SelectContent,
  SelectGroup,
  SelectItem,
  SelectLabel,
  SelectTrigger,
  SelectValue,
} from '@/Components/ui/select'
import { Input } from '@/Components/ui/input'
export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    modelValue: {
      type: [String, Number],
      default: '',
    },
    options: {
      type: Array,
      default: () => [],
    },
    inputType: {
      type: String,
      default: 'text',
    },
  },
  components: {
    Select,
    SelectContent,
    SelectGroup,
    SelectItem,
    SelectLabel,
    SelectTrigger,
    SelectValue,
    Input,
  },
  emits: ['update:modelValue'],
  computed: {
    isSelectType() {
      return this.inputType === 'select' && Array.isArray(this.options) && this.options.length > 0;
    },
    filteredOptions() {
      return this.options.filter(option => option && option.label && option.label !== '-');
    },
  },
  methods: {
    updateValue(value) {
      this.$emit('update:modelValue', value);
    },
  },
  mounted() {
    // console.log(this.options);
  },
};
</script>

<style scoped>
/* Tambahan gaya jika perlu */
</style>