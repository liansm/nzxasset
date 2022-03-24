import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import FrameChart from '@/components/FrameChart'
import PerfHome from '@/views/PerfHome'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/test_echart',
      name: 'FrameChart',
      component: FrameChart
    },
    {
      path: '/perf_home',
      name: 'PerfHome',
      component: PerfHome
    }
  ]
})
