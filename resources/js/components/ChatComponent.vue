<template>
  <div class="row">
    <div class="col-8">
      <div class="card card-default">
        <div class="card-header center darkgray">Real Time Chat App with Laravel 8 Vue Js and Pusher</div>
          <div class="card-body p-0 black">
              <!-- this a Box to show new messages -->
            <ul class="list-unstyled" style="height:300px; overflow-y:scroll;color:white" v-chat-scroll>
              <li class="p-2"  v-for="(message, index) in messages" :key="index">
                <div v-if="message.fromm  != user.id" class="container card bg-info mb-4 float-start" style="width: 58%;">
                  <div v-if="message.id  !== message.id">
                  </div>
                    <div v-else>
                      <strong>{{ message.fromName }} <br></strong>  
                               {{ message.message }}<br>
                               {{message.date}} 
                    </div>
                  </div>
                <div v-else class="container card bg-warning mb-4" style="color:black;float:write">
                  <strong style="color:red">me</strong>
                               {{ message.message }}<br>
                               {{message.date}}
                    <button @click="deletePost(message.code)" class="btn btn-warning">Remove</button>
                </div>
              </li>
          </ul>
        </div>
        <!-- this is input to write new Message -->
        <input
                    @keydown="sendTypingEvent"
                    @keyup.enter="sendMessage"
                    v-model="newMessage"
                    type="text"
                    name="message"
                    placeholder="Enter your message..."
                    class="form-control black">
        </div>
      </div>
      <div class="col-4">
        <div class="card card-default">
            <!-- this is to show Active User are online or offline -->
          <div class="card-header center">Active Users</div>
            <div class="card-body">
              <p class="black white padding center">{{ typing }}</p>
                <ul>
                  <li class="py-2 center" v-for="(user, index) in users" :key="index">
                    {{ user.name }} 
                  </li>
                </ul>
            </div>
          </div>
        </div>
      </div>
</template>
<script>
    export default {
        props:['user'],
        data() {
            return {
                messages: [],
                newMessage: '',
                newMessag: '',
                users:[],
                activeUser: false,
                typingTimer: false,
                typing: '',
            }
        },
        
        created() {
            var vm = this;
            this.fetchMessages();
            const url = window.location.href;
            const groupId = url.split("/").slice(-1)[0];
            vm.groupId = groupId;
            console.log(groupId);
            // this function get new message from pusher at real time
            Echo.join('chat'+this.user.id)
                .listen('ChatEvent',(event) => {
                    this.fetchMessages();
                    console.log('delete');
                    this.messages.push(event.chat);
                    this.typing =  'one Message';
                    this.typingTimer = setTimeout(() => {
                       this.typing = '';
                   }, 1000);
                })
                .listenForWhisper('typing', user => {
                   this.activeUser = user;
                   this.typing =  'typing';
                    this.typingTimer = setTimeout(() => {
                       this.typing = '';
                   }, 1000);
                })
        },
        methods: {
            // this is for get all messsage from database
            fetchMessages() {
                var vm = this;
                const url = window.location.href;
                const groupId = url.split("/").slice(-1)[0];
                axios.get('/messages/'+groupId).then(response => {
                    this.messages = response.data;
                })
            },  // this is for send new message to controller and save in database
            sendMessage() {
                this.messages.push({
                    user: this.user,
                    message: this.newMessage,
                    fromm: this.user.id
                });
                var vm = this;
                const url = window.location.href;
                const groupId = url.split("/").slice(-1)[0];
                const current = new Date();
                const time = current.getHours() + ":" + current.getMinutes();
                
                axios.post('/messages/'+groupId, {message: this.newMessage,fromm: this.user.id, date: time});
                this.fetchMessages();
                this.newMessage = '';
            },  // this is for remove a message that User made that
            deletePost(id) {
                axios.post('/delete/'+id).then(response => {
                   this.fetchMessages()
                   console.log(response)
                })
               .catch(error => console.log(error));
                this.messages.splice(id, 1);
            },
            sendTypingEvent() {
                var vm = this;
                const url = window.location.href;
                const groupId = url.split("/").slice(-1)[0];
                Echo.join('chat'+this.user.id)
                    .whisper('typing', this.user);
                console.log(this.user.name + ' is typing now')
            }, // this is for get current data
            currentDateTime() {
               const current = new Date();
               const date = current.getFullYear()+'-'+(current.getMonth()+1)+'-'+current.getDate();
               const time = current.getHours() + ":" + current.getMinutes();
               const dateTime = date +' '+ time;
               
               console.log(date+time+`Y`)
               return time;
                
            }, // by this function the Usr can see who is offline or online
            listen() {
                var vm = this;
                const url = window.location.href;
                const groupId = url.split("/").slice(-1)[0];
                Echo.join('send'+groupId)
                .here(user => {
                    this.users = user;
                })
                    .joining((user) => {
                       this.typing = user.name  + ' is online';
                       this.users.push(user);
                       this.typingTimer = setTimeout(() => {
                       this.typing = '';
                       }, 3000);
                       console.log('chat online'+user.id)
                    })
                    .leaving((user) => {
                       this.typing = user.name  + ' is off line';
                       this.typingTimer = setTimeout(() => {
                       this.typing = '';
                      }, 3000);
                    });
                   
            }
        },
        mounted () {
          this.fetchMessages();
          this.listen();
        }
    }
</script>