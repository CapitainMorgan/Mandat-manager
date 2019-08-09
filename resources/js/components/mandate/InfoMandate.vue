

<template>

<div class="container">
    <b-card :header="'Mandat : '+mandate.name">
        <b-card-text>
            <b-list-group>
                <b-list-group-item><b>Nom :</b> {{mandate.name}}</b-list-group-item>
                <b-list-group-item><b>Créé :</b> {{ dataFilter(mandate.created_at) }}</b-list-group-item>
                <b-list-group-item><b>Début :</b> {{ dataFilter(mandate.start) }}</b-list-group-item>
                <b-list-group-item><b>Fin :</b> {{ dataFilter(mandate.end) }}</b-list-group-item>
                <b-list-group-item><b>Commentaire :</b> {{mandate.comment}}</b-list-group-item>
            </b-list-group>
            <b-button class="mt-2" variant="primary" :href="'/mandate/modify/'+mandate.id">Modifier</b-button>
        </b-card-text>
<b-list-group>
        <b-list-group-item v-for="(worktime, index) in mandate_worktime">
            Le <strong>{{ dataFilter(worktime.start)}}</strong><br>
            De <strong>{{ dataFilterHour(worktime.start)}}</strong> à <strong>{{ dataFilterHour(worktime.end)}}</strong><br>
            {{ worktime.comment}} &nbsp <b-button v-on:click="deleteWorktime(worktime.id)">Supprimer</b-button>

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
        }
    },
    created: function() {
        this.mandate = JSON.parse(this.mandate_param);
        this.loadWorkTime();
    },
    methods: {
        deleteWorktime: function(id)
        {
          if(confirm('Supprimer ce temps de travail ?'))
          {
            axios.get('/worktime/delete/'+id).then(response => {
              location.reload();
            });
          }
        },
        loadWorkTime: function() {
            let that = this;
            axios.get('/worktime/' + this.mandate.id).then(response => {
                this.mandate_worktime = response.data
            });
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
        }
    }
}

</script>
