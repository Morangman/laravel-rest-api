<template>
    <div>
        <h3 class="text-center">All Users</h3><br/>
 
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="model in users" :key="model.id">
                <td>{{ model.id }}</td>
                <td>{{ model.name }}</td>
                <td>{{ model.email }}</td>
                <td>{{ model.created_at }}</td>
                <td>{{ model.updated_at }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <router-link :to="{name: 'edit', params: { id: model.id }}" class="btn btn-primary">Edit</router-link>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
        <button class="btn btn-primary" v-on:click="loadMore()">
            <span v-if="!loading">Show more</span>
            <span v-else>Loading..</span>
        </button>
    </div>
</template>
 
<script>
    export default {
        data() {
            return {
                users: [],
                loading: false,
                params: {
                    page: 1,
                    count: 6,
                    offset: 0,
                }
            }
        },
        mounted() {
            this.getUsers();
        },
        methods: {
            getUsers() {
                this.loading = true;
                
                axios
                    .get('/api/v1/users', {params: this.params})
                    .then(response => {
                        response.data.data.forEach( product => {
                            this.users.push(product);
                        });

                        this.loading = false;
                    });
            },

            loadMore() {
                this.params.page++;
                this.getUsers();
            },
        }
    }
</script>