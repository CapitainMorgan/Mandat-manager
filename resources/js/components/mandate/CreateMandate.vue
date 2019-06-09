<template>

<div class="container">

    <b-form>
        <b-form-group id="nameInoputGroup" label="Nom" label-for="mandatName">
            <b-form-input id="mandatName" v-model="name">
            </b-form-input>
        </b-form-group>
        <b-form-group id="dateGroup">
          <b-form-group id="startDateGroup" label="Début" label-for="startDate">
            <b-form-input id="startDate" v-model="start" type="date">
            </b-form-input>
          </b-form-group>
          <b-form-group id="endDateGroup" label="Fin" label-for="endDate">
            <b-form-input id="endDate" v-model="start" type="date">
            </b-form-input>
          </b-form-group>
        </b-form-group>
        <b-form-group id="descriptionGroup" label="Description" label-for="textarea">
          <b-form-textarea
              id="textarea"
              v-model="description"
              placeholder="Description"
              rows="3"
            ></b-form-textarea>
        </b-form-group>
        <b-form-group label="Image(s)" id="image">
          <b-form-file
            multiple
            v-model="file"
            placeholder="Ajouter une image"
            drop-placeholder="Drop file here..."
          ></b-form-file>
        </b-form-group>
        <b-button type="submit" variant="primary">Envoyer</b-button>
      <b-button type="reset" variant="danger">Effacer</b-button>
    </b-form>


</div>

</template>

<script>
export default {
    data() {
        return {
            name: '',
            start: '',
            end: '',
            description: '',
            file : Array(),
        }
    },
}

</script>
