# GasByGas - Online gas request and delivery system

This project is developed for a coursework of advance software engineering module that in BEng (Hons) in Software Engineering degree awarded by London Metropolitan University.

Project developed using Laravel framework.
For user interface used a template from creative-tim.com call Soft UI Dashboard v1.0.0.

*Frontend version*: Soft UI Dashboard v1.0.0. More info at https://www.creative-tim.com/product/soft-ui-dashboard

## Prerequisites

- Install XAMPP
- Install Composer
- Install Lavel through Composer


## Installation

1. Clone this project inside to the `XAMPP/htdocs` folder
2. Create database call `gasbygas` in your MySQL database.
3. Navigate to ware project and open a terminal.
4. In your terminal run `composer install`
5. Copy `.env.example` to `.env` and updated the configurations (mainly the database configuration)
6. In your terminal run `php artisan key:generate`
7. Run `php artisan migrate --seed` to create the database tables and seed the roles and users tables.

## Usage
Register a user or login with default users
- **admin@gasbygas.com** and password **qwertyui** as admin. 
- **kumara@gasbygas.com** and password **qwertyui** as outlet manager.
- **aravinda@gasbygas.com** and password **qwertyui** as customer.
(make sure to run the migrations and seeders for these credentials to be available).

## Documentation
The documentation for the Soft UI Dashboard Laravel is hosted at their [website](https://soft-ui-dashboard-laravel.creative-tim.com/documentation/getting-started/overview.html).


## File Structure
```
app
├── Console
│   └── Kernel.php
├── Exceptions
│   └── Handler.php
├── Http
│   ├── Controllers
|   |   |__ API
|   |   |   |__ AdminController.php
|   |   |   |__ AuthenticationController.php
|   |   |   |__ ConsumerController.php
|   |   |   |__ GasController.php
|   |   |   |__ OutletController.php
|   |   |   |__ OutletManagerController.php
|   |   |   |__ RequestController.php
|   |   |   |__ ScheduleController.php
|   |   |   |__ UserController.php
│   │   └── ChangePasswordController.php
│   │   └──Controller.php
│   │   └──HomeController.php
│   │   └──RegisterController.php
│   │   └──ResetController.php
│   │   └──SessionController.php
│   ├── Kernel.php
│   └── Middleware
│       ├── Authenticate.php
│       ├── EncryptCookies.php
│       ├── PreventRequestsDuringMaintenance.php
│       ├── RedirectIfAuthenticated.php
│       ├── TrimStrings.php
│       ├── TrustHosts.php
│       ├── TrustProxies.php
│       └── VerifyCsrfToken.php
|__ Mail
|   |__ GasPickupReminderMail.php
|   |__ GasRequestConfirmMail.php
|   |__ GasRequestPaymentReminderMail.php
├── Models
│   └── admin.php
│   └── consumer.php
│   └── outlet_manager.php
│   └── outlet.php
│   └── requestModel.php
│   └── gas.php
│   └── schedule.php
│   └── User.php
├── Policies
│   └── UsersPolicy.php
├── Providers
│   ├── AppServiceProvider.php
│   ├── AuthServiceProvider.php
│   ├── BroadcastServiceProvider.php
│   ├── EventServiceProvider.php
│   └── RouteServiceProvider.php
|__ ConsumerType.php
|__ RequestStatusType.php
|__ RequestType.php
|__ StatusType.php
|__ UserType.php
config
├── app.php
├── auth.php
├── broadcasting.php
├── cache.php
├── cors.php
├── database.php
├── filesystems.php
├── hashing.php
├── logging.php
├── mail.php
├── queue.php
├── sanctum.php
├── services.php
├── session.php
├── view.php
|       
database  
+---public           
+---resources
|   +---lang
|   |           
|   |---views
|       |                 
|       +---admin
|       |   |-- admin-dashboard.blade.php
|       |   |-- admin-management.blade.php
|       |   |-- consumer-management.blade.php
|       |   |-- gas-management.blade.php
|       |   |-- gas-request-management.blade.php
|       |   |-- outlet-management.blade.php
|       |   |-- outlet-managers.blade.php
|       |   |-- schedule-management.blade.php
|       |      
|       +---consumer
|       |   |-- consumer-dashboard.blade.php
|       |
|       +---outlet
|       |   |-- outlet-dashboard.blade.php
|       |   |-- schedule-management.blade.php
|       |      
|       +---mail
|       |   |-- gas-pickup-reminder-mail.blade.php
|       |   |-- gas-request-confirm-mail.blade.php
|       |   |-- gas-request-payment-reminder-mail.blade.php
|       |      
|       +---layouts
|       |   |   
|       |   +---footers
|       |   |   |
|       |   |   +--guest
|       |   |         footer.blade.php
|       |   |
|       |   +---navbars
|       |       |
|       |       +--auth
|       |       |     nav.blade.php
|       |       |     dashboard-nav.blade.php
|       |       |     admin-sidebar.blade.php
|       |       |     outlet-sidebar.blade.php
|       |       |     
|       |       +--user_type
|       |           auth.blade.php
|       |           guest.blade.php
|       |--- app.blade.php
|       |           
|       +---session
|       |   |   login-session.blade.php
|       |   |   register.blade.php
|       |   |   
|       |   +---reset-password
|       |           resetPassword.blade.php
|       |           sendEmail.blade.php
|       |       
|                      
+---routes
|       api.php
|       channels.php
|       console.php
|       web.php
```
