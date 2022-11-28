<template>
  <div id="app" class="container">
    <div class="row mt-5" v-if="arrBid.length > 0">
      <div class="col">
        <h2>Price</h2>
        <LineChart :chartData="arrBid" :options="chartOptions" label="Price"></LineChart>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import moment from 'moment';
import LineChart from "./components/LineChart";

export default {
  name: 'App',
  components: {
    LineChart
  },
  data() {
    return {
      arrBid: [],
      chartOptions: {
        responsive: true,
        maintainAspectRatio: false
      }
    }
  },
  async created() {
    const { data } = await axios.get("http://127.0.0.1:8000/api/fetchStock");
    data.forEach(d => {
      const date = moment.unix(d.timestamp).format("MM/DD/YYYY H:m:s");
      const {
        bid
      } = d;

      this.arrBid.push({date, price: bid});

    })
  }
}

</script>