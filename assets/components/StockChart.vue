<template>
  <div class="stock">
    <h1>Price</h1>
    <canvas id="stockChart"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
  name: 'StockChart',
  props: {
    msg: String,
    label: {
      type: String
    },
    chartData: {
      type: Array
    },
    options: {
      type: Object
    }
  },
  mounted() {
    const ctx = document.getElementById('stockChart');

    const dates = this.chartData.map(d => d.date);//.reverse()
    const prices = this.chartData.map(d => d.price);

    const chart = new Chart(ctx, {
      type: 'line',
      data:{
        labels: dates,
        datasets: [{
          label: dates,
          data: prices
        }]
      },
      options: {
        scales:{
          y: {
            beginAtZero: true
          }
        }
      }
    });
    stockChart;
  }
}
</script>