<template>
  <div class="mb-4">
    <label class="block text-gray-700 text-sm font-bold mb-2">{{ label }}</label>

    <Select v-if="isSelectType">
      <SelectTrigger>
        <SelectValue />
      </SelectTrigger>
      <SelectContent>
        <SelectGroup>
          <SelectItem 
            v-for="option in filteredOptions" 
            :key="option.value" 
            :value="String(option.value)"
          >
            <SelectLabel class="pl-0">{{ option.label }}</SelectLabel>
          </SelectItem>
        </SelectGroup>
      </SelectContent>
    </Select>

    <Popover v-else-if="isDateType">
      <PopoverTrigger as-child>
        <Button
          variant="outline"
          :class="[
            'w-full justify-start text-left font-normal',
            !modelValue && 'text-muted-foreground',
          ]"
        >
          <CalendarIcon class="mr-2 h-4 w-4" />
          {{ modelValue ? df.format(new Date(modelValue)) : "Pilih Tanggal" }}
        </Button>
      </PopoverTrigger>
      <PopoverContent class="w-auto p-0">
        <Calendar :value="modelValue" @change="$emit('update:modelValue', $event)" />
      </PopoverContent>
    </Popover>

    <Input 
      v-else-if="inputType === 'currency'"
      ref="currencyInput"
      type="text"
      :value="formattedCurrency"
      @input="updateCurrency"
    />

    <Input 
      v-else
      type="text"
      :value="modelValue"
      @input="$emit('update:modelValue', $event.target.value)"
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
import { Popover, PopoverContent, PopoverTrigger } from '@/Components/ui/popover'
import { Calendar as CalendarIcon } from 'lucide-vue-next'
import { Calendar } from '@/Components/ui/calendar'
import { Button } from '@/Components/ui/button'
import { Input } from '@/Components/ui/input'

export default {
  props: {
    label: {
      type: String,
      required: true,
    },
    modelValue: {
      type: [String, Number, Date, Array, Object],
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
    Popover,
    PopoverContent,
    PopoverTrigger,
    Calendar,
    CalendarIcon,
    Button,
  },
  emits: ['update:modelValue'],
  computed: {
    df() {
      return new Intl.DateTimeFormat('id-ID', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
      });
    },
    isSelectType() {
      return this.inputType === 'select' && Array.isArray(this.options) && this.options.length > 0;
    },
    isDateType() {
      return this.inputType === 'date';
    },
    filteredOptions() {
      return this.options.filter(option => option?.label && option.label !== '-');
    },
    formattedCurrency() {
      const value = parseFloat(this.modelValue);
      return isNaN(value) ? '' : new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        maximumFractionDigits: 0,
      }).format(value);
    },
  },
  methods: {
    updateCurrency(event) {
      const value = event.target.value.replace(/[^\d]/g, '');
      this.$emit('update:modelValue', value);
      this.$nextTick(() => {
        if (this.$refs.currencyInput) {
          this.$refs.currencyInput.value = this.formattedCurrency;
        }
      });
    },
  },
};
</script>

<style scoped>
/* Tambahan gaya jika perlu */
</style>