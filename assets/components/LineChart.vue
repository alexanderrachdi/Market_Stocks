<script>
import { Line } from "vue-chartjs";

export default {
  extends: Line,
  props: {
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
    const dates = this.chartData.map(d => d.date);//.reverse()
    const prices = this.chartData.map(d => d.price);

    this.renderChart({
      labels: dates,
      datasets: [{
        label: this.label,
        data: prices
      }],
    },this.options);
  }
};
</script>