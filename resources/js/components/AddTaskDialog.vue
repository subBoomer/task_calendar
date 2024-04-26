<template>
    <VDialog v-bind:value="show" max-width="500px" @input="$emit('update:show', $event)">
      <VCard>
        <VCardTitle>
          Add Event
        </VCardTitle>
        <VCardText>
          <VForm @submit.prevent="saveEvent">
            <VTextarea v-model="form.title" label="Title" required></VTextarea>
            <VTextarea v-model="form.start" label="Start" required></VTextarea>
            <VTextarea v-model="form.end" label="End"></VTextarea>
            <VTextarea v-model="form.description" label="Description"></VTextarea>
            <VBtn type="submit">Save</VBtn>
          </VForm>
        </VCardText>
      </VCard>
    </VDialog>
  </template>
  
  <script>
  import { VDialog, VCard, VCardTitle, VCardText, VBtn, VForm, VTextarea } from 'vuetify/components'
  
  export default {
    components:{
      VDialog,
      VCard,
      VCardTitle,
      VCardText,
      VBtn,
      VForm,
      VTextarea
    },
    props:{
      show:{
        type: Boolean,
        required: true
      },
      form:{
        type: Object,
        required: true
      }
    },
    methods:{
      saveEvent(){
        this.$emit('add-event', this.form)
      }
    }
  }
  </script>