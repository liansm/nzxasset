<template>
  <div>
  	<span>每行24分栏布局</span>
    <el-row>
      <el-col :span="12" class="lightgreen-box">示例1</el-col>
      <el-col :span="12" class="orange-box">示例1</el-col>
    </el-row>
    <el-divider></el-divider>
  </div>
</template>

<script>
export default{
  data () {
    return {
    }
  } 
}
</script>

<style scoped>
	.lightgreen-box {
	  background-color: lightgreen;
	  height: 24px;
	}
	.orange-box {
	  background-color: orange;
	  height: 24px;
	}
</style>
