<template>
  <div class="dashboard-container">
    <el-row :gutter="100" class="panel-group" >
      <el-col :span="4" class="card-panel-col">
        <div class="card-panel grid-content bg-purple">
        </div>
      </el-col>

      <el-col :span="4" class="card-panel-col"><div class="card-panel grid-content bg-purple">222</div></el-col>
      <el-col :span="4" class="card-panel-col"><div class="card-panel grid-content bg-purple">333</div></el-col>
      <el-col :span="4" class="card-panel-col"><div class="card-panel grid-content bg-purple">444</div></el-col>
      <el-col :span="4" class="card-panel-col"><div class="card-panel grid-content bg-purple">555</div></el-col>
      <el-col :span="4" class="card-panel-col"><div class="card-panel grid-content bg-purple">666</div></el-col>
    </el-row>

    <el-divider></el-divider>

	<div id="frame-chart">
      <el-row style="background:rgb(240, 242, 245);">
	    <frame-chart  />
	  </el-row>
    </div>

    <el-divider></el-divider>

  </div>
</template>

<script>

import FrameChart from '@/components/FrameChart'

export default{
  data() {
	return {
    }
  },
  
  methods: {
    changeFrameStep () {
      frameIntervalChanged = true
    }
  },

  components: {
    FrameChart
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
