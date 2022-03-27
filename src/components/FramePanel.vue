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

  <div>
    <div style="width:100%;height:300px" ref="framePieChart"></div>
  </div>

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
      let dataURL = 'http://192.168.208.128/assetdb/perf/get_perf_outline.php?run_id=4'
      const {data: res} = await this.$http.get(dataURL)
      this.outlineData = res
      this.dataReady = true
      this.initPieChart()
    },

    initPieChart () {
      this.chart = echarts.init(this.$refs.framePieChart)

      let option = {
        title: {
          text: 'Frame',
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
              { value: 1048, name: 'Search Engine' },
              { value: 735, name: 'Direct' },
              { value: 580, name: 'Email' },
              { value: 484, name: 'Union Ads' },
              { value: 300, name: 'Video Ads' }
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

      this.chart.setOption(option)
    }
  }
}

</script>

<style>
</style>
