<template>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <div class="card card-widget widget-user">
                    <!-- Add the bg color to the header using any of the bg-* classes -->
                    <div class="widget-user-header text-white" style="background-image: url('./img/photo1.png');">
                        <h3 class="widget-user-username">{{ this.form.name }}</h3>
                        <h5 class="widget-user-desc text-capitalize">{{ this.form.type }}</h5>
                    </div>
                    <div class="widget-user-image">
                        <img class="img-circle" :src="getProfilePhoto()" alt="User Avatar">
                    </div>
                </div>

                <div class="card">
                    <div class="card-header p-2">
                        <h1>Profile Information</h1>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label for="inputName" class="col-sm-12 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" v-model="form.name" name="name" class="form-control" id="inputName" placeholder="Name" :class="{'is-invalid': form.errors.has('name')}">
                                    <has-error :form="form" field="name"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail" class="col-sm-12 control-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" v-model="form.email" name="email" class="form-control" id="inputEmail" placeholder="Email Address" :class="{'is-invalid': form.errors.has('email')}">
                                    <has-error :form="form" field="email"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputBio" class="col-sm-12 control-label">Bio</label>
                                <div class="col-sm-12">
                                    <textarea v-model="form.bio" class="form-control" name="bio" id="inputBio" placeholder="Bio" :class="{'is-invalid': form.errors.has('bio')}"></textarea>
                                    <has-error :form="form" field="bio"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPhoto" class="col-sm-12 control-label">Profile Photo</label>
                                <div class="col-sm-12">
                                    <input type="file" @change="updatePhoto" name="photo" id="inputPhoto" class="form-input" :class="{'is-invalid': form.errors.has('photo')}">
                                    <has-error :form="form" field="photo"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-sm-12 control-label">Password (leave empty if not changing)</label>
                                <div class="col-sm-12">
                                    <input type="password" class="form-control" id="inputPassword" placeholder="Password" :class="{'is-invalid': form.errors.has('password')}">
                                    <has-error :form="form" field="password"></has-error>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-12">
                                    <button @click.prevent="updateProfile" type="submit" class="btn btn-success">Update</button>
                                </div>
                            </div>
                        </form>
                    </div><!-- /.card-body -->
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
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
            // get profile photo
            getProfilePhoto() {
                let photo = (this.form.photo != null && this.form.photo.length > 200) ? this.form.photo : "img/profile/" + this.form.photo;
                return (this.form.photo != null) ? photo : 'img/profile/profile.png';
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
            // update profile
            updateProfile() {
                this.$Progress.start();
                this.form.put('api/profile')
                    .then(()=>{
                        this.$Progress.finish();
                        toast.fire('Updated', 'Profile updated in successfully', 'success');
                    })
                    .catch(()=>{
                        this.$Progress.fail();
                        toast.fire('Update failed', 'Please complete all required files', 'error');
                    });
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            axios.get('api/profile')
                .then(({data})=>(this.form.fill(data)));
        }
    }
</script>
