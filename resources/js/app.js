require('./bootstrap');
var getCarsURL = "/cars";

import Modal from './modal.vue'; 
var ModalComponent = Vue.component('my-modal-component', Modal);

var app = new Vue({
    el: "#app",
    data: {
        showModal: false,
        message: "Hello World!",
        cars: [],
        carid: 0
    },
    methods: {
        getCars: function(event) {
            axios.get(getCarsURL).then(response => { 
                this.cars = response.data.cars;
            })
        },
        editCar: function(id) {
            this.carid = id;
            this.showModal = true;
        }
    },
    components: {
        'my-modal-component': ModalComponent
    }
});

axios.get(getCarsURL).then(response => { 
    app.cars = response.data.cars;
})