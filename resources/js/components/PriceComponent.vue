<template>
    <div class="container mt-2">
        <b-card header="Tarifs">
            <div class="overflow-auto" align="center" style="margin-bottom:10px;">
                <b-button-group>
                    <b-button v-on:click="goToFirst()" variant="light">Début</b-button>
                    <b-button v-on:click="goToBefore()" variant="light">Avant</b-button>
                    <b-button :key="i" v-for="i in nbPage" v-on:click="goTo(i)" variant="light">{{i}}</b-button>
                    <b-button v-on:click="goToNext()" variant="light">Après</b-button>
                    <b-button v-on:click="goToLast()" variant="light">Fin</b-button>
                </b-button-group>
            </div>
            <b-alert :show="alert" dismissible>
                Tarif modifié.
            </b-alert>
            <b-list-group-item :key="price.id" v-for="(price,index) in prices"  v-if="(index >= currentPos && index < currentPos+nbShow)">
                <b-form @submit.prevent="editPrice(price)">
                    <b-form-group id="input-group-1 " label="Prix : " label-for="input-price " description="Entrez votre prix " :show="(index >= currentPos && index < currentPos+nbShow)">
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
                nbShow: 5,
                currentPos: 0,
                nbPage:0,
                form: {                
                    price: {
                        price: '',
                        name: '',
                    },               
                }
            }
        },
        computed: {
            
        },
        mounted() {
            this.sortedArray(); 
            this.nbPage = Math.ceil(this.prices.length / this.nbShow);           
        },
        methods:{
            goTo(index)
            {
                this.currentPos = (index-1) * this.nbShow;                
            },
            goToFirst()
            {
                this.currentPos = 0;
            },
            goToLast()
            {
                this.currentPos = (this.nbPage -1) * this.nbShow;
            },
            goToBefore()
            {
                if(this.currentPos != 0)
                    this.currentPos -= this.nbShow;
            },
            goToNext()
            {
                if(this.currentPos != (this.nbPage -1) * this.nbShow)
                    this.currentPos += this.nbShow;
            },
            sortedArray: function() {
                function compare(a, b) {
                if (a.name < b.name)
                    return -1;
                if (a.name > b.name)
                    return 1;
                return 0;
                }

                return this.prices.sort(compare);
            },
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
