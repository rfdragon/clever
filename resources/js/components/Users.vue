<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Users Table</h3>

                        <div class="card-tools" v-if="$gate.isAdmin()">
                            <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-user-plus"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>ID</th>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Type</th>
                                    <th>Bio</th>
                                    <th>Registered at</th>
                                    <th v-if="$gate.isAdmin()">Modify</th>
                                </tr>
                                <tr v-for="user in users.data" :key="user.id">
                                    <td>{{user.id}}</td>
                                    <td><img class="img-circle table-img" :src="getPhoto(user.photo)" onerror="this.src='img/profile/profile.png'"></td>
                                    <td>{{user.name}}</td>
                                    <td>{{user.email}}</td>
                                    <td>{{user.type|textCapitalize}}</td>
                                    <td>{{user.bio}}</td>
                                    <td>{{user.created_at|myFormatDate}}</td>
                                    <td v-if="$gate.isAdmin()"><a @click="editModal(user)" title="Edit"><i class="fas fa-edit blue"></i></a> | <a @click="deleteUser(user.id)" title="Remove"><i class="fas fa-trash red"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <pagination :data="users" @pagination-change-page="getResults"></pagination>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div v-if="!$gate.isAdminOrAuthor()">
            <not-found></not-found>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 v-show="!editMode" class="modal-title" id="addNewLabel">Add New</h5>
                        <h5 v-show="editMode" class="modal-title" id="updateUserInfoLabel">Update User Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateUser() : createUser()">
                        <div class="modal-body">
                            <div class="form-group">
                                <input v-model="form.name" type="text" name="name" id="name" placeholder="Name" class="form-control" :class="{'is-invalid': form.errors.has('name')}">
                                <has-error :form="form" field="name"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.email" type="email" name="email" id="email" placeholder="Email Address" class="form-control" :class="{'is-invalid': form.errors.has('email')}">
                                <has-error :form="form" field="email"></has-error>
                            </div>
                            <div class="form-group">
                                <textarea v-model="form.bio" name="bio" id="bio" placeholder="Short bio for user (Optional)" class="form-control" :class="{'is-invalid': form.errors.has('bio')}"></textarea>
                                <has-error :form="form" field="bio"></has-error>
                            </div>
                            <div class="form-group">
                                <select v-model="form.type" name="type" id="type" class="form-control" :class="{'is-invalid': form.errors.has('type')}">
                                    <option value="">Select User Role</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">Standard User</option>
                                    <option value="author">Author</option>
                                </select>
                                <has-error :form="form" field="type"></has-error>
                            </div>
                            <div class="form-group">
                                <img class="modal-img" :src="getPhoto(form.photo)">
                                <input @change="updatePhoto" type="file" name="photo" id="inputPhoto" class="form-input" :class="{'is-invalid': form.errors.has('photo')}">
                                <has-error :form="form" field="photo"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.password" type="password" name="password" id="password" placeholder="Password" class="form-control" :class="{'is-invalid': form.errors.has('password')}">
                                <has-error :form="form" field="password"></has-error>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                            <button v-show="editMode" type="submit" class="btn btn-success">Update</button>
                            <button v-show="!editMode" type="submit" class="btn btn-success">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Modal -->
    </div>
</template>

<script>
    export default {
        data() {
            return {
                editMode: false,
                users: {},
                form: new Form({
                    id: '',
                    name: '',
                    email: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods: {
            // get user photo
            getPhoto(photoname = null) {
                let photo = (photoname != null && photoname.length > 200) ? photoname : "img/profile/" + photoname;
                return (photoname != null) ? photo : 'img/profile/profile.png';
            },
            // update user photo
            updatePhoto(e) {
                let file = e.target.files[0];
                let reader = new FileReader();

                if(file['size'] < 2111775) { // 2111775 = 2 MB
                    reader.onloadend = (file) => {
                        this.form.photo = reader.result;
                    }
                    reader.readAsDataURL(file);
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'Oops...',
                        text: 'You are uploading a large file (max size: 2MB).'
                    })
                }
            },
            // get all users (by page)
            getResults(page = 1) {
                axios.get('api/user?page=' + page)
                    .then(response => {
                        this.users = response.data;
                    });
            },
            // update selected user
            updateUser() {
                this.$Progress.start();
                this.form.put('api/user/'+this.form.id)
                    .then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!', 'This user has been updated.', 'success');// show swal successfull message
                        this.$Progress.finish();
                        Fire.$emit('LoadUsers');
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    });

            },
            // edit modal mode
            editModal(user) {
                this.editMode = true;
                this.form.reset();
                this.form.fill(user);
                $('#addNew').modal('show');
            },
            // new modal mode
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            // get/load all users
            loadUsers() {
                if(this.$gate.isAdminOrAuthor()) {
                    axios.get('api/user').then(({data})=>(this.users = data));
                }
            },
            // delete selected user
            deleteUser(id) {
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result)=>{
                    if(result.value) {
                        // send request to the server
                        this.form.delete('api/user/'+id).then(()=>{
                            if(result.value){
                                Swal.fire('Deleted!', 'This user has been deleted.', 'success');// show swal successfull message
                            }
                            Fire.$emit('LoadUsers');                                            // create event LoadUsers
                        }).catch(()=>{
                            Swal.fire('Failed!', 'There was something wrong.', 'warning');      // show swal warning message
                        });
                    }
                })
            },
            // create new user
            createUser() {
                this.$Progress.start();                                                         // start progressbar
                this.form.post('api/user').then(()=>{
                    Fire.$emit('LoadUsers');                                                    // create event LoadUsers
                    $('#addNew').modal('hide');                                                 // hide modal
                    toast.fire('Add new User', 'User created in successfully', 'success');      // show toast successfull message
                    this.$Progress.finish();                                                    // finish progressbar
                })
                .catch(()=>{
                    toast.fire('Failed!', 'There was something wrong.', 'warning');             // show swal warning message
                    this.$Progress.fail();                                                    // finish progressbar
                })
            }
        },
        created() {
            Fire.$on('searching',()=>{
                this.$Progress.start();
                let query = this.$parent.search;
                axios.get('api/findUser?q='+ query)
                    .then((data)=>{
                        this.users = data.data;
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        toast.fire('Failed!', 'There was something wrong.', 'warning');             // show swal warning message
                        this.$Progress.fail();
                    })
            });
            this.loadUsers();
            Fire.$on('LoadUsers',()=>{this.loadUsers()}); // will run when found a event called LoadUsers
        }
    }
</script>
