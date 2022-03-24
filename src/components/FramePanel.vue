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

  </div>
</template>

<script>

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
      let data_url = 'http://192.168.182.128/assetdb/pub/perf/get_perf_outline.php?run_id=4';
      const {data: res} = await this.$http.get(data_url);
      this.outlineData = res 
      this.dataReady = true
	}
  }
}

</script>

<style>

