<template>
    <div class="container mt-2">
        <b-card header="Tarifs">
            <b-list-group-item :key="price.id" v-for="price in prices">
                <b-form @submit.prevent="editPrice(price.id) ">
                <b-form-group id="input-group-1 " label="Prix : " label-for="input-price " description="Entrez votre prix ">
                    <b-form-input id="input-price " v-model="price.price" type="number" required step="0.05 "></b-form-input>
                </b-form-group>
                <b-form-group id="input-group-2 " label="Nom : " label-for="input-price-name " description="Entrez le nom de ce tarif ">
                    <b-form-input id="input-price-name " v-model="price.name" type="text"></b-form-input>
                </b-form-group>
                <b-button class="mt-2 " variant="primary " type="submit">Modifier</b-button>
                <b-button class="mt-2" variant="primary" :on-click="deletePrice(price.id)"></b-button>
            </b-form>
            </b-list-group-item>
        </b-card>        
    </div>
</template>

<script>    
    export default {
        props:['price_param'],
        data() {
            return {
                prices: this.price_param,
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods:{
            editPrice(index){

            },
            deletePrice(index){
                
            }
        }
    }
</script>
