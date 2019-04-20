<template>
    <div class="container">
        <div class="row col-md-12">
            <div v-if="$gate.isAdminOrAuthor()" class="col-md-4 text-center text-capitalize mt-5">
                <router-link to="/contacts">
                    <div class="button circle orange">
                        <i class="fas fa-address-book"></i>
                        <h3>Contacts</h3>
                    </div>
                </router-link>
            </div>
            <div v-if="$gate.isAdminOrAuthor()" class="col-md-4 text-center text-capitalize mt-5">
                <router-link to="/users">
                    <div class="button circle teal">
                        <i class="fas fa-users"></i>
                        <h3>Users</h3>
                    </div>
                </router-link>
            </div>
            <div v-if="$gate.isAdmin()" class="col-md-4 text-center text-capitalize mt-5">
                <router-link to="/developer">
                    <div class="button circle red">
                        <i class="fas fa-cogs"></i>
                        <h3>Developer</h3>
                    </div>
                </router-link>
            </div>
            <div class="col-md-4 text-center text-capitalize mt-5">
                <router-link to="/profile">
                    <div class="button circle green">
                        <i class="fas fa-user-alt"></i>
                        <h3>Profile</h3>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
