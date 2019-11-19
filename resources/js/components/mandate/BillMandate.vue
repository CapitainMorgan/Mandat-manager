<template>
    <div class="container">
        <b-card header="Adresse de facturation" class="mt-2 ">
        <b-card-text>
            <b-form @submit.prevent="generateBill() ">
                <b-form-group id="input-group-1 " label="Nom : " label-for="input-price " description="Entrez votre prix ">
                    <b-form-input id="input-price " v-model="form.address.name " type="number" required step="0.05 "></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2 " label="Chemin : " label-for="input-price-name " description="Entrez le nom de ce tarif ">
                    <b-form-input id="input-price-name " v-model="form.address.street " type="text"></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2 " label="Localité : " label-for="input-price-name " description="Entrez le nom de ce tarif ">
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
        methods: {
            generateBill: function(){
                
            },
        },
        data() {
            return {
                form: {
                    address: {
                        name: '',
                        street: '',
                        locality: '',
                    },
                },
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
