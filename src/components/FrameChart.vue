<template>
  <div>
	<div>
	  <el-select v-model="value" placeholder="请选择" @change="onFrameSelectChange">
		<el-option
		  v-for="item in frame_options"
		  :key="item.value"
		  :label="item.label"
		  :value="item.value">
		</el-option>
	  </el-select>
	</div>

  	<div style="width:100%; height:300px" ref="fpsChart"></div>
  	<div style="width:100%; height:300px" ref="frameChart"></div>
  
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
    frameChart: String,
  },

  data () {
    return {
      chart: null,
      frameTimes: [],
      frameTimesAvg: [],
      gameThreadTimes: [],
      gameThreadTimesAvg: [],
      renderThreadTimes: [],
      renderThreadTimesAvg: [],
      rhiThreadTimes: [],
      rhiThreadTimesAvg: [],
      gpuTimes: [],
      gpuTimesAvg: [],
      fps: [],
      fpsAvg: [],
      frameStep: 0,

      frame_options: [{
        value: 100,
        label: '100帧'
      },{
        value: 50,
        label: '50帧'
      },{
        value: 20,
        label: '20帧'
      },{
        value: 10,
        label: '10帧'
      },{
        value: 5,
        label: '5帧'
      },{
        value: 1,
        label: '单帧'
      }],  

     value: 100
	
    }
  },

  mounted () {
    this.loadFrameData()
  },

  methods: {
    onFrameSelectChange () {
		this.fps = []
        this.loadFrameData()
    },

    async loadFrameData () {
      let frameInterval = this.value;
      let data_url = 'http://192.168.182.128/assetdb/pub/perf/get_perf_detail.php?request_param=FrameTime,GameThreadTime,RenderThreadTime,RHIThreadTime,GPUTime&run_id=4&frame_interval=' + frameInterval;
      const {data: res} = await this.$http.get(data_url);
      this.frameTimes = res.FrameTime.map(Number)
      this.gameThreadTimes = res.GameThreadTime.map(Number)
      this.renderThreadTimes = res.RenderThreadTime.map(Number)
      this.rhiThreadTimes = res.RenderThreadTime.map(Number)
      this.gpuTimes = res.GPUTime.map(Number)

      this.frameTimes.forEach(item => {
        this.fps.push(Math.floor(1000 / item))
      })

      this.initFpsChart()
      this.initFrameChart()
    },

    initFpsChart () {
      this.chart = echarts.init(this.$refs.fpsChart)

      let option = {
        title: {
          text: 'FPS'
        },

        legend: {
          data: ['FPS']
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
          name: '帧',
          scale: true,
          splitNumber: 10,
          boundaryGap: [0.2, 0.2]
        },
        series: [
          {
            name: 'Frame',
            type: 'line',
            smooth: true,
            data: this.fps
          }
        ]
      }

      this.chart.setOption(option)
    },

    initFrameChart () {
      this.chart = echarts.init(this.$refs.frameChart)

      let option = {
        title: {
          text: '性能图'
        },

        legend: {
          data: ['Frame', 'GameThread', 'RenderThread', 'RHIThread', 'GPU']
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
        series: [
          {
            name: 'Frame',
            type: 'line',
            smooth: true,
            data: this.frameTimes
          },
          {
            name: 'GameThread',
            type: 'line',
            smooth: true,
            data: this.gameThreadTimes
          },
          {
            name: 'RenderThread',
            type: 'line',
            smooth: true,
            data: this.renderThreadTimes
          },
          {
            name: 'RHIThread',
            type: 'line',
            smooth: true,
            data: this.rhiThreadTimes
          },
          {
            name: 'GPU',
            type: 'line',
            smooth: true,
            data: this.gpuTimes
          }
        ]
      }

      this.chart.setOption(option)
    },

    calcAvg (initValues, skipOnce) {
      let avgValues = []
      let index = 0
      let totalValue = 0
      for (const currentValue of initValues) {
        index++
        totalValue += currentValue
        if ((index % 100) === 0) {
          if (skipOnce) {
          } else {
            avgValues.push(totalValue / 100)
          }
          skipOnce = false
          index = 0
          totalValue = 0
        }
      }

      if (index !== 0) {
        avgValues.push(totalValue / index)
      }
      return avgValues
    }
  }
}
</script>
