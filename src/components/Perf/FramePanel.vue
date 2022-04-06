<template>
  <div>
    <div>
    <el-row :gutter="100" class="panel-group" >
      <el-col :span="8" class="card-panel-col" v-if="dataReady" >
       <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row type="flex" justify="center">基本信息</el-row>
          <el-row type="flex" justify="start">地图号: {{ outlineData.MapID }} </el-row>
          <el-row type="flex" justify="start">路径名: {{ outlineData.PathName }} </el-row>
          <el-row type="flex" justify="start">总帧数: {{ outlineData.FrameCount }} </el-row>
          <el-row type="flex" justify="start">平均FPS: {{ (1000/outlineData.FrameTime.avg_value).toFixed(1) }}帧 </el-row>
          <el-row type="flex" justify="start">平均Drawcall: {{ (outlineData.RHI_Drawcalls.avg_value).toFixed(0) }} </el-row>
          <el-row type="flex" justify="start">平均面数: {{ (outlineData.RHI_PrimitivesDrawn.avg_value).toFixed(0) }} </el-row>
          <el-row type="flex" justify="start">天气: {{ outlineData.GameWeather }} </el-row>
          <el-row type="flex" justify="start">游戏时间: {{ parseInt(outlineData.GameTime) }}点 </el-row>
          <el-row type="flex" justify="start">运行时间: {{ outlineData.RunDate}}-{{ outlineData.RunTime }}</el-row>
      </div>
      </el-col>
      <el-col :span="8" class="card-panel-col">
        <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row type="flex" justify="center">其他信息</el-row>
          <el-row type="flex" justify="start">物理内存平均: {{ (outlineData.PhysicalUsedMB.avg_value).toFixed(0) }}MB </el-row>
          <el-row type="flex" justify="start">物理内存峰值: {{ (outlineData.PhysicalUsedMB.max_value).toFixed(0) }}MB </el-row>
          <el-row type="flex" justify="start">虚拟内存平均: {{ (outlineData.VirtualUsedMB.avg_value).toFixed(0) }}MB </el-row>
          <el-row type="flex" justify="start">虚拟内存峰值: {{ (outlineData.VirtualUsedMB.max_value).toFixed(0) }}MB </el-row>
          <el-row type="flex" justify="start">RenderTarget池平均: {{ (outlineData.RenderTargetPoolSize.avg_value).toFixed(0) }}MB </el-row>
          <el-row type="flex" justify="start">RenderTarget池最大: {{ (outlineData.RenderTargetPoolSize.max_value).toFixed(0) }}MB </el-row>
          <el-row type="flex" justify="start">TextureStreaming池平均: {{ (outlineData.TextureStreaming_StreamingPool.avg_value).toFixed(0) }}MB </el-row>
          <el-row type="flex" justify="start">TextureStreaming池最大: {{ (outlineData.TextureStreaming_StreamingPool.max_value).toFixed(0) }}MB </el-row>
          <el-row type="flex" justify="start">UObject数量: {{ outlineData.TotalUObjectCount }} </el-row>
        </div>
      </el-col>
      <el-col :span="8" class="card-panel-col">
        <div class="card-panel grid-content bg-purple" v-if="dataReady">
          <el-row type="flex" justify="center">环境信息</el-row>
          <el-row type="flex" justify="start">操作系统: {{ outlineData.OSVersion }} </el-row>
          <el-row type="flex" justify="start">版本号: {{ outlineData.BuildNumber }} </el-row>
          <el-row type="flex" justify="start">CPU: {{ outlineData.CPUBrand }} {{ outlineData.CPUCoreNums }}核 {{ outlineData.CPUCoreNumsIncludingHyperThreads }}超线程 </el-row>
          <el-row type="flex" justify="start">GPU: {{ outlineData.PrimaryGPUBrand}} </el-row>
          <el-row type="flex" justify="start">物理内存: {{ Math.round(outlineData.TotalPhysicalMemory / (1024*1024*1024))}}GB </el-row>
          <el-row type="flex" justify="start">可用物理内存: {{ Math.round(outlineData.AvailablePhysicalMemory / (1024*1024*1024))}}GB </el-row>
          <el-row type="flex" justify="start">使用物理内存: {{ Math.round(outlineData.UsedPhysicalMemory / (1024*1024*1024))}}GB </el-row>
          <el-row type="flex" justify="start">IP地址: {{ outlineData.IPAddress }} </el-row>
          <el-row type="flex" justify="start">MAC地址: {{ outlineData.MacAddress }} </el-row>
        </div>
      </el-col>
    </el-row>
  </div>

  <el-divider></el-divider>

  <div>
    <el-row :gutter="100" class="panel-group" style="background:rgb(240, 242, 245);" >
        <el-col :span="8" class="card-panel-pie-col">
          <div style="height:400px" id="fpsPieChart"></div>
        </el-col>
        <el-col :span="8" class="card-panel-pie-col">
          <div style="height:400px" id="framePieChart"></div>
        </el-col>
        <el-col :span="8" class="card-panel-pie-col">
          <div style="height:400px" id="gameThreadPieChart"></div>
        </el-col>
    </el-row>
    <el-divider></el-divider>
    <el-row :gutter="100" class="panel-group" style="background:rgb(240, 242, 245);" >
        <el-col :span="8" class="card-panel-pie-col">
          <div style="height:400px" id="renderThreadPieChart"></div>
        </el-col>
        <el-col :span="8" class="card-panel-pie-col">
          <div style="height:400px" id="rhiThreadPieChart"></div>
        </el-col>
        <el-col :span="8" class="card-panel-pie-col">
          <div style="height:400px" id="gpuPieChart"></div>
        </el-col>
    </el-row>
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
    runID: Number
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
      let dataURL = '/perfapi/get_perf_outline.php?run_id=' + this.runID
      const {data: res} = await this.$http.get(dataURL)
      this.outlineData = res
      this.dataReady = true
      this.initPieChart()
    },

    initPieChart () {
      let pieChartID = ['fpsPieChart', 'framePieChart', 'gameThreadPieChart', 'renderThreadPieChart', 'rhiThreadPieChart', 'gpuPieChart']
      let pieTitle = ['FPS', 'Frame', 'GameThread', 'RenderThread', 'RHIThread', 'GPU']
      let pieSubText = [(1000 / this.outlineData.FrameTime.avg_value).toFixed(1), this.outlineData.FrameTime.avg_value.toFixed(1), this.outlineData.GameThreadTime.avg_value.toFixed(1), this.outlineData.RenderThreadTime.avg_value.toFixed(1), this.outlineData.RHIThreadTime.avg_value.toFixed(1), this.outlineData.GPUTime.avg_value.toFixed(1)]

      for (var i = 0; i < pieChartID.length; i++) {
        var chartDom = document.getElementById(pieChartID[i])
        let chart = echarts.init(chartDom)

        let unit = 'ms'
        if (pieChartID[i] === 'fpsPieChart') {
          unit = '帧'
        }

        let option = {
          title: {
            text: pieTitle[i],
            subtext: '平均时间: ' + pieSubText[i] + unit,
            left: 'center'
          },
          tooltip: {
            trigger: 'item',
            formatter: '{b}<br/> 占比: {d}%<br/> 数量: {c}'
          },
          series: [
            {
              name: '占比',
              type: 'pie',
              radius: '50%',
              data: [
                { value: this.outlineData.FrameDetail[0][i], name: '<10' + unit },
                { value: this.outlineData.FrameDetail[1][i], name: '10-15' + unit },
                { value: this.outlineData.FrameDetail[2][i], name: '15-20' + unit },
                { value: this.outlineData.FrameDetail[3][i], name: '20-30' + unit },
                { value: this.outlineData.FrameDetail[4][i], name: '30-45' + unit },
                { value: this.outlineData.FrameDetail[5][i], name: '45-60' + unit },
                { value: this.outlineData.FrameDetail[6][i], name: '60-100' + unit },
                { value: this.outlineData.FrameDetail[7][i], name: '>100' + unit }
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
