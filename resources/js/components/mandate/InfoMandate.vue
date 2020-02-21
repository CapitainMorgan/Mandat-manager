

<template>

<div class="container">
    <b-card :header="'Mandat : ' + mandate.name">
        <b-card-text>
            <b-alert :show="alert" dismissible>
                Mandat partagé.
            </b-alert>
            <b-list-group>
                <b-list-group-item><b>Nom :</b> {{mandate.name}}</b-list-group-item>
                <b-list-group-item><b>Créé :</b> {{ dataFilter(mandate.created_at) }}</b-list-group-item>
                <b-list-group-item><b>Début :</b> {{ dataFilter(mandate.start) }}</b-list-group-item>
                <b-list-group-item><b>Fin :</b> {{ dataFilter(mandate.end) }}</b-list-group-item>
                <b-list-group-item><b>TVA :</b> {{ mandate.TVA }}</b-list-group-item>
                <b-list-group-item><b>Couleur :</b> <span :style="'color:'+mandate.color+';'">{{ mandate.color }}</span></b-list-group-item>
                <b-list-group-item><b>Commentaire :</b> {{mandate.comment}}</b-list-group-item>
            </b-list-group>
            <b-button class="mt-2" variant="primary" :href="'/mandate/modify/'+mandate.id">Modifier</b-button>
            <b-dropdown class="mt-2" variant="primary" right text="Partager" >
                <b-dropdown-item :key="user.id" v-for="user in users" v-on:click="share(user.id)">{{user.name}}</b-dropdown-item>
            </b-dropdown>
            <b-button class="mt-2" variant="primary" v-b-modal.billModal>Générer une facture</b-button>
        </b-card-text>

        <b-modal id="billModal" title="Facturation" hide-footer>
            <bill-mandate :mandate="mandate"></bill-mandate>
        </b-modal>

        <b-list-group>
            <div class="overflow-auto" align="center" style="margin-bottom:10px;">
                <b-button-group>
                    <b-button v-on:click="goToFirst()" variant="light">Début</b-button>
                    <b-button v-on:click="goToBefore()" variant="light">Avant</b-button>
                    <b-button :id="i" :key="i" v-for="i in nbPage" v-on:click="goTo(i)" variant="light">{{i}}</b-button>
                    <b-button v-on:click="goToNext()" variant="light">Après</b-button>
                    <b-button v-on:click="goToLast()" variant="light">Fin</b-button>
                </b-button-group>
            </div>
            <b-list-group-item dismissible :key="worktime.id" v-for="(worktime,index) in mandate_fees" v-if="(index >= currentWortimeShow && index < currentWortimeShow+nbWorktimeToShow)">
                Le <strong v-text="dataFilter(worktime.start)"></strong><br>
                De <strong v-text="dataFilterHour(worktime.start)"></strong> à <strong v-text="dataFilterHour(worktime.end)"></strong><br>            
                Commentaire : <span v-text="worktime.comment"></span>  <br>   
                Tarif : <span v-text="getPrice(worktime.idPrice)"></span> CHF/Heure <br> 
                <b-list-group-item class="mb-1" :key="fee.id" v-for="fee in worktime.fees">
                    Commentaire : <span v-text="fee.feesComment"></span> <br>
                    Prix : <span v-text="fee.price"></span> CHF
                </b-list-group-item>
                <b-button v-on:click="editWorktime(worktime.id)" >Modifier</b-button> <b-button v-on:click="deleteWorktime(worktime.id)">Supprimer</b-button>
                

            </b-list-group-item>
        </b-list-group>
            
    </b-card>    
</div>

</template>

<script>

import moment from 'moment'

