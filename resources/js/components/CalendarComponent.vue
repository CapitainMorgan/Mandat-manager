<template>
    <div class="container"> 
        <FullCalendar
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
        firstDay="1"
        />
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
                        end: self.noformatEvents[i].end
                    })
                }
            },self);
            
        },
    }
</script>