<template>
  <v-col cols="6">
  <validation-observer
      ref="observer"
      v-slot="{ invalid }"
  >
    <form @submit.prevent="submit">
      <mcv-validation-errors
          v-if="validationErrors"
          :validation-errors="validationErrors"
      ></mcv-validation-errors>
      <validation-provider
          v-slot="{ errors }"
          name="FirstName"
          rules="required"
      >
        <v-text-field
            v-model="firstName"
            :error-messages="errors"
            label="FirstName"
            required
        ></v-text-field>
      </validation-provider>
      <validation-provider
          v-slot="{ errors }"
          name="LastName"
          rules="required"
      >
        <v-text-field
            v-model="lastName"
            :error-messages="errors"
            label="LastName"
            required
        ></v-text-field>
      </validation-provider>
      <validation-provider
          v-slot="{ errors }"
          name="email"
          rules="required|email"
      >
        <v-text-field
            v-model="email"
            :error-messages="errors"
            label="E-mail"
            required
        ></v-text-field>
      </validation-provider>
      <v-btn
          class="mr-4"
          type="submit"
          :disabled="invalid||isSubmitting"
      >
        submit
      </v-btn>
      <v-btn @click="clear">
        clear
      </v-btn>
    </form>
  </validation-observer>
  </v-col>
</template>
<script>
import {required, email} from 'vee-validate/dist/rules'
import {extend, ValidationObserver, ValidationProvider, setInteractionMode} from 'vee-validate'
import {mapState} from 'vuex'
import McvValidationErrors from '@/components/ValidationErrors.vue'
import {actionTypes} from '@/store/modules/auth'
setInteractionMode('eager')


extend('required', {
  ...required,
  message: '{_field_} can not be empty',
})

extend('email', {
  ...email,
  message: 'Email must be valid',
})

export default {
  components: {
    ValidationProvider,
    ValidationObserver,
    McvValidationErrors
  },
  data: () => ({
    firstName: '',
    lastName: '',
    email: '',
  }),
  computed: {
    ...mapState({
      isSubmitting: state => state.auth.isSubmitting,
      validationErrors: state => state.auth.validationErrors
    })
  },
  methods: {
    submit() {
      if(this.$refs.observer.validate()){
        this.$store
            .dispatch(actionTypes.register, {
              email: this.email,
              firstName: this.firstName,
              lastName: this.lastName
            })
            .then(() => {
              //что делаем дальше
            })
      }
    },
    clear() {
      this.firstName = ''
      this.lastName = ''
      this.email = ''
      this.$refs.observer.reset()
    },
  },
}
</script>