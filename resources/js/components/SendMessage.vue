<template>
<div>

<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
  Chat with Instructor
</button>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> {{ receivername }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form @submit.prevent="sendMessage()">
      <div class="modal-body">
        <textarea class="form-control" v-model="form.msg" rows="3" placeholder="Type Your Message"></textarea>
        <span class="text-success" v-if="successfulMessage.message">{{ successfulMessage.message }}</span>
        <span class="text-danger" v-if="errors.msg">{{ errors.msg[0] }}</span>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Send Message</button>
      </div>
      </form>

    </div>
  </div>
</div>
</div>
</template>


<script>

import axios from "axios";


    export default{
        props : ['receiverid','receivername'],

        data(){
            return{
                form: {
                    msg:"",
                    receiver_id: this.receiverid,
                },
                errors: {},
                successfulMessage: {},
            }
        },

        methods:{
            sendMessage(){
              this.errors = {};
              this.successfulMessage = {};


                axios.post('/send-message',this.form)
                .then((res) =>{
                    this.form.msg = "";
                    this.successfulMessage = res.data;
                }).catch((err) => {
                    this.errors = err.response.data.errors || {};
                });
            }
        }
    }
</script>