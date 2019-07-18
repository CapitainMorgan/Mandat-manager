

<template>

<div class="container mt-2">
    <b-row>
        <b-col>
            <b-card header="Ajouter un prix">
                <b-card-text>
                    <b-form @submit.prevent="submitPrice()">
                        <b-form-group id="input-group-1" label="Prix :" label-for="input-price" description="Entrez votre prix">
                            <b-form-input id="input-price" v-model="form.price.value" type="number" required step="0.05"></b-form-input>
                        </b-form-group>
                        <b-form-group id="input-group-2" label="Nom :" label-for="input-price-name" description="Entrez le nom de ce tarif">
                            <b-form-input id="input-price-name" v-model="form.price.name" type="text"></b-form-input>
                        </b-form-group>
                        <b-button class="mt-2" variant="primary" type="submit">Ajouter</b-button>
                    </b-form>

                </b-card-text>
            </b-card>
        </b-col>
        <b-col>
            <b-card header="Ajouter un frais">
                <b-card-text>
                <b-form @submit.prevent="submitFees()">
                    <b-form-group id="input-group-1" label="Prix :" label-for="input-fees" description="Entrez vos frais">
                        <b-form-input id="input-fees" v-model="form.fees.value" type="number" required step="0.05"></b-form-input>
                    </b-form-group>
                    <b-form-group id="input-group-2" label="Nom :" label-for="input-fees-name" description="Entrez la raison du frais">
                        <b-form-input id="input-fees-name" v-model="form.fees.name" type="text"></b-form-input>
                    </b-form-group>
                    <b-button class="mt-2" variant="primary" type="submit">Ajouter au temps de travail</b-button>
                </b-form>
                </b-card-text>
            </b-card>
        </b-col>
    </b-row>
</div>

</template>

<script>

import moment from 'moment'

export default {
data(){
  return {
    form : {
      price : {
        value : '',
        name : '',
      },
      fees: {
        value: '',
        name : '',
      },
    }
  }
}

}

</script>
