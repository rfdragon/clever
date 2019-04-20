# clever
**Contact List CRUD Laravel + Vue.JS**


In this project I have done the next points:

- Create this project with Laravel + VueJS + Bootstrap
- Use composer, npm and github
- Add and configure the template AdminLTE 3 for Administrator (https://adminlte.io/themes/dev/AdminLTE/index.html)
- Add and configure the Toastr (https://codeseven.github.io/toastr/) for alert messages
- Use vform for forms (https://github.com/cretueusebiu/vform)
- Use momentJS to format dates (https://momentjs.com/)
- Use Vue-Progressbar to use a nice progress bar (http://hilongjw.github.io/vue-progressbar/)
- Use Custom Event to Send HTTP Request
- Add and configure Laravel Passport for API Auth (https://laravel.com/docs/5.8/passport)
- Use Base64 Encoding for upload files (photo)
- Use Image Intervention (http://image.intervention.io/) for edit files (photo)
- Use Authorization Gates (https://laravel.com/docs/5.8/authorization#gates) for user permissions
- Use Laravel Vue Pagination (https://github.com/gilbitron/laravel-vue-pagination)
- Use Debounce for search (https://lodash.com/docs/4.17.11#debounce) for better performance in searches
- Use Laravel Page Speed (https://github.com/renatomarinho/laravel-page-speed) to compress HTML and load faster


## To use our demo account, please use the next data to access:

**Admin: admin@demo.pt | 123456789**

**Author: author@demo.pt | 123456789**

**User: user@demo.pt | 123456789**

Or you can register you're own account. Enjoy it. I hope you liked.

# To start:

### 1. Clone GitHub repo for this project locally

Run <code>git clone https://github.com/rfdragon/clever.git</code>

### 2. Cd into your project

### 3. Install Composer Dependencies

Run <code>composer install</code>

### 4. Install NPM Dependencies

Run <code>npm install</code>

### 5. Create a copy of your .env file

Run <code>copy .env.example .env</code>

### 6. Generate an app encryption key

Run <code>php artisan key:generate</code>

### 7. Create an empty database for our application

### 8. In the .env file, add database information to allow Laravel to connect to the database

### 9. Migrate the database

Run <code>php artisan migrate</code>

### 10. (optional) if you get an error 500 ("... \oauth-public.key" does not exist or is not readable"), please run the next code:

Run <code>php artisan passport:keys</code>


