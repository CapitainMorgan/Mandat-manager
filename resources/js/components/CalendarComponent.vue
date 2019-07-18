<template>
    <div class="container"> 
        <FullCalendar defaultView="month,agendaWeek,agendaDay,listWeek" :plugins="bootstrapPlugins" />
    </div>
</template>¨

<style lang='scss'>

@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';
@import '~@fullcalendar/bootstrap/main.css'

</style>

<script>

import FullCalendar  from '@fullcalendar/vue';
import bootstrapPlugin from '@fullcalendar/bootstrap';
    export default {
        components: {
            FullCalendar
        },
        data() {
            return {
                bootstrapPlugins: [bootstrapPlugin]
            }
        }
    }
</script>