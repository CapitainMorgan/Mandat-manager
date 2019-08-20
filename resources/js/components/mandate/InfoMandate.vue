

<template>

<div class="container">
    <b-card :header="'Mandat : '+mandate.name">
        <b-card-text>
            <b-alert :show="alert" dismissible>
                Mandat partagé.
            </b-alert>
            <b-list-group>
                <b-list-group-item><b>Nom :</b> {{mandate.name}}</b-list-group-item>
                <b-list-group-item><b>Créé :</b> {{ dataFilter(mandate.created_at) }}</b-list-group-item>
                <b-list-group-item><b>Début :</b> {{ dataFilter(mandate.start) }}</b-list-group-item>
                <b-list-group-item><b>Fin :</b> {{ dataFilter(mandate.end) }}</b-list-group-item>
                <b-list-group-item><b>couleur :</b> <span :style="'color:'+mandate.color+';'">{{ mandate.color }}</span></b-list-group-item>
                <b-list-group-item><b>Commentaire :</b> {{mandate.comment}}</b-list-group-item>
            </b-list-group>
            <b-button class="mt-2" variant="primary" :href="'/mandate/modify/'+mandate.id">Modifier</b-button>
            <b-dropdown class="mt-2" variant="primary" right text="Partager" v-bind:key="user" v-for="user in users">
                <b-dropdown-item  v-on:click="share(user.id)">{{user.name}}</b-dropdown-item>
            </b-dropdown>
        </b-card-text>
<b-list-group>
        <b-list-group-item v-bind:key="worktime" v-for="(worktime,index) in mandate_worktime">
            Le <strong>{{ dataFilter(worktime.start)}}</strong><br>
            De <strong>{{ dataFilterHour(worktime.start)}}</strong> à <strong>{{ dataFilterHour(worktime.end)}}</strong><br>            
            Commentaire : {{ worktime.comment}}  <br>            
               <b-list-group-item v-bind:key="fee" v-for="fee in fees[index]">
                        Commentaire : {{ fee.comment }} <br>
                        Prix : {{ fee.price }}    
                </b-list-group-item>
            <b-button >Modifier (ne fonctionne pas encore)</b-button> <b-button v-on:click="deleteWorktime(worktime.id)">Supprimer</b-button>
            

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
            mandate_worktime: null,
            mandate: null,
            users: null,
            alert: false,
            fees: [],
        }
    },
    created: function() {
        this.mandate = JSON.parse(this.mandate_param);
        this.loadWorkTime();
    },
    mounted() {
        this.getNotSharedUser();        
    },
    methods: {
        deleteWorktime: function(id)
        {
            self = this;
            if(confirm('Supprimer ce temps de travail ?'))
            {
                axios.get('/worktime/delete/'+id).then(response => {
                self.loadWorkTime();
                },self);
            }
        },
        loadWorkTime: function() {
            let that = this;
            axios.get('/worktime/' + this.mandate.id).then(response => {
                that.mandate_worktime = response.data;  
                for(var i = 0;i < that.mandate_worktime.length;i++) 
                {                    
                    that.getFees(that.mandate_worktime[i].id,i);
                }               
                    
            },that);
        },
        getFees: function(worktime_id,index) {
            self = this;
            axios.get('/getFees/' + worktime_id).then(response => {
                self.fees[index] = response.data;
            },self);
            
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
                },self);
            }
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
