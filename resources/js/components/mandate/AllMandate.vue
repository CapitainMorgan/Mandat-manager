<template>
    <div class="container">  
 
        <h2>Mandats</h2>

        <table class="table table-auto border-collapse">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Situation</th>
                    <th>Option</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(mandate,index) in mandates">
                    <th>{{mandate.name}}</th>
                    <th>{{formatDate(mandate.start)}}</th>
                    <th>{{formatDate(mandate.end)}}</th>
                    <th>{{getSituation(index)}}</th>
                    <th class="actionTab"><b-button pill class="m-1" variant="light" :href="'./mandate/' + mandate.id "><i class="fas fa-info-circle icon"></i></b-button><b-button pill class="m-1" variant="light" v-on:click="deleteMandate(mandate.id,index)" ><i class="fas fa-trash-alt icon"></i></b-button></th>
                </tr>
            </tbody>
        </table>
        <b-button class="mt-2" variant="primary" :href="'/mandate/create'">Nouveau mandat</b-button>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        props: ['dataMandate'],

        data() {
            return {
                mandates: this.dataMandate,
            }
        },

        methods:{
            deleteMandate(mandate_id,index)
            {
                self = this;
                if(confirm('Voulez-vous vraiment archiver ce mandat ?'))
                {
                    axios.get('/mandate/delete/'+mandate_id).then(response => {
                        self.mandates.splice(index, 1);
                    },self);
                }
            },
            getSituation(index)
            {
                var start = this.mandates[index]['start'];
                var end = this.mandates[index]['end'];
                if(end === null)
                {
                    if(moment().isBefore(start))
                    {
                        return "Pas commencé";
                    }else{
                        return "En cours";
                    }
                }else{
                    if(moment().isBefore(end))
                    {
                        return "En cours";
                    }else{
                        return "Fini";
                    }
                }
            },

            formatDate(date)
            {
                return moment(date).locale('fr').format('DD MMMM YYYY')
            }
        },
    }
</script>