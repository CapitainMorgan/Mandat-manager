<template>
    <div class="container">
        <b-card header="Ajouter du temps de travail :">
            <b-card-text>
                <b-form @submit.prevent="submitFees()">
                    
                    <b-form-select v-if="calendar" v-model="form.mandate_id" :options="mandates" text-field="name" value-field="id" class="mb-2">
                        <template slot="first">
                            <option :value="null" disabled>-- Choisir un Mandat --</option>
                        </template>
                    </b-form-select>
                
                    <b-row>                    
                        <b-col>
                            <b-form-group id="input-group-1" label="Début :" label-for="input-worktime-start" description="Entrez le début de votre temps de travail">
                                <b-form-input id="input-worktime-start" v-model="form.worktime.start" type="datetime-local" required></b-form-input>
                            </b-form-group>
                        </b-col>
                        <b-col>
                            <b-form-group id="input-group-1" label="Fin :" label-for="input-worktime-end" description="Entrez la fin de votre temps de travail">
                                <b-form-input id="input-worktime-end" v-model="form.worktime.end" type="datetime-local" required></b-form-input>
                            </b-form-group>
                        </b-col>
                    </b-row>
                    <b-form-select v-model="form.worktime.price" :options="prices" text-field="name" value-field="id" class="mb-2">
                        <template slot="first">
                            <option :value="null" disabled>-- Choisir un tarif --</option>
                        </template>
                    </b-form-select>
                    <label for="textarea">Commentaire :</label>
                    <b-form-textarea id="textarea" v-model="form.worktime.comment" placeholder="Entrez un commentaire" rows="3" max-rows="6"></b-form-textarea>

                    <b-button v-on:click="addFees()" class="mt-2">Ajouter un frais</b-button>

                    <div v-bind:key="fee" v-for="(fee, index) in form.worktime.fees" >

                        <b-row class="border mt-2">
                        <b-button variant="outline-dark" @click="deleteFees(index)">X</b-button>
                            <b-col>
                                <b-form-group id="input-group-1" label="Frais : " label-for="input-price" description="Entrez votre prix">
                                    <b-form-input id="input-price" v-model="fee.value" type="number" required step="0.05"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group id="input-group-2" label="Nom : " label-for="input-price-name" description="Entrez le nom de ce tarif ">
                                    <b-form-input id="input-price-name" v-model="fee.name " type="text"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </div>
                    <b-button class="mt-2 " variant="primary " type="submit ">Ajouter du temps de travail</b-button>
                </b-form>
            </b-card-text>
        </b-card>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
