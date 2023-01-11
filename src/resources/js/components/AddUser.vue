<template>
    <div>
        <h3 class="text-center">Add User</h3>
        <div class="row d-flex justify-content-center mt-50">
            <div class="col-md-6">
                <form @submit.prevent="addUser">
                    <div class="form-group text-center">
                        <input type="file" id="file" ref="myPhoto" class="custom-file-input" @change="previewPhoto($event)">
                        <img :src="userPreviewPhoto" alt="photo" v-if="userPreviewPhoto" width="50">
                    </div>
                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" class="form-control" v-model="user.name">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="text" class="form-control" v-model="user.email">
                    </div>
                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" class="form-control" v-model="user.phone">
                    </div>
                    <div class="form-group">
                        <label>Position</label>
                        <select v-model="user.position_id" class="form-control">
                            <option disabled :value="null">Select position</option>
                            <option v-for="(position, key) in positions" :key="key" :value="position.id">{{ position.name }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" class="form-control" v-model="user.password">
                    </div>
                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" class="form-control" v-model="user.c_password">
                    </div>
                    <br>
                    <template v-if="errors">
                        <JsonViewer :value="errors" copyable boxed sort theme="jv-dark"/>
                        <br>
                    </template>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary" style="margin-right: 10px;">
                            <span v-if="!loading">Add User</span>
                            <span v-else>Loading..</span>
                        </button>
                        <button type="button" v-on:click="getToken()" v-if="!token" class="btn btn-warning">Get Token</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
 
<script>
    import FormHelper from '../mixins/form_helper';

    export default {
        mixins: [FormHelper],

        data() {
            return {
                token: null,
                userPreviewPhoto: null,
                user: {
                    photo: null,
                    name: 'test user',
                    email: 'test-user@gmail.com',
                    phone: '+380991111111',
                    position_id: 1,
                    password: 'qweqwe',
                    c_password: 'qweqwe',
                },
                positions: [],
                loading: false,
                errors: null,
            }
        },
        mounted() {
            axios
                .get(`/api/v1/positions`)
                .then((response) => {
                    this.positions = response.data.positions;
                });
        },
        methods: {
            addUser() {
                this.loading = true;
                
                this.sendData = new FormData();
                this.collectFormData(this.user);

                axios
                    .post('/api/v1/users', this.sendData, {
                        headers: {
                            'Token': this.token
                        },
                    })
                    .then((response) => {
                        this.errors = response.data;

                        // this.$router.push({name: 'home'})
                    })
                    .catch((error) => {this.errors = error.response.data;})
                    .finally(() => this.loading = false)
            },

            getToken() {
                axios
                    .get('/api/v1/token')
                    .then((response) => {
                        this.token = response.data.token

                        this.errors = null;
                    })
                    .catch((error) => {this.errors = error.response.data;})
            },

            previewPhoto(event) {
                const file = event.target.files[0];
                this.user.photo = file;
                this.userPreviewPhoto = URL.createObjectURL(file);
            }
        }
    }
</script>