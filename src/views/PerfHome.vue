<template>
  <div class="dashboard-container">
    <el-row :gutter="40" class="panel-group" >
      <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col"><div class="card-panel grid-content bg-purple">111</div></el-col>
      <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col"><div class="card-panel grid-content bg-purple">222</div></el-col>
      <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col"><div class="card-panel grid-content bg-purple">333</div></el-col>
      <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col"><div class="card-panel grid-content bg-purple">444</div></el-col>
    </el-row>
  </div>
</template>

<script>

import FrameChart from '@/components/FrameChart.vue'

export default{
  components: {
    FrameChart
  }
}

</script>

<style>
  .dashboard-container {
	 padding: 32px;
	 background-color: rgb(240, 242, 245);
	 position: relative;
   }

  .panel-group {
    margin-top: 18px;

    .card-panel-col {
      margin-bottom: 32px;
    }

    .card-panel {
      height: 108px;
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
    min-height: 36px;
  }
  .row-bg {
    padding: 10px 0;
    background-color: #f9fafc;
  }
</style>
