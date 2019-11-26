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
                <b-button class="mt-2 " variant="primary " type="submit">Ajouter</b-button>
            </b-form>

        </b-card-text>
    </b-card>
    </div>
</template>

<script>
    
    export default {  
        props: ['mandate_id'],      
        data() {
            return {
                mandate_id: this.mandate_id,
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
        methods: {
            getDate: function()
            {

            },
            generateBill: function(){
                axios.post('/bill/' + this.mandate_id, this.address).then(response => {
                    location.reload();
                },error => {
                    alert("Une erreur est survenue ! Vérifier que tous les champs sont remplis. Sinon merci de contacter l'adiminstrateur.")
                });                         
            },
        },
    }
</script>
