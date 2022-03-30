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
    legendArr: [],
    runID: Number,
    title: String,
    yAxisName: String
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
        let perfVal = Reflect.get(res, requestArr[i]).map(Number)
        if (this.legendArr[i] === 'FPS') {
          let fpsValues = []
          perfVal.forEach(item => fpsValues.push(Math.floor(1000 / item)))
          perfParams.push(fpsValues)
        } else {
          perfParams.push(perfVal)
        }
      }

      let chart = echarts.init(this.$refs.PerfChart)

      let seriesArr = []
      for (var j = 0; j < this.legendArr.length; j++) {
        let seriesVal = { name: this.legendArr[j], type: 'line', smooth: true, data: perfParams[j] }
        seriesArr.push(seriesVal)
      }

      let option = {
        title: {
          text: this.title
        },

        legend: {
          data: this.legendArr
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
          name: this.yAxisName,
          min: 0,
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
