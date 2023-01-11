<template>
    <div>
        <h3 class="text-center">View User</h3>
        <div class="row d-flex justify-content-center mt-50">
            <div class="col-md-6">
                <div class="form-group text-center">
                    <img :src="user.photo" alt="photo">
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
                    <input type="text" class="form-control" v-model="user.position.name">
                </div>
                <br>
                <div class="form-group">
                    <a href="/" class="btn btn-primary">Back</a>
                </div>
            </div>
        </div>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                user: {}
            }
        },
        created() {
            axios
                .get(`/api/v1/users/${this.$route.params.id}`)
                .then((response) => {
                    this.user = response.data.user;
                });
        }
    }
</script>