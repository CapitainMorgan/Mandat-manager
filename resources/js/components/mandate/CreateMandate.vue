

<template>

<div class="container">
    <b-alert :show="showAlert" dismissible>
        Mandat créé.
      </b-alert>
      <b-button v-if="modify" class="mt-2" variant="primary" :href="'/mandate/'+id">Retour au mandat</b-button>
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
            <b-from-group id="colorpickerlabel" label="Couleur" label-for="colorpicker">
                <b-form-input id="colorpicker" v-model="color" type="color">
                </b-form-input>
            </b-from-group>
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
import moment from 'moment'

export default {
    props: ['mandate_param'],
    data() {
            return {
                id: '',
                name: '',
                start: '',
                end: '',
                color: '',
                description: '',
                file: [],
                showAlert: false,
                modify: false
            }
        },
        created : function(){
          if(this.mandate_param)
          {
            this.modify = true;
            let my_var = JSON.parse(this.mandate_param);
            this.id = my_var.id;
            this.name = my_var.name;
            this.color = my_var.color;
            this.start = this.dataFilter(my_var.start);
            this.end = this.dataFilter(my_var.end);
            if(this.end == undefined)
                this.end = '';
            this.description = my_var.comment;
          }
        },
        methods: {
            dataFilter(value)
            {
              if (value) {
                  return moment(String(value)).format('YYYY-MM-DD')
                }
            },
            submit() {
                if(this.modify){
                    let formData = new FormData();

                    formData.append('id', this.id)
                    formData.append('name', this.name);
                    formData.append('start', this.start);
                    formData.append('end', this.end);                  
                    formData.append('color',this.color);
                    formData.append('description', this.description);
                    formData.append('files', this.file);

                    axios.post('/mandate/update', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        location.href = "/mandate/"+this.id;
                    });
                }else{
                    let formData = new FormData();


                    this.file.forEach(function(single_file,i,){
                      formData.append('files['+i+']',single_file);
                    });

                    formData.append('name', this.name);
                    formData.append('start', this.start);
                    formData.append('end', this.end);
                    formData.append('color',this.color);
                    formData.append('description', this.description);
                    formData.append('files', this.file);

                    axios.post('/mandate/store', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        location.href = "/mandate";
                    });
                    }
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
