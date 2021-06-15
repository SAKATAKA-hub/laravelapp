// require('./bootstrap');



// import './bootstrap'
// import Vue from 'vue'
// import Sample from './components/Sample'

// Vue.component('sample-component',require('./components/Sample.vue').default);

// const app = new Vue({
//     el: '#app',
//     components: {
//         Sample
//     }
// });


require('./bootstrap');

window.Vue = require('vue');

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);


// 追加
Vue.component('sample-component', require('./components/SampleComponent.vue').default);

const app = new Vue({
    el: '#app'
});

