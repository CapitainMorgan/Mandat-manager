<template>
    <div class="container mt-2">
        <b-card header="Tarifs">
            <b-alert :show="alert" dismissible>
                Tarif modifié.
            </b-alert>
            <b-list-group-item :key="price.id" v-for="price in prices">
                <b-form @submit.prevent="editPrice(price) ">
                <b-form-group id="input-group-1 " label="Prix : " label-for="input-price " description="Entrez votre prix ">
                    <b-form-input id="input-price " v-model="price.price" type="number" required step="0.05 "></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2 " label="Nom : " label-for="input-price-name " description="Entrez le nom de ce tarif ">
                    <b-form-input id="input-price-name " v-model="price.name" type="text"></b-form-input>
                </b-form-group>
                <b-button class="mt-2 " variant="primary " type="submit">Modifier</b-button>                
            </b-form>
            </b-list-group-item>
        </b-card>   

        <b-card header="Créer un tarif " class="mt-2 ">
        <b-card-text>           
            <b-form @submit.prevent="submitPrice() ">
                <b-form-group id="input-group-1 " label="Prix : " label-for="input-price " description="Entrez votre prix ">
                    <b-form-input id="input-price " v-model="form.price.price " type="number" required step="0.05 "></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2 " label="Nom : " label-for="input-price-name " description="Entrez le nom de ce tarif ">
                    <b-form-input id="input-price-name " v-model="form.price.name " type="text"></b-form-input>
                </b-form-group>
                <b-button class="mt-2 " variant="primary " type="submit">Ajouter</b-button>
            </b-form>

        </b-card-text>
    </b-card>     
    </div>
</template>

<script>    
    export default {
        props:['price_param'],
        data() {
            return {
                prices: this.price_param,
                alert: false,
                form: {                
                    price: {
                        price: '',
                        name: '',
                    },               
                }
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            editPrice(price){
                axios.post('/price/edit', price).then(response => {
                    this.showAlert();
                },error => {
                        alert("Une erreur est survenue ! Merci de contacter l'adiminstrateur.")
                });
            },
            submitPrice: function(){
                self = this;
                axios.post('/price/new', this.form).then(response => {
                    location.href = "/price";
                },error => {
                        alert("Une erreur est survenue ! Vérifier que tous les champs sont remplis. Sinon merci de contacter l'adiminstrateur.")
                },self);
            },
            showAlert: function(){
                this.alert = true;
                self = this;
                setTimeout(function () {
                    self.alert = false;
                }, 5000,self);
            }
        }
    }
</script>
