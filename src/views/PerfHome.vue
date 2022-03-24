<template>
  <div class="dashboard-container">
	<frame-panel />

    <el-divider></el-divider>

	<div id="frame-chart">
      <el-row type="flex" style="background:fff;" justify="start">
        <el-col :span="4">
	      <label>合并帧:</label>
	      <el-select v-model="value" placeholder="请选择" @change="onFrameSelectChange">
		    <el-option
		    v-for="item in frame_options"
		    :key="item.value"
		    :label="item.label"
		    :value="item.value">
		    </el-option>
	      </el-select>
        </el-col>
	  </el-row>

    <el-row style="background:rgb(240, 242, 245);">
      <frame-chart  :frame-step=value :key="frameChartKey"/>
	  </el-row>
    </div>

    <el-divider></el-divider>
  </div>
</template>

<script>

import FrameChart from '@/components/FrameChart'
import FramePanel from '@/components/FramePanel'

export default{
  data() {
	return {
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

     value: 100,
     frameChartKey: 0
    }
  },
  
  methods: {
    onFrameSelectChange() {
		this.frameChartKey += 1
    }
  },

  components: {
    FrameChart,
    FramePanel
  }
}

</script>

<style>
  .dashboard-container {
     padding: 32px;
     position: relative;
   }

  .panel-group {
    margin-top: 1px;
    background-color: rgb(240, 242, 245);

    .card-panel-col {
      margin-bottom: 32px;
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
    border-radius: 4px;
    min-height: 76px;
  }
</style>
