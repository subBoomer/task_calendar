<template>
  <div class="calendar">
    <div ref="calendar"></div>
  </div>
</template>

<script>
export default {
  mounted() {
        $(this.$refs.calendar).fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay',
            },
            views: {
                agenda: {
                columnHeaderFormat: 'ddd',
                },
                day: {
                columnHeaderFormat: 'dddd',
                },
            },
            defaultView: 'month',
            locale: 'en',
            eventClick(event) {
                alert('Event: ' + event.title);
            },
            events(start, end, timezone, callback) {
                const startDate = start.format('YYYY-MM-DD');
                const endDate = end.format('YYYY-MM-DD');
                axios
                .get('/api/events', {
                    params: {
                    start: startDate,
                    end: endDate,
                    },
                })
                .then((response) => {
                    const events = response.data.map((event) => ({
                    title: event.title,
                    start: moment(event.start).format(),
                    end: moment(event.end).format(),
                    }));
                    callback(events);
                })
                .catch((error) => {
                    console.error(error);
                });
            },
        });
    },
};
</script>

<style scoped>
.calendar {
  height: 600px;
}
</style>