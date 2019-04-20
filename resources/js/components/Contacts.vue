<template>
    <div class="container">
        <div class="row mt-5" v-if="$gate.isAdminOrAuthor()">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Contacts Table</h3>

                        <div class="card-tools" v-if="$gate.isAdmin()">
                            <button class="btn btn-success" @click="newModal">Add New <i class="fas fa-address-book"></i></button>
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
                                    <th>Address</th>
                                    <th>Phone</th>
                                    <th>Mobile</th>
                                    <th>Fax</th>
                                    <th>Registered at</th>
                                    <th v-if="$gate.isAdmin()">Modify</th>
                                </tr>
                                <tr v-for="contact in contacts.data" :key="contact.id">
                                    <td>{{contact.id}}</td>
                                    <td><img class="img-circle table-img" :src="getPhoto(contact.photo)" ></td>
                                    <td>{{contact.name}}</td>
                                    <td>{{contact.email}}</td>
                                    <td>{{contact.address}}</td>
                                    <td>{{contact.phone}}</td>
                                    <td>{{contact.mobile}}</td>
                                    <td>{{contact.fax}}</td>
                                    <td>{{contact.created_at|myFormatDate}}</td>
                                    <td v-if="$gate.isAdmin()"><a href="#" @click="editModal(contact)" title="Edit"><i class="fas fa-edit blue"></i></a> | <a href="#" @click="deleteContact(contact.id)" title="Remove"><i class="fas fa-trash red"></i></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <pagination :data="contacts" @pagination-change-page="getResults"></pagination>
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
                        <h5 v-show="editMode" class="modal-title" id="updateContactInfoLabel">Update Contact Info</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form @submit.prevent="editMode ? updateContact() : createContact()">
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
                                <textarea v-model="form.address" name="address" id="address" placeholder="Address" class="form-control" :class="{'is-invalid': form.errors.has('address')}"></textarea>
                                <has-error :form="form" field="address"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.phone" type="number" name="phone" id="phone" placeholder="Phone Number" class="form-control" :class="{'is-invalid': form.errors.has('phone')}">
                                <has-error :form="form" field="phone"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.mobile" type="number" name="mobile" id="mobile" placeholder="Mobile Number" class="form-control" :class="{'is-invalid': form.errors.has('mobile')}">
                                <has-error :form="form" field="phone"></has-error>
                            </div>
                            <div class="form-group">
                                <input v-model="form.fax" type="number" name="fax" id="fax" placeholder="Fax Number" class="form-control" :class="{'is-invalid': form.errors.has('fax')}">
                                <has-error :form="form" field="fax"></has-error>
                            </div>
                            <div class="form-group">
                                <img class="modal-img" :src="getPhoto(form.photo)">
                                <input type="file" @change="updatePhoto" name="photo" id="inputPhoto" class="form-input" :class="{'is-invalid': form.errors.has('photo')}">
                                <has-error :form="form" field="photo"></has-error>
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
                contacts: {},
                form: new Form({
                    id: '',
                    photo: '',
                    name: '',
                    email: '',
                    address: '',
                    phone: '',
                    mobile: '',
                    fax: ''
                })
            }
        },
        methods: {
            // get user photo
            getPhoto(photoname = null) {
                let photo = (photoname != null && photoname.length > 200) ? photoname : "img/contact/" + photoname;
                return (photoname != null) ? photo : 'img/contact/profile.png';
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
            // get all results (by page)
            getResults(page = 1) {
                axios.get('api/contact?page=' + page)
                    .then(response => {
                        this.contacts = response.data;
                    });
            },
            // update defined contact
            updateContact() {
                this.$Progress.start();
                this.form.put('api/contact/'+this.form.id)
                    .then(()=>{
                        $('#addNew').modal('hide');
                        Swal.fire('Updated!', 'This contact has been updated.', 'success');// show swal successfull message
                        this.$Progress.finish();
                        Fire.$emit('LoadContacts');
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                    });

            },
            // edit modal mode
            editModal(contact) {
                this.editMode = true;
                this.form.reset();
                this.form.fill(contact);
                $('#addNew').modal('show');
            },
            // new modal mode
            newModal() {
                this.editMode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            // load/get all contacts
            loadContacts() {
                if(this.$gate.isAdminOrAuthor()) {
                    axios.get('api/contact').then(({data})=>(this.contacts = data));
                }
            },
            // delete defined contact
            deleteContact(id) {
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
                        this.form.delete('api/contact/'+id).then(()=>{
                            if(result.value){
                                Swal.fire('Deleted!', 'This contact has been deleted.', 'success');// show swal successfull message
                            }
                            Fire.$emit('LoadContacts');                                            // create event LoadContacts
                        }).catch(()=>{
                            Swal.fire('Failed!', 'There was something wrong.', 'warning');      // show swal warning message
                        });
                    }
                })
            },
            // create a new contact
            createContact() {
                this.$Progress.start();                                                         // start progressbar
                this.form.post('api/contact').then(()=>{
                    Fire.$emit('LoadContacts');                                                    // create event LoadContacts
                    $('#addNew').modal('hide');                                                 // hide modal
                    toast.fire('Add new Contact', 'Contact created in successfully', 'success');      // show toast successfull message
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
                axios.get('api/findContact?q='+ query)
                    .then((data)=>{
                        this.contacts = data.data;
                        this.$Progress.finish();
                    })
                    .catch(()=>{
                        toast.fire('Failed!', 'There was something wrong.', 'warning');             // show swal warning message
                        this.$Progress.fail();
                    })
            });
            this.loadContacts();
            Fire.$on('LoadContacts',()=>{this.loadContacts()}); // will run when found a event called LoadContacts
        }
    }
</script>
