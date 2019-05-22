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
                <tr v-for="(item,index) in mandate">
                    <th>{{item.name}}</th>
                    <th>{{formatDate(item.start)}}</th>
                    <th>{{formatDate(item.end)}}</th>
                    <th>{{getSituation(index)}}</th>
                    <th class="actionTab"><a :href="'./mandate/' + item.id "><i class="fas fa-info-circle icon"></i></a><i class="fas fa-trash-alt icon"></i></th>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import moment from 'moment'
    export default {
        props: ['dataMandate'],

        data() {
            return {
                mandate: this.dataMandate,
            }
        },

        methods:{
            getSituation(index)
            {
                var start = this.mandate[index]['start'];
                var end = this.mandate[index]['end'];
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