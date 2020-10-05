<template>
    <div class="modal-mask">
        <div class="modal-wrapper">
        <div class="modal-container">

            <div class="modal-header">
                <slot name="header">
                    default header
                </slot>
            </div>

            <div class="modal-body">
                <slot name="body">
                    <div v-if="errors.length > 0" class="alert alert-danger">
                        <b>Please correct the following error(s):</b>
                        <ul>
                            <li v-for="error in errors">{{ error }}</li>
                        </ul>
                    </div>

                    <div class="row">
                        <label class="field-label" for="make">Make</label>
                        <div class="field-container">
                            <input v-model="car.make" placeholder="Enter a make">
                        </div>
                    </div>
                    <div class="row top20">
                        <label class="field-label" for="make">Model</label>
                        <div class="field-container">
                            <input v-model="car.model" placeholder="Enter a model">
                        </div>
                    </div>
                    <div class="row top20">
                        <label class="field-label" for="make">Year</label>
                        <div class="field-container">
                            <input v-model="car.year" placeholder="Enter a year">
                        </div>
                    </div>
                    <div class="row top20">
                        <label class="field-label" for="make">VIN</label>
                        <div class="field-container">
                            <input v-model="car.vin" placeholder="Enter a VIN #">
                        </div>
                    </div>
                    <div class="row top20">
                        <label class="field-label" for="make">Licence Plate</label>
                        <div class="field-container">
                            <input v-model="car.plate" placeholder="Enter a plate #">
                        </div>
                    </div>
                    <div class="row top20">
                        <label class="field-label" for="make">Color</label>
                        <div class="field-container">
                            <input v-model="car.color" placeholder="Enter a color">
                        </div>
                    </div>
                </slot>
            </div>

            <div class="modal-footer">
                <slot name="footer">
                    <div v-if="id !== 0" style="float: left;">
                        <button class="btn btn-danger" v-on:click="deleteCar">
                            Delete
                        </button>
                    </div>
                    <div style="display:flex;float:right;">
                        <button class="btn btn-secondary" @click="$emit('close')">
                            Cancel
                        </button>
                        <button class="btn btn-primary" v-on:click="save">
                            Save
                        </button>
                    </div>
                    <div style="clear:both;"></div>
                </slot>
            </div>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            id: Number,
        },
        data() {
            return {
                car: {
                    id: 0,
                    make: "",
                    model: "",
                    year: (new Date()).getFullYear(),
                    vin: "",
                    plate: "",
                    color: ""
                },
                errors: []
            }
        },
        mounted() {
            this.prepareComponent();
        },
        methods:{
            save(e){
                var $this = this;
                e.preventDefault();
                
                var formErrors = [];

                if (this.car.make === "") {
                    formErrors.push("Please enter a Car Maker.");
                }

                if (this.car.model === "") {
                    formErrors.push("Please enter a Car Model.");
                }

                if (this.car.vin === "") {
                    formErrors.push("Please enter a VIN.");
                }

                if (this.car.plate === "") {
                    formErrors.push("Please enter a License Plate Number.");
                }

                if (this.car.color === "") {
                    formErrors.push("Please enter a Color.");
                }

                if (formErrors.length > 0) {
                    this.errors = formErrors;
                } else {
                    // Save
                    var data = this.car;
                    data.id = this.id;

                    axios.post('/cars',data).then(r=> {
                        this.$emit('postcomplete');
                        this.$emit('close');
                    });
                }
            },
            deleteCar: function() {
                var data = {
                    id: this.id
                };

                axios.post('/cars/delete', data).then(r=> {
                    this.$emit('postcomplete');
                    this.$emit('close');
                });
            },
            prepareComponent(){
                var $this = this;
                
                if (this.id !== 0) {
                    axios.get('/cars/' + $this.id).then(r => {
                        this.car = r.data.car;
                    });
                }
            },

        }
    }
</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        display: table;
        transition: opacity 0.3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

    .modal-container {
        width: 500px;
        margin: 0px auto;
        padding: 20px 30px;
        background-color: #fff;
        border-radius: 2px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
        transition: all 0.3s ease;
        font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header h3 {
        margin-top: 0;
        color: #42b983;
    }

    .modal-body {
        margin: 20px 0;
    }

    .modal-default-button {
        float: right;
    }

    /*
    * The following styles are auto-applied to elements with
    * transition="modal" when their visibility is toggled
    * by Vue.js.
    *
    * You can easily play with the modal transition by editing
    * these styles.
    */

    .modal-enter {
        opacity: 0;
    }

    .modal-leave-active {
        opacity: 0;
    }

    .modal-enter .modal-container,
    .modal-leave-active .modal-container {
        -webkit-transform: scale(1.1);
        transform: scale(1.1);
    }

    .field-label {
        font-weight: bold;
    }

    .field-container {
        width: 100%;
    }

    .modal-footer {
        display: block;
    }
</style>