export default {
    props: ['mandate_param'],
    data() {
        return {
            prices : null,
            mandate_worktime: null,
            mandate: null,
            users: null,
            alert: false,
            mandate_fees: null,
            currentWortimeShow:0,
            nbWorktimeToShow: 5,
            lastId:1,
            nbPage:0,
            sortBy:null,
        }
    },
    created: function() {
        
        this.mandate = JSON.parse(this.mandate_param);
        
        this.getNotSharedUser(); 
        axios.get('/price/all').then(response => {
            this.prices = response.data;           
                         
            this.loadWorkTime(); 
        });              
    },
    mounted: function(){
        
    },
    methods: {  
        goTo(index)
        {
            this.currentWortimeShow = (index-1) * this.nbWorktimeToShow;   
            this.updateButtonPage();           
        },
        goToFirst()
        {
            this.currentWortimeShow = 0;
            this.updateButtonPage();
        },
        goToLast()
        {
            this.currentWortimeShow = (this.nbPage -1) * this.nbWorktimeToShow;
            this.updateButtonPage();
        },
        goToBefore()
        {
            if(this.currentWortimeShow != 0)
                this.currentWortimeShow -= this.nbWorktimeToShow;
            this.updateButtonPage();
        },
        goToNext()
        {
            if(this.currentWortimeShow != (this.nbPage -1) * this.nbWorktimeToShow)
                this.currentWortimeShow += this.nbWorktimeToShow;

            this.updateButtonPage();
        },
        updateButtonPage()
        {
            document.getElementById(this.lastId).style = "font-weight: normal;";
            document.getElementById(this.currentWortimeShow / this.nbWorktimeToShow + 1).style = "font-weight: bold;";
            this.lastId = this.currentWortimeShow / this.nbWorktimeToShow + 1;
        },
        deleteWorktime: function(id)
        {
            self = this;
            if(confirm('Supprimer ce temps de travail ?'))
            {
                axios.get('/worktime/delete/'+id).then(response => {
                    self.loadWorkTime();
                },error => {
                    alert("Une erreur est survenue ! Merci de contacter l'adiminstrateur")
                },self);
            }
        },
        loadWorkTime: function() {
            let self = this;
            axios.get('/worktime/' + self.mandate.id).then(response => {
                self.mandate_worktime = response.data;
                var index = 0;
                var listId = [];
                self.mandate_fees = [];
                self.nbPage = Math.ceil(self.mandate_worktime.length / self.nbWorktimeToShow);
                for(var i = 0; i < self.mandate_worktime.length;i++)
                {
                    if(!listId.includes(self.mandate_worktime[i].id))
                    {
                        if(self.mandate_worktime[i].idFees != null)
                        {
                            self.mandate_fees[index] = {id: self.mandate_worktime[i].id,comment:self.mandate_worktime[i].comment,start:self.mandate_worktime[i].start,end:self.mandate_worktime[i].end,idPrice:self.mandate_worktime[i].idPrice,fees:[{id:self.mandate_worktime[i].idFees,feesComment:self.mandate_worktime[i].feesComment,price:self.mandate_worktime[i].price,}],};
                        }else{
                            self.mandate_fees[index] = {id: self.mandate_worktime[i].id,comment:self.mandate_worktime[i].comment,start:self.mandate_worktime[i].start,end:self.mandate_worktime[i].end,idPrice:self.mandate_worktime[i].idPrice,fees:[],};
                        }
                        index++;
                        listId.push(self.mandate_worktime[i].id);
                    }
                    else{
                        if(self.mandate_worktime[i].idFees != null)
                        {
                            self.mandate_fees[listId.indexOf(self.mandate_worktime[i].id)].fees.push({id:self.mandate_worktime[i].idFees,feesComment:self.mandate_worktime[i].feesComment,price:self.mandate_worktime[i].price,});
                        }
                    }                    
                }                                              
            },self).then(response => {                
                this.updateButtonPage();  
            });
        },
        getPrice: function(price_id)
        {
            for(var i = 0; i < this.prices.length;i++)
            {
                if(this.prices[i].id == price_id)
                    return this.prices[i].price;
            }
        },
        dataFilterHour: function(value) {
            if (value) {
                return moment(String(value)).format('HH:mm')
            }

        },
        dataFilter: function(value) {
            if (value) {
                return moment(String(value)).format('DD.MM.YYYY')
            }
        },
        getNotSharedUser: function()
        {
            axios.get('/getAllUsersNotShared/' + this.mandate.id).then(response => {
                this.users = response.data;
            });
        },
        share: function(id){
            if(id)
            {
                self = this;
                axios.get('/mandate/'+ this.mandate.id +"/share/"+ id).then(response => {
                    self.showAlert();
                    self.getNotSharedUser();
                },
                error => {
                    alert("Une erreur est survenue ! Merci de contacter l'adiminstrateur")
                },self);
            }
        },
        editWorktime: function(index){
            location.href = "/worktime/edit/"+index;
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
