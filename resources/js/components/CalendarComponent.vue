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
                events : [],                
            }
        },
        mounted() {
            axios.get('/events').then(response => (this.events) = response.data.events);
        },
    }
</script>