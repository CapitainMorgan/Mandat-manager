<template>
    <div class="container">
        <b-card header="Ajouter du temps de travail :">
            <b-card-text>
                <b-form @submit.prevent="editWorktime()">                
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
                                    <b-form-input id="input-price" v-model="fee.price" type="number" required step="0.05"></b-form-input>
                                </b-form-group>
                            </b-col>
                            <b-col>
                                <b-form-group id="input-group-2" label="Nom : " label-for="input-price-name" description="Entrez le nom de ce tarif ">
                                    <b-form-input id="input-price-name" v-model="fee.feesComment " type="text"></b-form-input>
                                </b-form-group>
                            </b-col>
                        </b-row>
                    </div>
                    <b-button class="mt-2 " variant="primary " type="submit ">Modifier</b-button>
                </b-form>
            </b-card-text>
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

    import moment from 'moment'

    export default {
        props: ['worktime_param'],    
        data() {
            return {
                prices: [],
                form: {
                    price: {
                        price: '',
                        name: '',
                    },
                    worktime: {
                        id: this.worktime_param.id,
                        price: this.worktime_param.idPrice,
                        start: this.dataFilter(this.worktime_param.start),
                        end: this.dataFilter(this.worktime_param.end),
                        comment: this.worktime_param.comment,
                        fees: [],
                        fees_number: 0,
                    },
                }
            }
        },
        created: function() {
            axios.get('/price/all').then(response => {
                this.prices = response.data;
                this.sortedArray();
            });
            this.getFees();
        },
        computed: {
            sortedArray: function() {
                function compare(a, b) {
                if (a.name < b.name)
                    return -1;
                if (a.name > b.name)
                    return 1;
                return 0;
                }

                return this.prices.sort(compare);
            }
        },
        methods: {
            dataFilter(value)
            {
              if (value) {
                  return moment(String(value)).format('YYYY-MM-DDThh:mm')
                }
            },

            getFees: function() {
                axios.get('/getFees/'+this.form.worktime.id).then(response => {
                    this.form.worktime.fees = response.data;
                    this.fees_number = this.form.worktime.feeslength;
                });
            },

            editWorktime: function() {
                axios.post('/worktime/edit', this.form).then(response => {
                    location.reload();
                },error => {
                    alert("Une erreur est survenue ! Vérifier que tous les champs sont remplis. Sinon merci de contacter l'adiminstrateur.")
                });
            },

            deleteFees: function(id) {
                //TODO
                this.form.worktime.fees.splice(id, 1);

                this.form.worktime.fees_number--;
            },

            addFees: function() {

                this.form.worktime.fees.push({
                    price: '',
                    feesComment: ''
                });

                this.form.worktime.fees_number++;
            },
            submitPrice: function(){

                self = this;
                axios.post('/price/new', this.form).then(response => {
                    axios.get('/price/all').then(response => {
                        this.prices = response.data;
                        this.sortedArray();
                    });
                    self.form.price.price = "";
                    self.form.price.name = "";
                },error => {
                        alert("Une erreur est survenue ! Vérifier que tous les champs sont remplis. Sinon merci de contacter l'adiminstrateur.")
                },self);
            },
        },
    }
</script>
