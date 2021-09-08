<template>
  <div>
    <div v-for="errorMessage in errorMessages" :key="errorMessage">
      <v-alert
          border="top"
          color="red lighten-2"
          dark
      >
        {{ errorMessage }}
      </v-alert>
    </div>

  </div>
</template>

<script>
export default {
  name: 'McvValidationErrors',
  props: {
    validationErrors: {
      type: Object,
      required: true
    }
  },
  computed: {
    errorMessages() {
      return Object.keys(this.validationErrors).map(name => {
        const messages = this.validationErrors[name].join(', ')

        return `${name} ${messages}`
      })
    }
  }
}
</script>
