<template>
  <div>
    <input id="inputFormatter" v-model="displayValue" type="text" @blur="isInputActive = false" @focus="isInputActive = true" class="currency-input">
  </div>
</template>

<script>
export default {
  name: 'CurrencyFormatterComponent',
  // props: {
  //   value: {
  //     required: true,
  //     type: Number
  //   }
  // },
  props: {
    value: {
      required: true,
      type: Number
    }
  },
  data() {
    return {
      isInputActive: false
    }
  },
  computed: {
    displayValue: {
      get: function() {
        if (this.isInputActive) {
          // Cursor is inside the input field. unformat display value for user
          return this.value.toString()
        } else {
          // User is not modifying now. Format display value for user interface
          return this.value.toFixed(2).replace(/(\d)(?=(\d{3})+(?:\.\d+)?$)/g, '$1,')
        }
      },
      set: function(modifiedValue) {
        // Recalculate value after ignoring "$" and "," in user input
        let newValue = parseFloat(modifiedValue.replace(/[^\d\.]/g, ''))
        // Ensure that it is not NaN
        if (isNaN(newValue)) {
          newValue = 0
        }
        // Note: we cannot set this.value as it is a "prop". It needs to be passed to parent component
        // $emit the event so that parent component gets it
        this.$emit('input', newValue)
      }
    }
  }
}
</script>

<style scoped>

  input#inputFormatter {
    -webkit-appearance: none;
    background-color: #fff;
    background-image: none;
    border-radius: 4px;
    border: 1px solid #dcdfe6;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    color: #606266;
    display: inline-block;
    font-size: 14px;
    height: 40px;
    line-height: 40px;
    outline: 0;
    padding: 0 15px;
    -webkit-transition: border-color .2s cubic-bezier(.645,.045,.355,1);
    transition: border-color .2s cubic-bezier(.645,.045,.355,1);
    width: 100%;
  }

</style>
