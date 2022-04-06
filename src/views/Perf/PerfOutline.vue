<template>
  <div class="dashboard-container">
    <frame-panel :runID=currentRunID />
    <el-divider></el-divider>

    <div v-for="(chart,index) in charts" :key='index'>
      <el-row style="background:rgb(240, 242, 245);">
        <perf-line-chart  :frameStep=chart.frameStep :requestParam=chart.requestParams :runID=currentRunID :legendArr=chart.legendArr :typeArr=chart.typeArr
          :title=chart.title :yAxisName=chart.yAxisName :yAxisMax=chart.yAxisMax :key=chart.chartKey />
        <label>合并:</label>
        <el-select v-model="chart.frameStep" placeholder="请选择" @change="onChartChange(index)">
          <el-option v-for="item in frameOptions" :key="item.value" :label="item.label" :value="item.value">
          </el-option>
        </el-select>
      </el-row>
      <el-divider></el-divider>
    </div>

  </div>
</template>

<script>

import FramePanel from '@/components/Perf/FramePanel'
import PerfLineChart from '@/components/Perf/PerfLineChart'

export default{
  data () {
    return {
      frameOptions: [{ value: 100, label: '100帧' }, { value: 50, label: '50帧' }, { value: 20, label: '20帧' }, { value: 10, label: '10帧' }, { value: 5, label: '5帧' }, { value: 1, label: '单帧' }],
      currentRunID: parseInt(this.$route.params.id),
      charts: [
        {
          requestParams: 'FrameTime',
          legendArr: ['FPS'],
          typeArr: ['line'],
          frameStep: 100,
          chartKey: 0,
          title: 'FPS',
          yAxisName: '帧',
          yAxisMax: 0
        },

        {
          requestParams: 'FrameTime,GameThreadTime,RenderThreadTime,RHIThreadTime,GPUTime',
          legendArr: ['FrameTime', 'GameThreadTime', 'RenderThreadTime', 'RHIThreadTime', 'GPUTime'],
          typeArr: ['line', 'line', 'line', 'line', 'line'],
          frameStep: 100,
          chartKey: 0,
          title: 'Frame',
          yAxisName: 'ms',
          yAxisMax: 100
        },

        {
          requestParams: 'RHI_DrawCalls,DrawCall_HZB,DrawCall_Prepass,DrawCall_BasePass,DrawCall_ShadowDepths,DrawCall_ParticleSimulation,DrawCall_SlateUI',
          legendArr: ['RHI_DrawCalls', 'HZB', 'Prepass', 'BasePass', 'ShadowDepths', 'ParticleSimulation', 'SlateUI'],
          typeArr: ['line', 'line', 'line', 'line', 'line', 'line', 'line'],
          frameStep: 100,
          chartKey: 0,
          title: 'DrawCall',
          yAxisName: 'drawcall',
          yAxisMax: 0
        }
      ]
    }
  },

  methods: {
    onChartChange (index) {
      this.charts[index].chartKey += 1
    }
  },

  components: {
    FramePanel,
    PerfLineChart
  }
}

</script>

<style>
  .dashboard-container {
     padding: 2px;
     position: relative;
   }

  .panel-group {
    margin-top: 1px;
    background-color: rgb(240, 242, 245);

    .card-panel-col {
      margin-bottom: 10px;
    }

    .card-panel {
      height: 120px;
      cursor: pointer;
      font-size: 12px;
      position: relative;
      overflow: hidden;
      color: #666;
      background: #fff;
      box-shadow: 4px 4px 40px rgba(0, 0, 0, .05);
      border-color: rgba(0, 0, 0, .05);
     }
   }

  .bg-purple-dark {
    background: #99a9bf;
  }
  .bg-purple {
    background: #d3dce6;
  }
  .bg-purple-light {
    background: #e5e9f2;
  }
  .grid-content {
    border-radius: 20px;
    min-height: 76px;
    margin-left: 10px;
  }
</style>
