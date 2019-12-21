<template>
    <div class="container">
        <b-card header="Adresse de facturation" class="mt-2 ">
        <b-card-text>
            <b-form @submit.prevent="generateBill() ">
                <b-form-group id="input-group-1 " label="Nom : " label-for="input-price " description="Entrez le nom du client ">
                    <b-form-input id="input-price " v-model="form.address.name " type="text" required step="0.05 "></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2 " label="Chemin : " label-for="input-price-name " description="Entrez le chemin ">
                    <b-form-input id="input-price-name " v-model="form.address.street " type="text"></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2 " label="Localité : " label-for="input-price-name " description="Entrez la localité">
                    <b-form-input id="input-price-name " v-model="form.address.locality " type="text"></b-form-input>
                </b-form-group>
                <b-form-group id="startDateGroup" label="Début" label-for="startDate">
                    <b-form-input id="startDate" v-model="form.address.start_date" type="date">
                    </b-form-input>               
                </b-form-group>
                <b-form-group id="endDateGroup" label="Fin" label-for="endDate">
                    <b-form-input id="endDate" v-model="form.address.end_date" type="date">
                    </b-form-input>
                </b-form-group> 

                <b-button class="mt-2 " variant="primary" type="submit" :disabled="disabled">Ajouter</b-button>
            </b-form>

        </b-card-text>
    </b-card>
    </div>
</template>

<script>
    
    export default {  
        props: ['mandate'],      
        data() {
            return {
                mandate_: this.mandate,
                disabled: false,
                form: {
                    address: {
                        name: '',
                        street: '',
                        locality: '',
                        start_date: '',
                        end_date: '',
                    },
                },
            }
        },
        mounted: function(){
            if(this.mandate_.TVA == null)
            {
                alert("Le champs TVA est vide. Merci de le remplir avant de continuer");
                this.disabled = true;
            }
            if(this.mandate_.end == null)
            {
                alert("Le champs date de fin est vide. Merci de le remplir avant de continuer");
                this.disabled = true;
            }else{
                this.form.address.start_date = this.dataFilter(this.mandate_.start);
                this.form.address.end_date = this.dataFilter(this.mandate_.end);
            }
        },
        methods: {
            dataFilter(value)
            {
              if (value) {
                  return moment(String(value)).format('YYYY-MM-DD')
                }
            },
            generateBill: function(){
                if(this.form.address.end_date <= this.mandate_.end && this.form.address.start_date >= this.mandate_.start 
                && this.form.address.start_date < this.form.address.end_date){
                    axios.post('/bill/' + this.mandate_.id, this.address).then(response => {
                        location.reload();
                    },error => {
                        alert("Une erreur est survenue ! Vérifier que tous les champs sont remplis. Sinon merci de contacter l'adiminstrateur.")
                    });  
                }
                else{
                    alert("Les dates doivent être compris dans les dates du mandat et la date de fin doit être après la date de début.")
                }
            },
        },
    }
</script>
