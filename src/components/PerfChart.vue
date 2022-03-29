<template>
  <div>
    <div style="width:100%; height:300px" ref="PerfChart"></div>
  </div>
</template>

<script>

let echarts = require('echarts/lib/echarts')
require('echarts/lib/chart/line')
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')
require('echarts/lib/component/legend')
require('echarts/lib/component/grid')

export default {
  props: {
    frameStep: Number,
    requestParam: String,
    runID: Number
  },

  mounted () {
    this.loadData()
  },

  methods: {
    async loadData () {
      let dataURL = 'http://192.168.182.128/assetdb/pub/perf/get_perf_detail.php?request_param=' + this.requestParam + '&run_id=' + this.runID + '&frame_interval=' + this.frameStep
      const {data: res} = await this.$http.get(dataURL)

      let requestArr = this.requestParam.split(',')
      let perfParams = []
      for (var i = 0; i < requestArr.length; i++) {
        perfParams.push(Reflect.get(res, requestArr[i]).map(Number))
      }

      let chart = echarts.init(this.$refs.PerfChart)

      let seriesArr = []
      for (var j = 0; j < requestArr.length; j++) {
        let seriesVal = { name: requestArr[j], type: 'line', smooth: true, data: perfParams[j] }
        seriesArr.push(seriesVal)
      }

      let option = {
        title: {
          text: 'Perf'
        },

        legend: {
          data: this.requestArr
        },

        tooltip: {
          trigger: 'axis',
          axisPointer: {
            type: 'cross',
            label: {
              backgroundColor: '#76baf1'
            }
          }
        },

        xAxis: {
          type: 'category'
        },

        yAxis: {
          type: 'value',
          name: 'ms',
          scale: true,
          splitNumber: 10,
          boundaryGap: [0.2, 0.2]
        },

        series: seriesArr
      }
      chart.setOption(option)
    }
  }
}

</script>
