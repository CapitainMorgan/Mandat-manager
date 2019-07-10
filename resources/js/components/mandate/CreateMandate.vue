

<template>

<div class="container">
    <b-alert :show="showAlert" dismissible>
        Mandat créé.
      </b-alert>

    <b-form @submit.prevent="submit">
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
                <b-form-input id="endDate" v-model="end" type="date">
                </b-form-input>
            </b-form-group>
        </b-form-group>
        <b-form-group id="descriptionGroup" label="Description" label-for="textarea">
            <b-form-textarea id="textarea" v-model="description" placeholder="Description" rows="3"></b-form-textarea>
        </b-form-group>

        <b-form-group label="Image(s) (pas encore fonctionnel)" id="image">
            <b-form-file :file-name-formatter="formatNames" multiple v-model="file" placeholder="Ajouter une image" accept="image/*"></b-form-file>
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
                file: [],
                showAlert: false,
            }
        },
        methods: {
            submit() {

                    let formData = new FormData();


                    this.file.forEach(function(single_file,i,){
                      formData.append('files['+i+']',single_file);
                    });

                    formData.append('name', this.name);
                    formData.append('start', this.start);
                    formData.append('end', this.end);
                    formData.append('description', this.description);
                    formData.append('files', this.file);

                    axios.post('/mandate/store', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        this.showAlert = true;
                    });
                },
                formatNames(files) {
                    if (files.length === 1) {
                        return files[0].name
                    } else {
                        return `${files.length} fichiers séléctionné`
                    }
                }
        },
}

</script>
