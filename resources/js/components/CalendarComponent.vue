<template>
    <div class="container"> 
        <FullCalendar
        id="calendar"
        ref="fullCalendar"    
        defaultView="dayGridMonth" 
        :plugins="calendarPlugins" 
        :events="events"
        :header="{
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listDay'
        }"
        locale="fr"
        :firstDay="1"
        :eventLimit="true"
        :views="{
            timeGrid:{
                eventLimit: 3
            }
        }"
        @eventClick="eventClick"
        />
        <fees-price calendar="true"></fees-price>
    </div>
</template>

<style lang='scss'>

@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
@import "~@fullcalendar/timegrid/main.css";

</style>

<script>
    import FullCalendar  from '@fullcalendar/vue';
    import dayGridPlugin from '@fullcalendar/daygrid';
    import timeGridPlugin from "@fullcalendar/timegrid";
    import interactionPlugin from "@fullcalendar/interaction";
    import listPlugin from '@fullcalendar/list';

    export default {
        
        components: {            
            FullCalendar
        },
        data() {
            return {
                calendarPlugins: [dayGridPlugin,timeGridPlugin,interactionPlugin,listPlugin],
                noformatEvents :[],
                events : [],                
            }
        },
        mounted() {
                var self = this;
                axios.get('/events').then(response => (self.noformatEvents) = response.data.events).then(function (response) {
                    for(var i = 0;i < self.noformatEvents.length ;i++)
                    {
                        self.events.push({
                            title: self.noformatEvents[i].title,
                            start: self.noformatEvents[i].start,
                            end: self.noformatEvents[i].end,
                            color: self.noformatEvents[i].color,
                        })
                    }
                },self);
                      
        },
        methods:{
            eventClick: function(info){
                console.log(info);
            },
        },
    }
</script>