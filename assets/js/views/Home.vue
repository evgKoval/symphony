<template>
   <div>
   		<h2 class="center mb-4">Your statistics</h2>
         <div class="center">
            <b-spinner label="Spinning" v-if="loading"></b-spinner>
         </div>
         <canvas id="planet-chart"></canvas>
   </div>
</template>

<script>
import { Bar } from 'vue-chartjs'
import tempus from 'tempusjs';

export default {
  extends: Bar,
  data: () => ({
     loading: true,
      type: 'line',
      data: {
         labels: ['26.11.2019', '27.11.2019', '28.11.2019'],
         datasets: [
            {
               label: 'Visits on this day',
               data: [3, 5, 1],
               backgroundColor: [
                  'rgba(54,73,93,.5)'
               ],
               borderColor: [
                  '#36495d'
               ],
               borderWidth: 2
            }
         ]
      },
      options: {
         responsive: true,
         lineTension: 1,
         scales: {
            yAxes: [{
            ticks: {
               beginAtZero: true,
               padding: 25,
            }
            }]
         }
      }
  }),
   methods: {
      createChart(chartId) {
         const this_ = this;
         const ctx = document.getElementById(chartId);
         const myChart = new Chart(ctx, {
            type: this_.type,
            data: this_.data,
            options: this_.options,
         });
      }
   },
   async mounted() {
      const userId = localStorage.getItem('token_id');

      let userCreatedAt;
      await this.$store.dispatch('getUserCreatedAt', userId)
         .then(res => userCreatedAt = res.data.created_at.date)

      this.data.labels = tempus.generate({
         dateFrom: userCreatedAt,
         formatFrom: '%Y-%m-%d %H:%M:%S',
         dateTo: new Date(),
         period: {day: 1},
         format: '%d.%m.%Y'
      });

      const visitValues = [];

      for(let i = 0; i < this.data.labels.length; i++) {
         await this.$store.dispatch('getCountOfUserVisit', tempus(this.data.labels[i]).format('%Y-%m-%d'))
            .then(value => visitValues.push(value.data['1']))
      }

      this.data.datasets[0].data = visitValues;

      this.createChart('planet-chart');
      this.loading = false;
   }
}
</script>

<style>
.center {
	text-align: center;
}
</style>