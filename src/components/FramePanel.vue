<template>
  <div>
    <el-row :gutter="100" class="panel-group" >
      <el-col :span="4" class="card-panel-col">
        <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row><h3>基本数据</h3></el-row>
          <el-row type="flex" justify="start">地图号: {{ outlineData.MapID }} </el-row>
          <el-row type="flex" justify="start">路径名: {{ outlineData.PathName }} </el-row>
          <el-row type="flex" justify="start">平均帧率: {{ (1000/outlineData.FrameTime.avg_value).toFixed(1) }}帧 </el-row>
          <el-row type="flex" justify="start">游戏时间: {{ outlineData.GameTime }}点 </el-row>
          <el-row type="flex" justify="start">天气: {{ outlineData.GameWeather }} </el-row>
          <el-row type="flex" justify="start">运行时间: {{ outlineData.RunDate}}-{{ outlineData.RunTime }}</el-row>
        </div>
      </el-col>
      <el-col :span="4" class="card-panel-col">
        <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row><h3>Frame</h3></el-row>
          <el-row type="flex" justify="start">平均时间: {{ outlineData.FrameTime.avg_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最大时间: {{ outlineData.FrameTime.max_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最小时间: {{ outlineData.FrameTime.min_value.toFixed(1) }}ms </el-row>
        </div>
      </el-col>
      <el-col :span="4" class="card-panel-col">
        <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row><h3>Game线程</h3></el-row>
          <el-row type="flex" justify="start">平均时间: {{ outlineData.GameThreadTime.avg_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最大时间: {{ outlineData.GameThreadTime.max_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最小时间: {{ outlineData.GameThreadTime.min_value.toFixed(1) }}ms </el-row>
        </div>
      </el-col>

      <el-col :span="4" class="card-panel-col">
        <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row><h3>Render线程</h3></el-row>
          <el-row type="flex" justify="start">平均时间: {{ outlineData.RenderThreadTime.avg_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最大时间: {{ outlineData.RenderThreadTime.max_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最小时间: {{ outlineData.RenderThreadTime.min_value.toFixed(1) }}ms </el-row>
        </div>
      </el-col>

      <el-col :span="4" class="card-panel-col">
        <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row><h3>RHI线程</h3></el-row>
          <el-row type="flex" justify="start">平均时间: {{ outlineData.RHIThreadTime.avg_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最大时间: {{ outlineData.RHIThreadTime.max_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最小时间: {{ outlineData.RHIThreadTime.min_value.toFixed(1) }}ms </el-row>
        </div>
      </el-col>
      <el-col :span="4" class="card-panel-col">
        <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row><h3>GPU</h3></el-row>
          <el-row type="flex" justify="start">平均时间: {{ outlineData.GPUTime.avg_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最大时间: {{ outlineData.GPUTime.max_value.toFixed(1) }}ms </el-row>
          <el-row type="flex" justify="start">最小时间: {{ outlineData.GPUTime.min_value.toFixed(1) }}ms </el-row>
        </div>
      </el-col>
    </el-row>

  <el-row :gutter="100" class="panel-group" >
      <el-col :span="5" class="card-panel-pie-col">
        <div style="height:350px" id="framePieChart"></div>
      </el-col>
      <el-col :span="5" class="card-panel-pie-col">
        <div style="height:350px" id="gameThreadPieChart"></div>
      </el-col>
      <el-col :span="5" class="card-panel-pie-col">
        <div style="height:350px" id="renderThreadPieChart"></div>
      </el-col>
      <el-col :span="5" class="card-panel-pie-col">
        <div style="height:350px" id="rhiThreadPieChart"></div>
      </el-col>
      <el-col :span="4" class="card-panel-pie-col">
        <div style="height:350px" id="gpuPieChart"></div>
      </el-col>
  </el-row>

  </div>
</template>

<script>
let echarts = require('echarts/lib/echarts')
require('echarts/lib/chart/pie')
require('echarts/lib/component/tooltip')
require('echarts/lib/component/title')
require('echarts/lib/component/legend')
require('echarts/lib/component/grid')

export default {
  props: {
  },

  data () {
    return {
      outlineData: null,
      dataReady: false
    }
  },

  mounted () {
    this.loadOutlineData()
  },

  methods: {
    async loadOutlineData () {
      let dataURL = 'http://192.168.182.128/assetdb/pub/perf/get_perf_outline.php?run_id=4'
      const {data: res} = await this.$http.get(dataURL)
      this.outlineData = res
      this.dataReady = true
      this.initPieChart()
    },

    initPieChart () {
      let pieChartID = ['framePieChart', 'gameThreadPieChart', 'renderThreadPieChart', 'rhiThreadPieChart', 'gpuPieChart']
      let pieTitle = ['Frame', 'GameThread', 'RenderThread', 'RHIThread', 'GPU']

      for (var i = 0; i < pieChartID.length; i++) {
        var chartDom = document.getElementById(pieChartID[i])
        let chart = echarts.init(chartDom)
        let option = {
          title: {
            text: pieTitle[i],
            left: 'center'
          },
          tooltip: {
            trigger: 'item'
          },
          series: [
            {
              name: '占比',
              type: 'pie',
              radius: '50%',
              data: [
                { value: this.outlineData.FrameDetail[0][i], name: '<=5ms' },
                { value: this.outlineData.FrameDetail[1][i], name: '10ms' },
                { value: this.outlineData.FrameDetail[2][i], name: '15ms' },
                { value: this.outlineData.FrameDetail[3][i], name: '20ms' },
                { value: this.outlineData.FrameDetail[4][i], name: '30ms' },
                { value: this.outlineData.FrameDetail[5][i], name: '45ms' },
                { value: this.outlineData.FrameDetail[6][i], name: '60ms' },
                { value: this.outlineData.FrameDetail[7][i], name: '100ms' },
                { value: this.outlineData.FrameDetail[8][i], name: '>100ms' }
              ],
              emphasis: {
                itemStyle: {
                  shadowBlur: 10,
                  shadowOffsetX: 0,
                  shadowColor: 'rgba(0,0,0,0.5)'
                }
              }
            }
          ]
        }

        chart.setOption(option)
      }
    }
  }
}

</script>

<style>
</style>
